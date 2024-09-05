<?php

namespace App\Providers;


use App\Command\RechargeOrderCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    public function register() {}

    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command(RechargeOrderCommand::class)
                ->everyMinute()
                ->withoutOverlapping();
        });
    }
}
