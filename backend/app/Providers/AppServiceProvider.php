<?php

namespace App\Providers;

use App\Repositories\DishRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(DishRepository::class, function ($app) {
            return new DishRepository();
        });
    }

    public function boot(): void
    {
        //
    }
}