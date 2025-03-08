<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmailQueueTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_queue')->delete();
        
        \DB::table('email_queue')->insert(array (
            0 => 
            array (
                'id' => 3581,
                'app_id' => 625,
                'caption' => 'ST_ASSIGNED_USER',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    Support Ticket Info of EE6B296
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear Sir,<br/><br/>
The ticket on test has been assigned to you!<br/>Ticket No. EE6B296<br/>
For more info, please contact with<br/>
Name: Mazharul  Islam
<br/>Cell: 01987168379<br/>Email: <br/><br/>
Regards<br/>
EBS Team<br/>
Business Automation<br/>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by OSS-Framework of Business Automation Ltd. 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'jehadkhan89@yahoo.com',
                'sms_content' => 'Support Ticket No. EE6B296 has been assigned to you. Please check details of issue and contact details for better support. EBS team',
                'sms_to' => '01755676727',
                'email_cc' => '',
                'email_subject' => 'Support Ticket Info of EE6B296',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-03 17:03:55',
                'created_by' => 0,
                'updated_at' => '2025-03-03 17:03:55',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            1 => 
            array (
                'id' => 3582,
                'app_id' => 625,
                'caption' => 'ST_PROGRESS_CUSTOMER',
                'email_content' => '',
                'email_to' => '',
                'sms_content' => 'Your Ticket No. EE6B296 on test is In-Progress. Email: jehadkhan89@yahoo.com, Mobile: 01755676727, ba-systems.com',
                'sms_to' => '01987168379',
                'email_cc' => '',
                'email_subject' => 'Support Ticket Info',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-03 11:05:17',
                'created_by' => 0,
                'updated_at' => '2025-03-03 11:05:17',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            2 => 
            array (
                'id' => 3583,
                'app_id' => 625,
                'caption' => 'SUPPORT_TICKET_RESOLVED',
                'email_content' => '',
                'email_to' => '',
                'sms_content' => 'Your Ticket No. EE6B296 on test has been resolved. Please update the feedback of support. ba-systems.com',
                'sms_to' => '01987168379',
                'email_cc' => '',
                'email_subject' => 'Support Ticket Info',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-03 11:07:14',
                'created_by' => 0,
                'updated_at' => '2025-03-03 11:07:14',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            3 => 
            array (
                'id' => 3584,
                'app_id' => 624,
                'caption' => 'SUPPORT_TICKET_REPLIED',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    Support Ticket Info
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear Concern,<br/><br/>
We have received reply from customer on support Ticket No. EE6B28A. 
Please check the reply and response to the customer query.
The issue is: testing tickets to partner 
For more info, please contact with<br/> 
Reply: test reply
Name: Mazharul  Islam
<br/>Cell: <br/>Email: mazharul@batworld.com<br/><br/>
Regards<br/>
EBS Team<br/>
Business Automation<br/>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by OSS-Framework of Business Automation Ltd. 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'jehadkhan89@yahoo.com',
                'sms_content' => 'Customer has replied on support Ticket No. EE6B28A. Please check details of issue and contact details for better support. EBS team',
                'sms_to' => '01755676727',
                'email_cc' => '',
                'email_subject' => 'Support Ticket Info',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-03 17:08:26',
                'created_by' => 0,
                'updated_at' => '2025-03-03 17:08:26',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            4 => 
            array (
                'id' => 3585,
                'app_id' => 0,
                'caption' => 'CONFIRM_ACCOUNT',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    EBS Project Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear Sir
<br/><br/>
Thank you for choosing the Enterprise Business Solution (EBS).
<br/><br/>
Your temporary password is SIctoqUP. Please change this at your own convenience

<br/><br/><br/>
Best Regards,
<br/><br/>
Application Team<br/>
Business Automation Ltd.<br/> 
BDBL Bhaban (Level 9), 12 Kawranbazar, Dhaka-1215<br/>
Phone: +8801755676727<br/>
Email: apps@batworld.com<br/>
https://ebs.oss.net.bd<br/>

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndub@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'EBS Project Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-07 09:50:29',
                'created_by' => 2,
                'updated_at' => '2025-03-08 12:02:24',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            5 => 
            array (
                'id' => 3588,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear  (tanzimndubs@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: assad<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 8, 2025 at 11:22 PM <br>
<b>Location</b>: asdad <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndubs@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => -1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 2,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-07 17:31:33',
                'created_by' => 2,
                'updated_at' => '2025-03-08 12:14:24',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            6 => 
            array (
                'id' => 3589,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear  (tanzimndub@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: assad<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 8, 2025 at 11:22 PM <br>
<b>Location</b>: asdad <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndub@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => -1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 2,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-07 17:31:33',
                'created_by' => 2,
                'updated_at' => '2025-03-08 12:14:24',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            7 => 
            array (
                'id' => 3590,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user emp2 (tanzimndubs@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: assad<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 8, 2025 at 11:22 PM <br>
<b>Location</b>: asdad <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndubs@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => -1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 1,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-07 17:49:14',
                'created_by' => 2,
                'updated_at' => '2025-03-08 12:13:13',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            8 => 
            array (
                'id' => 3591,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user emp (tanzimndub@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: assad<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 8, 2025 at 11:22 PM <br>
<b>Location</b>: asdad <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndub@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => -1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 3,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-07 17:49:14',
                'created_by' => 2,
                'updated_at' => '2025-03-08 14:56:58',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            9 => 
            array (
                'id' => 3592,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user 3 (exvidia@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: nmumver 2<br>
<b>Agenda</b>: dsfsfsdg <br>
<b>Date</b> : March 8, 2025 at 4:31 PM <br>
<b>Location</b>: bbfdbdfdb <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'exvidia@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => '<br/> Email  has been sent on 8 March, 2025, 3:35 pm',
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 1,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-08 05:31:59',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:25:31',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            10 => 
            array (
                'id' => 3593,
                'app_id' => 0,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user nomber2 (tanzimndubs@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: nmumver 2<br>
<b>Agenda</b>: dsfsfsdg <br>
<b>Date</b> : March 8, 2025 at 4:31 PM <br>
<b>Location</b>: bbfdbdfdb <br><br>

We look forward to your participation.<br><br>

Regards<br>
Business Automation Ltd.<br>
https://ba-systems.com

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by  2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndubs@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => -1,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 2,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-08 05:31:59',
                'created_by' => 2,
                'updated_at' => '2025-03-08 15:10:54',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            11 => 
            array (
                'id' => 3594,
                'app_id' => 9,
                'caption' => 'CRM_MEETING_REMINDER',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Reminder
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user 3,<br><br>

This is a reminder about your upcoming meeting regarding CRM.<br><br>

<b>Subject</b>: nmumver 2<br>
<b>Agenda</b>: dsfsfsdg <br>
<b>Date</b> : March 8, 2025 at 5:15 PM <br>
<b>Location</b>: bbfdbdfdb <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'exvidia@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Reminder',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => '<br/> Email  has been sent on 8 March, 2025, 5:10 pm',
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 1,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-08 17:10:01',
                'created_by' => 0,
                'updated_at' => '2025-03-08 18:25:31',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            12 => 
            array (
                'id' => 3595,
                'app_id' => 9,
                'caption' => 'CRM_MEETING_REMINDER',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Reminder
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user nomber2,<br><br>

This is a reminder about your upcoming meeting regarding CRM.<br><br>

<b>Subject</b>: nmumver 2<br>
<b>Agenda</b>: dsfsfsdg <br>
<b>Date</b> : March 8, 2025 at 5:15 PM <br>
<b>Location</b>: bbfdbdfdb <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndubs@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Reminder',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 1,
                'response' => '<br/> Email  has been sent on 8 March, 2025, 5:10 pm',
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 1,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-08 17:10:01',
                'created_by' => 0,
                'updated_at' => '2025-03-08 17:10:51',
                'updated_by' => 0,
                'template_id' => 0,
                'config_id' => 1,
            ),
            13 => 
            array (
                'id' => 3596,
                'app_id' => 10,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user 3 (exvidia@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: VPN not working<br>
<b>Agenda</b>: test3 <br>
<b>Date</b> : March 9, 2025 at 5:05 AM <br>
<b>Location</b>: asdafsafaf <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'exvidia@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 0,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-08 18:07:47',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:25:31',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            14 => 
            array (
                'id' => 3597,
                'app_id' => 11,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user emp (tanzimndub@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: testing tickets to partner<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 9, 2025 at 5:08 AM <br>
<b>Location</b>: asdafsafaf <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'tanzimndub@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 0,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 0,
                'others_info' => NULL,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:08:42',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            15 => 
            array (
                'id' => 3598,
                'app_id' => 11,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user 3 (exvidia@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: testing tickets to partner<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 9, 2025 at 5:08 AM <br>
<b>Location</b>: asdafsafaf <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'exvidia@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 0,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:25:31',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
            16 => 
            array (
                'id' => 3599,
                'app_id' => 12,
                'caption' => 'CRM_MEETING',
                'email_content' => '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>    CRM Meeting Information
</title>
<link href=\'https://fonts.googleapis.com/css?family=Vollkorn\' rel=\'stylesheet\' type=\'text/css\'>
<style type="text/css">
*{
font-family: Vollkorn;
}
</style>
</head>


<body>
<table width="80%" style="">
<thead>

</thead>
<tbody>
<tr>
<td style="">
Dear test user 3 (exvidia@gmail.com),<br><br>

You are invited to a meeting. Here are the details:<br><br>

<b>Subject</b>: testing tickets to partner<br>
<b>Agenda</b>: asdads <br>
<b>Date</b> : March 9, 2025 at 5:08 AM <br>
<b>Location</b>: asdafsafaf <br><br>

We look forward to your participation.<br><br>

Regards<br>
Event Reminder<br>
This is a demo

</td>
</tr>
<!-- <tr style="margin-top: 15px;">
<td style="padding: 1px; border-top: 1px solid rgba(0, 102, 255, 0.21);">
<h5 style="text-align:center">All right reserved by Notifiction System Demo 2025.</h5>
</td>
</tr> -->
</tbody>
</table>
</body>
</html>',
                'email_to' => 'exvidia@gmail.com',
                'sms_content' => '',
                'sms_to' => '',
                'email_cc' => '',
                'email_subject' => 'CRM Meeting Information',
                'attachment' => '',
                'attachment_certificate_name' => '',
                'secret_key' => '',
                'pdf_type' => '',
                'email_status' => 0,
                'response' => NULL,
                'sms_status' => 0,
                'sent_on' => NULL,
                'cron_id' => NULL,
                'no_of_try' => 0,
                'web_notification' => 1,
                'others_info' => NULL,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:25:31',
                'updated_by' => 2,
                'template_id' => 0,
                'config_id' => 1,
            ),
        ));
        
        
    }
}