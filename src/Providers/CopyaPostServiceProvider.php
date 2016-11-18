<?php

namespace CopyaPost\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;


class CopyaPostServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config files
        $this->publishes([
            __DIR__.'/../Config/copya.php' => config_path('copya.php'),
        ], 'copya-config');

        $this->defineRoutes();
    }

    /**
     * Define the Copya routes.
     *
     * @return void
     */
    protected function defineRoutes()
    {
        if (! $this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Copya\Http\Controllers'], function ($router) {

                require __DIR__.'/../routes/console.php';
                require __DIR__.'/../routes/web.php';
            });

            $this->mapApiRoutes();


        }
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => 'Copya\Http\Controllers\API',
            'prefix' => 'api',
        ], function ($router) {
            require __DIR__.'/../routes/api.php';
        });
    }

    public function register()
    {


    }
}