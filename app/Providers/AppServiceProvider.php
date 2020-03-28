<?php

namespace App\Providers;

// use Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Force Load Assets in HTTPS (Not Good If My Custom Domain Not Provided With SSL)
        // if (env('APP_ENV') !== 'local') {
        //     $this->app['request']->server->set('HTTPS', true);
        // }
        
        // Instead I Try To Use This
        if (
            isset($_SERVER['HTTPS']) && 
            ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || 
            isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&  
            $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
            ) {
            $this->app['request']->server->set('HTTPS', true);
        }
        // Handle Bug MySQL
        // Schema::defaultStringLength(191);
    }
}
