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

        // Migratsiyalarni chop etish
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        // Ko'rinishlarni yuklash
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'click');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/click.php',
            'click'
        );

        // Xizmatni ro'yxatdan o'tkazish
        $this->app->singleton('click', function ($app) {
            return new ClickService();
        });
    }
}