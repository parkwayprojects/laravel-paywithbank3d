<?php

namespace Parkwayprojects\PayWithBank3D;

use Illuminate\Support\ServiceProvider;

class PayWithBank3DServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/paywithbank3d.php' => config_path('paywithbank3d.php'),
            ], 'config');

        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/paywithbank3d.php', 'paywithbank3d');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-paywithbank3d', function () {
            return new PayWithBank3D;
        });
    }
}
