<?php

use Illuminate\Support\Facades\Config;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


Route::group(['middleware' => 'copya.menu'], function() {
    $post_path = config('copya.post_path') ?: 'posts';
    Route::resource($post_path, 'FrontEnd\PostsController');
    Route::resource('categories/{category}/posts', 'FrontEnd\Categories\PostsController');
});

Route::group(['middleware' => ['web', 'auth']], function ($router) {
    $router->group(['prefix' => Config::get('copya.admin_path'), 'namespace' => 'Admin',], function($router){

        $router->group(['prefix' => 'posts'], function($router){
            $router->get('/', 'PostController@index')->name('posts.index');
            $router->get('/add', 'PostController@create')->name('posts.add');
            $router->get('{id}/edit', 'PostController@edit')->name('posts.edit');
        });

    });
});

