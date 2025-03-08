<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmailConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('email_config')->delete();
        
        \DB::table('email_config')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'CrmEmailConfig',
                'config' => '{"MAIL_DRIVER":"smtp","MAIL_HOST":"sandbox.smtp.mailtrap.io","MAIL_PORT":2525,"MAIL_USERNAME":"8993aa27cebf38","MAIL_PASSWORD":"99c67f1d6e5251","MAIL_FROM":"tanzimndub@gmail.com","MAIL_ENCRYPTION":"tls"}',
            ),
        ));
        
        
    }
}