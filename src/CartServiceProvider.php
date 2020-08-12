<?php

namespace MarksIhor\LaravelCart;

use Illuminate\Support\ServiceProvider;
use MarksIhor\LaravelCart\Cart;

/**
 * Class MessagingServiceProvider.
 */
class CartServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        // Config
        $this->publishes([
            __DIR__ . '/config/' => config_path()
        ], 'config');

        // Migrations
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }
    }

    public function register()
    {
        $this->app->singleton('cart', function () {
            return new Cart();
        });
    }
}
