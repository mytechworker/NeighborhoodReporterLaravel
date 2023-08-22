<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        '\App\Console\Commands\NewsLetterCommand',
        '\App\Console\Commands\BreakingNewsCommand',
        '\App\Console\Commands\NeighborpostCommand',
        '\App\Console\Commands\LocalclassifiedCommand',
        '\App\Console\Commands\CommunitycalenderCommand',
        '\App\Console\Commands\DailyCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        Log::info('CRON Job Start');
        $schedule->command('newsletter:command')->daily()->appendOutputTo(storage_path('logs/newsletter.log'));
        $schedule->command('communitycalender:command')->weekly()->appendOutputTo(storage_path('logs/communitycalender.log'));
        $schedule->command('localclassified:command')->weekly()->appendOutputTo(storage_path('logs/localclassified.log'));
        $schedule->command('neighborpost:command')->cron('0 0 * * 1,3,5')->appendOutputTo(storage_path('logs/neighborpost.log'));
        $schedule->command('breakingnews:command')->cron('0 0 * * 1,3,5')->appendOutputTo(storage_path('logs/breakingnews.log'));
        $schedule->command('daily:command')->daily()->appendOutputTo(storage_path('logs/daily.log'));
        Log::info('CRON Job End');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

}
