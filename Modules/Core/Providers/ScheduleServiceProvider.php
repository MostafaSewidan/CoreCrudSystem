<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('orders:reached')->timezone('Asia/Kuwait')->everyMinute();
            $schedule->command('telescope:prune --hours=48')->daily();
            $schedule->command('php artisan telescope:clear --hours=48')->daily();
        });
    }

    public function register()
    {

    }
}
