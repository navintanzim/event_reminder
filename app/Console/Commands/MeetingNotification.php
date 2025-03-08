<?php

namespace App\Console\Commands;

use App\Libraries\CommonFunction;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MeetingNotification extends Command
{
    protected $signature = 'meeting:notify';
   protected $SERVER_API_KEY = "AAAAhu4m0Fo:APA91bHq7v_FN0VfnNIQinAvYRQPgM3Tcja9WFscun07IIkFyPEvi-8GCOuF8Yer113_-Vcx2aBB-HSOMv5nCkdXCJ_a8UVYkMjAZyzRuD4m_U9WSOZIoS2eScSnl3_BbviDHNG5r8j4";
   protected $fcm_url= "https://fcm.googleapis.com/fcm/send";
   protected $notify_title="CRM Meeting Reminder!";

    

    protected $credentials;

    public function __construct()
    {
        parent::__construct();
        $this->credentials = [
            'apiUrl'        => config('envConstant.firebase_device_token_url'),
            'accessTokenUrl'=> config('envConstant.device_access_token_url'),
            'clientID'      => config('envConstant.device_access_client_id'),
            'clientSecret'  => config('envConstant.device_access_client_secret')
        ];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $today=Carbon::now()->format('Y-m-d');
        $meetings=DB::table('crm_meeting as m')
            ->leftJoin('crm_meeting_attendees as a','m.id','=','a.meeting_id')
            ->leftJoin('users', 'a.contact_id','=','users.id')
            ->where(DB::raw('DATE(m.start_dt)'), '>', $today)
            ->where('m.status','=','Planned')
            ->where('m.deleted','=',0)
            ->select('m.id as meeting_id','m.caption','m.agenda',
                'm.start_dt','m.duration','m.location','m.description','m.status',
                DB::raw('DATEDIFF(DATE(m.start_dt), "' . $today . '") as remain_day'),
                'users.id as user_id','users.email',
                'users.phone',
                'users.name'
            )
            ->having('remain_day', '=', 1)
            ->get();

        if (count($meetings)>0)
        {
            // $accessToken=$this->getAccessToken();
            foreach ($meetings as $key=> $meeting)
            {

                // $fcmToken=$this->getDeviceToken($accessToken,$meeting->user_id);
                // if ($fcmToken !==null)
                // {
                //     $deviceToken = $fcmToken['deviceToken'];
                //     $body ="Hello {$meeting->name}, Your CRM meeting '{$meeting->caption}' is scheduled for {$meeting->start_dt}. Please check your CRM for details.";


                //     $this->firebaseFCM($deviceToken,$body);
                // }
                if ($meeting->remain_day == 1)
                {
                    self::sentEmail($meeting);
                }
            }
        }else{
            echo "Nothing to action";
        }

    }

    private static function sentEmail($meeting)
    {
        $receiverInfo[] = [
            'user_email' =>$meeting->email,
            'user_phone' => $meeting->phone
        ];
        $appInfo = [
            'app_id' => $meeting->meeting_id,
            'name' => $meeting->name,
            'subject' => $meeting->caption,
            'agenda' => $meeting->agenda,
            'time' => Carbon::parse($meeting->start_dt)->format('F j, Y \a\t g:i A'),
            'location' => $meeting->location,
            'status' => $meeting->status
        ];
        CommonFunction::sendEmailSMS('CRM_MEETING_REMINDER', $appInfo, $receiverInfo);
    }


}
