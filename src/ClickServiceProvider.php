<?php
namespace Shoyim\Click;

use Illuminate\Support\ServiceProvider;
class ClickServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/click.php' => config_path('click.php'),
        ]);
    }

    public function register()
    {
        $this->app->singleton(ClickService::class, function ($app) {
            return new ClickService();
        });
    }
}