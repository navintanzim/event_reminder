<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CrmMeetingAttendeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('crm_meeting_attendees')->delete();
        
        \DB::table('crm_meeting_attendees')->insert(array (
            0 => 
            array (
                'id' => 10,
                'meeting_id' => 8,
                'contact_id' => 25,
                'deleted' => 0,
                'created_at' => '2025-03-07 17:49:14',
                'created_by' => 2,
                'updated_at' => '2025-03-07 17:49:14',
                'updated_by' => 2,
            ),
            1 => 
            array (
                'id' => 11,
                'meeting_id' => 8,
                'contact_id' => 24,
                'deleted' => 0,
                'created_at' => '2025-03-07 17:49:14',
                'created_by' => 2,
                'updated_at' => '2025-03-07 17:49:14',
                'updated_by' => 2,
            ),
            2 => 
            array (
                'id' => 12,
                'meeting_id' => 9,
                'contact_id' => 26,
                'deleted' => 0,
                'created_at' => '2025-03-08 05:31:58',
                'created_by' => 2,
                'updated_at' => '2025-03-08 05:31:58',
                'updated_by' => 2,
            ),
            3 => 
            array (
                'id' => 13,
                'meeting_id' => 9,
                'contact_id' => 25,
                'deleted' => 0,
                'created_at' => '2025-03-08 05:31:59',
                'created_by' => 2,
                'updated_at' => '2025-03-08 05:31:59',
                'updated_by' => 2,
            ),
            4 => 
            array (
                'id' => 14,
                'meeting_id' => 10,
                'contact_id' => 26,
                'deleted' => 0,
                'created_at' => '2025-03-08 18:07:47',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:07:47',
                'updated_by' => 2,
            ),
            5 => 
            array (
                'id' => 15,
                'meeting_id' => 11,
                'contact_id' => 24,
                'deleted' => 0,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:08:42',
                'updated_by' => 2,
            ),
            6 => 
            array (
                'id' => 16,
                'meeting_id' => 11,
                'contact_id' => 26,
                'deleted' => 0,
                'created_at' => '2025-03-08 18:08:42',
                'created_by' => 2,
                'updated_at' => '2025-03-08 18:08:42',
                'updated_by' => 2,
            ),
        ));
        
        
    }
}