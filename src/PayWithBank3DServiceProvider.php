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
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-paywithbank3d');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-paywithbank3d');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/paywithbank3d.php' => config_path('paywithbank3d.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-paywithbank3d'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-paywithbank3d'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-paywithbank3d'),
            ], 'lang');*/

            // Registering package commands.
            // $this->commands([]);
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
