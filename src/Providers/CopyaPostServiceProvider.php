<?php

namespace CopyaPost\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use CopyaPost\Console\CopyaPostMigration;
use CopyaPost\Shortcodes\PostShortcode;
use Webwizo\Shortcodes\Facades\Shortcode;

class CopyaPostServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->publishes([
            __DIR__.'/../../resources/assets/js' => base_path('resources/assets/js'),
        ], 'copya-post');

        $this->publishes([
            __DIR__.'/../../resources/assets/views/posts' => base_path('resources/views/vendor/copya/front/posts'),
            __DIR__.'/../../resources/assets/views/widgets' => base_path('resources/views/vendor/copya/front/widgets'),
        ], 'post-views');

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

            $router->group(['namespace' => 'CopyaPost\Http\Controllers'], function ($router) {

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
            'namespace' => 'CopyaPost\Http\Controllers\API',
            'prefix' => 'api',
        ], function ($router) {
            require __DIR__.'/../routes/api.php';
        });
    }

    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([CopyaPostMigration::class]);
        }
        $this->app->register('Intervention\Image\ImageServiceProvider');

        Shortcode::register('posts', PostShortcode::class);
    }
}