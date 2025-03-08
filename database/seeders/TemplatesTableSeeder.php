<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('templates')->delete();
        
        \DB::table('templates')->insert(array (
            0 => 
            array (
                'id' => 301,
                'caption' => 'MEETING_NOTICE',
                'email_subject' => 'EBS Project Information',
                'email_content' => 'Dear Sir
<br/><br/>
Would like to request please attend the 187th inter-ministerial meeting on following schedule.
<br/><br/>
Meeting Date: {$meetingDate}<br/>
Time: {$meetingTime}<br/>
Location: Conference room, Bangladesh Investment Development Authority. Plot # E/6, Agargaon, Dhaka-1207<br/>
<br/><br/>
We look forward to seeing you at our meeting
<br/><br/><br/>

Best Regards,
<br/><br/>
Bangladesh Investment Development Authority (BIDA)<br/>
Prime Minister\'s Office,<br/>
Government of the People\'s Republic of Bangladesh<br/>
Plot#E-6/B, Agargaon, Sher-E-Bangla Nagar Dhaka-1207<br/>
Phone: +880255007241-45<br/>
Email: info@bida.gov.bd<br/>
www.bida.gov.bd<br/>',
                'email_active_status' => 1,
                'email_cc' => NULL,
                'sms_content' => '',
                'sms_active_status' => 0,
                'is_archive' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'created_by' => 0,
                'updated_by' => 0,
            ),
            1 => 
            array (
                'id' => 401,
                'caption' => 'CONFIRM_ACCOUNT',
                'email_subject' => 'EBS Project Information',
                'email_content' => 'Dear Sir
<br/><br/>
Thank you for choosing the Enterprise Business Solution (EBS).
<br/><br/>
Your temporary password is {$temporary}. Please change this at your own convenience

<br/><br/><br/>
Best Regards,
<br/><br/>
Application Team<br/>
Business Automation Ltd.<br/> 
BDBL Bhaban (Level 9), 12 Kawranbazar, Dhaka-1215<br/>
Phone: +8801755676727<br/>
Email: apps@batworld.com<br/>
https://ebs.oss.net.bd<br/>',
                'email_active_status' => 1,
                'email_cc' => NULL,
                'sms_content' => '',
                'sms_active_status' => 0,
                'is_archive' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'updated_at' => '0000-00-00 00:00:00',
                'created_by' => 0,
                'updated_by' => 0,
            ),
            2 => 
            array (
                'id' => 457,
                'caption' => 'CRM_MEETING',
                'email_subject' => 'CRM Meeting Information',
                'email_content' => 'Dear {$name},<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: {$subject}<br>
<b>Agenda</b>: {$agenda} <br>
<b>Date</b> : {$time} <br>
<b>Location</b>: {$location} <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo',
                'email_active_status' => 1,
                'email_cc' => NULL,
                'sms_content' => '',
                'sms_active_status' => 0,
                'is_archive' => NULL,
                'created_at' => '2021-07-01 09:53:35',
                'updated_at' => '2021-07-01 09:53:35',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),
            3 => 
            array (
                'id' => 459,
                'caption' => 'CRM_MEETING_UPDATE',
                'email_subject' => 'CRM Meeting Information',
                'email_content' => 'Dear {$name},<br><br>

You were invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: {$subject}<br>
<b>Agenda</b>: {$agenda} <br>
<b>Date</b> : {$time} <br>
<b>Location</b>: {$location} <br><br>

Please note that, the meeting has been {$status}.<br><br>

For more information about this meeting please check your Application.<br><br>

Regards<br>
Event Reminder<br>
This is a demo',
                'email_active_status' => 1,
                'email_cc' => NULL,
                'sms_content' => '',
                'sms_active_status' => 0,
                'is_archive' => NULL,
                'created_at' => '2021-07-01 09:53:35',
                'updated_at' => '2021-07-01 09:53:35',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),
            4 => 
            array (
                'id' => 461,
                'caption' => 'CRM_MEETING_REMINDER',
                'email_subject' => 'CRM Meeting Reminder',
                'email_content' => 'Dear {$name},<br><br>

This is a reminder about your upcoming meeting regarding CRM.<br><br>

<b>Subject</b>: {$subject}<br>
<b>Agenda</b>: {$agenda} <br>
<b>Date</b> : {$time} <br>
<b>Location</b>: {$location} <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo',
                'email_active_status' => 1,
                'email_cc' => NULL,
                'sms_content' => '',
                'sms_active_status' => 0,
                'is_archive' => NULL,
                'created_at' => '2021-07-01 09:53:35',
                'updated_at' => '2021-07-01 09:53:35',
                'created_by' => NULL,
                'updated_by' => NULL,
            ),
        ));
        
        
    }
}