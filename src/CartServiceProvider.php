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
        // config
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
}
