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
        // Commands\SpaylinksWithExpiry::class,
        // Commands\PaylinksWithOutExpiry::class,
        // Commands\VendorSettlement::class,
        // Commands\VendorTransTrack::class,
        Commands\MerchantGstInvoice::class,
        Commands\HourlyUpdate::class,
        Commands\DailyCronSetup::class,
        Commands\MinuteTransactionSettelment::class,
        Commands\TransactionSettelmentBreif::class

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('rpaylinkswithexpiry:daily')->daily();
        // $schedule->command('rpaylinkswithoutexpiry:daily')->daily();
        // $schedule->command('vendorsettlement:daily')->daily();
        // $schedule->command('vendortranstrack:daily')->daily();

        //    $schedule->command('hour:update')->everyMinute();
        //    $schedule->command('daily:createSettlementCron')->dailyAt('11:30');;
        //    $schedule->command('every2min:TransactionSettelment')->cron('*/2 * * * *');
        //    $schedule->command('settelement:TransactionSettelmentBreif')->cron('*/20 * * * *');
        //    $schedule->command('merchantgstinvoice:daily')->daily();

        $schedule->job(new \App\Jobs\DailyTransactionExportJob)->dailyAt('01:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
