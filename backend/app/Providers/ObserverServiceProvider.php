<?php

namespace App\Providers;

use App\Models as M;
use App\Observers as O;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        M\Order::observe(O\OrderObserver::class);
    }
}
