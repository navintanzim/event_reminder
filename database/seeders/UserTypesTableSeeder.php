<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_types')->delete();
        
        \DB::table('user_types')->insert(array (
            0 => 
            array (
                'id' => '1x101',
                'type_name' => 'SysAdmin',
                'signup_type_id' => '0',
                'is_registrable' => -1,
                'access_code' => '1_101',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => '0',
                'is_default' => 0,
                'created_at' => '2019-08-20 14:43:21',
                'created_by' => 0,
                'updated_at' => '2019-08-21 11:00:04',
                'updated_by' => 0,
            ),
            1 => 
            array (
                'id' => '2x202',
                'type_name' => 'IT Help Desk',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '2_202',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => NULL,
                'is_default' => 0,
                'created_at' => '2018-05-07 23:35:00',
                'created_by' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'updated_by' => 0,
            ),
            2 => 
            array (
                'id' => '3x301',
                'type_name' => 'Partner',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '3_301',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => ' ',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => NULL,
                'is_default' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'created_by' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'updated_by' => 0,
            ),
            3 => 
            array (
                'id' => '3x302',
                'type_name' => 'Vendor',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '3_302',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => ' ',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => NULL,
                'is_default' => 0,
                'created_at' => '0000-00-00 00:00:00',
                'created_by' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'updated_by' => 0,
            ),
            4 => 
            array (
                'id' => '4x404',
                'type_name' => 'Project Coordinator',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '4_404',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '4x404',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => '0',
                'is_default' => 0,
                'created_at' => '2018-05-07 23:35:37',
                'created_by' => 0,
                'updated_at' => '2017-09-27 04:57:09',
                'updated_by' => 514,
            ),
            5 => 
            array (
                'id' => '5x505',
                'type_name' => 'Employee',
                'signup_type_id' => '1,2',
                'is_registrable' => 3,
                'access_code' => '5_505',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => '0',
                'is_default' => 1,
                'created_at' => '2019-08-20 14:08:29',
                'created_by' => 0,
                'updated_at' => '2019-08-22 06:11:15',
                'updated_by' => 593,
            ),
            6 => 
            array (
                'id' => '6x606',
                'type_name' => 'Accounts',
                'signup_type_id' => '2',
                'is_registrable' => 3,
                'access_code' => '',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => NULL,
                'is_default' => 0,
                'created_at' => '2018-05-07 23:47:57',
                'created_by' => 0,
                'updated_at' => '0000-00-00 00:00:00',
                'updated_by' => 0,
            ),
            7 => 
            array (
                'id' => '7x707',
                'type_name' => 'MIS',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '7_707',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => '0',
                'is_default' => 0,
                'created_at' => '2018-05-07 23:35:38',
                'created_by' => 0,
                'updated_at' => '2016-10-05 05:13:15',
                'updated_by' => 1,
            ),
            8 => 
            array (
                'id' => '8x808',
                'type_name' => 'IT Officer',
                'signup_type_id' => '0',
                'is_registrable' => 1,
                'access_code' => '8_808',
                'permission_json' => NULL,
                'status' => 'active',
                'delegate_to_types' => '',
                'security_profile_id' => 1,
                'auth_token_type' => 'optional',
                'user_manual_name' => NULL,
                'db_access_data' => '0',
                'is_default' => 0,
                'created_at' => '2019-08-20 14:34:33',
                'created_by' => 0,
                'updated_at' => '2019-08-20 08:38:19',
                'updated_by' => 593,
            ),
        ));
        
        
    }
}