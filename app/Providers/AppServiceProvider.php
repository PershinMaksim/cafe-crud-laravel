<?php

namespace App\Providers;

use App\Repositories\ItemRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ItemRepository::class, function ($app) {
            return new ItemRepository();
        });
    }

    public function boot(): void
    {
        //
    }
}