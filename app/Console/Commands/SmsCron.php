<?php

namespace App\Console\Commands;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Modules\Campaign\Models\Campaigns;
use App\Modules\Campaign\Models\CampaignsDatils;
use App\Models\EmailQueue;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SmsCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:queue {limit?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sms send';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $project_title = 'Sms Send System';
        $limit = $this->argument('limit');
        $limit = $limit > 0 ? $limit : 10;

        $queued_sms = EmailQueue::where(function ($query) {
            $query->where('sms_status', 0)
                ->orWhere('sms_status', -2);
        })
            ->orderBy('id', 'DESC')
            ->limit($limit)
            ->get(['email_queue.*']);

        if (count($queued_sms) > 0) {

            foreach ($queued_sms as $key => $sms) {

                $message =$sms ['sms_content'];
                $phone=$sms ['sms_to'];

                $sms->sms_status = -1;
                $sms->save();

                if(!$sms['sms_to']){
                    continue;
                }
                $result=CommonFunction::smsCode($message, CommonFunction::updateMobileNo($phone));

                $sms->response = $result['data'];
               if ($result['http_code']=="200"){
                   $sms->sms_status = 1;
                   $sms->save();
               }
               elseif ($result['http_code']=="400"){
                   $sms->sms_status = -2;
                   $sms->save();
               }
               else{
                   $sms->sms_status = -3;
                   $sms->save();
               }

            }
        }  else {
            echo '<br/>No sms left in queue to send! ' . "\n";
        }
    }
}