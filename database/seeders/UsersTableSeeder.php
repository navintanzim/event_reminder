<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Tanzim admin',
                'email' => 'tanzim@batworld.com',
                'phone' => '01987168379',
                'user_type' => '1x101',
                'user_DOB' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$10$ZMj7oLCdwkdp0fKJBh1xkOS2QDmWkhj0oPfQs14tPxBTEIU4AKJga',
                'user_status' => 'active',
                'remember_token' => NULL,
                'created_by' => NULL,
                'updated_by' => 2,
                'created_at' => '2025-03-05 07:37:02',
                'updated_at' => '2025-03-07 06:49:38',
            ),
            1 => 
            array (
                'id' => 26,
                'name' => 'test user 34',
                'email' => 'exvidia@gmail.com',
                'phone' => '+8801767-602374',
                'user_type' => '5x505',
                'user_DOB' => '2025-03-08',
                'email_verified_at' => NULL,
                'password' => '$2y$10$8NjJ1hihRSU9e3OdsttO3.QZN9xtsu9MMoafSPitvd6lBZ1tjRrd2',
                'user_status' => 'active',
                'remember_token' => NULL,
                'created_by' => 2,
                'updated_by' => 26,
                'created_at' => '2025-03-07 09:50:29',
                'updated_at' => '2025-03-08 18:25:16',
            ),
            2 => 
            array (
                'id' => 25,
                'name' => 'test user nomber2',
                'email' => 'tanzimndubs@gmail.com',
                'phone' => '01767602475',
                'user_type' => '5x505',
                'user_DOB' => '2025-03-07',
                'email_verified_at' => NULL,
                'password' => '$2y$10$8NjJ1hihRSU9e3OdsttO3.QZN9xtsu9MMoafSPitvd6lBZ1tjRrd2',
                'user_status' => 'active',
                'remember_token' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => '2025-03-07 09:50:29',
                'updated_at' => '2025-03-07 09:50:29',
            ),
            3 => 
            array (
                'id' => 24,
                'name' => 'test user emp',
                'email' => 'tanzimndub@gmail.com',
                'phone' => '01767602474',
                'user_type' => '5x505',
                'user_DOB' => '2025-03-07',
                'email_verified_at' => NULL,
                'password' => '$2y$10$8NjJ1hihRSU9e3OdsttO3.QZN9xtsu9MMoafSPitvd6lBZ1tjRrd2',
                'user_status' => 'active',
                'remember_token' => NULL,
                'created_by' => 2,
                'updated_by' => 2,
                'created_at' => '2025-03-07 09:50:29',
                'updated_at' => '2025-03-07 09:50:29',
            ),
        ));
        
        
    }
}