<?php

namespace Shoyim\Click\Providers;

use Illuminate\Support\ServiceProvider;
use Shoyim\Click\Helpers\ClickHelper;
use Shoyim\Click\Services\ClickRequest;

class ClickServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/click.php', 'click');

        $this->app->singleton('click', function ($app) {
            return new ClickClient();
        });

        $this->app->singleton(\Providers::class, function ($app) {
            return new ClickRequest($app->make('request'), new ClickHelper());
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/click.php' => config_path('click.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}