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
        // Commands\Inspire::class,
        Commands\ExchangeCron::class,
        Commands\NotificationCron::class,
        Commands\DiscDevineCron::class,
        Commands\SandlerCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* First Exchange Rate For Euro And Dollar Update */
        $schedule->command('exchange:cron')->dailyAt('08:30');//->twiceDaily(8, 9);//->everyMinute();
        $schedule->command('notification:cron')->dailyAt('08:30');//->everyMinute();
        $schedule->command('discdevine:cron')->dailyAt('09:00');//->everyMinute();
        $schedule->command('sandler:cron')->dailyAt('09:00');//->everyMinute();
    }
}
