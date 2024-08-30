<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            \Log::info('Schedule running: ' . now());
            \Log::info('Schedule History running: ' . now());
            app(\App\Http\Controllers\HistoryController::class)->updateStatuses();
            \Log::info('Schedule History stop: ' . now());
            \Log::info('Schedule List Motor running: ' . now());
            app(\App\Http\Controllers\ListMotorController::class)->updateMotorStatus();
            \Log::info('Schedule List Motor stop: ' . now());
            \Log::info('Schedule Stop: ' . now());
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $middlewareGroups = [
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];
}