<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\AutoPaymentController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Run automatic payments daily at midnight
        $schedule->call(function() {
            $controller = new AutoPaymentController();
            $processedCount = $controller->runScheduledPayments();
            \Log::info("Auto payment processed for {$processedCount} santri");
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 