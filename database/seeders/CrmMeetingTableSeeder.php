<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmMeetingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('crm_meeting')->delete();
        
        \DB::table('crm_meeting')->insert(array (
            0 => 
            array (
                'id' => 8,
                'tracking_no' => NULL,
                'caption' => 'assad',
                'agenda' => 'asdads',
                'start_dt' => '2025-03-08 23:22:00',
                'duration' => '04:30',
                'location' => 'asdad',
                'status' => 'Planned',
                'outcome' => NULL,
                'description' => 'daf asadgfdfdfdhhd',
                'assigned_to' => 24,
                'reminder_time' => 20,
                'is_reminder' => 1,
                'deleted' => 0,
                'created_at' => '2025-03-07 17:31:33',
                'created_by' => 2,
                'updated_at' => '2025-03-07 17:49:14',
                'updated_by' => 2,
            ),
            1 => 
            array (
                'id' => 9,
                'tracking_no' => NULL,
                'caption' => 'nmumver 2',
                'agenda' => 'dsfsfsdg',
                'start_dt' => '2025-03-08 17:15:00',
                'duration' => '04:30',
                'location' => 'bbfdbdfdb',
                'status' => 'Planned',
                'outcome' => NULL,
                'description' => 'dggdfdfhdhd',
                'assigned_to' => 2,
                'reminder_time' => 20,
                'is_reminder' => 2,
                'deleted' => 0,
                'created_at' => '2025-03-08 05:31:58',
                'created_by' => 2,
                'updated_at' => '2025-03-08 17:10:01',
                'updated_by' => 2,
            ),
            2 => 
            array (
                'id' => 10,
                'tracking_no' => 'MEET-08Mar2025-00001',
                'caption' => 'VPN not working',
                'agenda' => 'test3',
                'start_dt' => '2025-03-09 05:05:00',
                'duration' => '04:40',
                'location' => 'asdafsafaf',
                'status' => 'Planned',
                'outcome' => NULL,
                'description' => 'ghdfhdfhdfhdfjd',
                'assigned_to' => 2,
                'reminder_time' => NULL,
                'is_reminder' => 0,
                'deleted' => 0,
                'created_at' => '2025-03-08 18:07:47',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:07:47',
                'updated_by' => 2,
            ),
            3 => 
            array (
                'id' => 11,
                'tracking_no' => 'MEET-08Mar2025-00002',
                'caption' => 'testing tickets to partner',
                'agenda' => 'asdads',
                'start_dt' => '2025-03-09 05:08:00',
                'duration' => '05:30',
                'location' => 'asdafsafaf',
                'status' => 'Planned',
                'outcome' => NULL,
                'description' => 'hhgkghkghkghkghk',
                'assigned_to' => 2,
                'reminder_time' => 60,
                'is_reminder' => 1,
                'deleted' => 0,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:08:42',
                'updated_by' => 2,
            ),
        ));
        
        
    }
}