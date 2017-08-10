<?php namespace Exults\Logs;

use Illuminate\Support\ServiceProvider;

class LogsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__. '/migrations');
        $this->mergeConfigFrom( __DIR__ . '/config/userlogs.php' , 'userlogs');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
