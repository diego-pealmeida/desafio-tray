<?php

use App\Jobs\SendSellersDailyOrderEmails;
use App\Jobs\SendUsersDailyOrderEmails;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule
            ->job(new SendUsersDailyOrderEmails(now()->format('Y-m-d')))
            ->everyMinute();

        $schedule
            ->job(new SendSellersDailyOrderEmails(now()->format('Y-m-d')))
            ->everyMinute();
    })->create();
