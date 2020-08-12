<?php

namespace MarksIhor\LaravelCart;

use Illuminate\Support\ServiceProvider;

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
            __DIR__ . '/../config/cart.php' => config_path('cart.php')
        ], 'cart-config');

        // Migrations
        $this->publishes([
            \dirname(__DIR__) . '/migrations/' => database_path('migrations'),
        ], 'migrations');

        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(\dirname(__DIR__) . '/migrations/');
        }
    }
}
