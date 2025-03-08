<?php

namespace App\Console\Commands;

use App\Libraries\CommonFunction;
use App\Modules\Meeting\Models\Meeting;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class MeetingReminderNotification  extends Command
{
    protected $signature = 'meeting:reminder';
   
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
        $today=Carbon::now()->format('Y-m-d H:i:s');
        $meetings=DB::table('crm_meeting as m')
            ->leftJoin('crm_meeting_attendees as a','m.id','=','a.meeting_id')
            ->leftJoin('users', 'a.contact_id','=','users.id')
            ->where(DB::raw('(m.start_dt)'), '>', $today)
            ->where('m.status','=','Planned')
            ->where('m.deleted','=',0)
            ->where('m.is_reminder','=',1)
            ->select('m.id as meeting_id','m.caption','m.agenda',
                'm.start_dt','m.duration','m.location','m.description','m.status','m.reminder_time',
                'users.id as user_id','users.email',
                'users.phone',
                'users.name'
            )
            ->get();

        if (count($meetings)>0)
        {
            // $accessToken=$this->getAccessToken();
            foreach ($meetings as $key=> $meeting)
            {

                if (Carbon::parse($meeting->start_dt)->subMinutes($meeting->reminder_time) <= now())
                {
                    self::sentEmail($meeting);

                    Meeting::where('id',$meeting->meeting_id)->update(['is_reminder' => 2]);
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
