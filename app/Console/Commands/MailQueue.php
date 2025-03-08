<?php

namespace App\Console\Commands;

use App\Libraries\CommonFunction;
use App\Models\EmailQueue;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;
use Swift_TransportException;
use App\Mail\OtpSendMail;

class MailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:queue {limit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Email from Queue';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *  0   => Pending
     *  1   => Sent
     * -1   => In-Progress
     * -2   => Failed
     * @return mixed
     */
    public function handle()
    {
        
        $project_title = 'Notification System';
        $limit = $this->argument('limit');
        $limit = $limit > 0 ? $limit : 10;

        $queued_emails = EmailQueue::leftJoin('email_config', 'email_queue.config_id', '=', 'email_config.id')
            ->where(function ($query) {
                $query->where('email_queue.email_status', 0)
                    ->orWhere('email_queue.email_status', -2);
            })
            ->where('email_queue.no_of_try' ,'<',3)
            ->orderBy('email_queue.id', 'DESC')
            ->limit($limit)
            ->get(['email_queue.*', 'email_config.config']);


        if (count($queued_emails) > 0) {

            
            foreach ($queued_emails as $key => $email) {
                $no_of_try = $email->no_of_try + 1;
                EmailQueue::where('id',$email->id)->whereIn('email_status',[0,-2])
                    ->update(
                        [
                            'email_status' => -1,
                            'no_of_try' => $no_of_try
                        ]);
                
                if(!$email['email_to']){
                    continue;
                }
                $attachment = $email->attachment;
                $attachment_url = false;
                $attachments = '';
                if ($attachment) {
                    $attachment_url = true;
                    $attachments = '<br/><a href="' . $attachment . '"><u>Click here for downloading the document.</u></a>';
                }
                $body = $email->email_content  ;
                try {
                    //=========================
                    // $email_config = json_decode($email->config);
                    
                   
                    $email_to = $email->email_to;
                    $email_cc = explode(',', str_replace("'", "", $email->email_cc));
                    $email_cc = array_filter($email_cc); // Removes empty values
                    


                    if (!empty($email_cc)) {
                        Mail::to($email_to)->cc($email_cc)->send(new OtpSendMail($body,$email->email_subject));
                    }else{
                        Mail::to($email_to)->send(new OtpSendMail($body,$email->email_subject));
                    }
                    

                    if($no_of_try >3){
                        $mail_msg = '<br/> Failed to sent email. <br/> Mailer Error: ';
                        $email_status = -1;
                    }else {
                            $mail_msg = '<br/> Email  has been sent on ' . date("j F, Y, g:i a");
                            $email_status = 1;
                    }
                   

                    // Finally update mail sending status
                    $email->email_status = $email_status;
                    $email->response = $mail_msg;
                    $email->save();
                    // curl_close($curl);
                } catch (Exception $e) {
                   
                    $email->email_status = -2;
                    $email->response = $e->getMessage();
                    $email->save();
                    #echo $e->getMessage() . 'F:' . $e->getFile() . 'L:' . $e->getLine();
                }
            }
        } else {
            echo '<br/>No email in queue to send! ' . date("j F, Y, g:i a") . "\n";
        }
    }
}