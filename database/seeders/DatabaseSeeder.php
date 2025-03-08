<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $this->call(CrmMeetingAttendeesTableSeeder::class);
        $this->call(CrmMeetingTableSeeder::class);
        $this->call(EmailConfigTableSeeder::class);
        $this->call(EmailQueueTableSeeder::class);
        $this->call(TemplatesTableSeeder::class);
        $this->call(UserTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
