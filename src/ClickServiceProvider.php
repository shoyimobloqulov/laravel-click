<?php

namespace Shoyim\Click;

use Illuminate\Support\ServiceProvider;

class ClickServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('click', function ($app) {
            return new ClickClient();
        });
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}