<?php
namespace Shoyim\Click;

use Illuminate\Support\ServiceProvider;

class ClickServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register any bindings or singletons here.
        $this->app->singleton('click', function ($app) {
            return new ClickClient(); // Assuming ClickClient is the main class.
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load package routes, views, or migrations if needed.
    }
}