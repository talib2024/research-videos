<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\profileCompletionReminder;
use App\Console\Commands\wireTransferSubscriptionReminder;
use App\Console\Commands\deleteUnpublishedRecord;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */

    protected $commands = [
        profileCompletionReminder::class,
        wireTransferSubscriptionReminder::class,
        deleteUnpublishedRecord::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('profileCompletionReminder:cron')->everyMinute();
        $schedule->command('deleteUnpublishedRecord:cron')->everyMinute();

        // $schedule->command('profileCompletionReminder:cron')->weeklyOn(0, '7:00'); // send on sunday
        // $schedule->command('profileCompletionReminder:cron')->weeklyOn(2, '7:00'); // send on tuesday
        // $schedule->command('profileCompletionReminder:cron')->weeklyOn(5, '7:00'); // send on Friday
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
