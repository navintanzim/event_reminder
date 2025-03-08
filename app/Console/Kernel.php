<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\EmailNotification::class,
        \App\Console\Commands\MailQueue::class,
        \App\Console\Commands\SmsCron::class,
        \App\Console\Commands\SmsNotification::class,
        \App\Console\Commands\MeetingNotification::class,
        \App\Console\Commands\MeetingReminderNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('email:notify')->cron('* * * * *');

        $schedule->command('email:queue')->cron('* * * * *');

        // $schedule->command('sms:queue')->cron('* * * * *');

        $schedule->command('meeting:notify')->daily();
        $schedule->command('meeting:reminder')->daily();

        // $schedule->command('sms:notify')->cron('* * * * *');



        // $schedule->command('status:change')->cron('* * * * *');
        // $schedule->command('lead:notify')->daily();
        
        //$schedule->command('lead:notify')->everyFiveMinutes();
//        $schedule->command('email:notify')
//            ->everyThirtyMinutes();
//        $schedule->command('email:queue')
//            ->everyThirtyMinutes();
//        $schedule->command('sms:notify')
//            ->everyThirtyMinutes();
//        $schedule->command('sms:queue')
//            ->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
