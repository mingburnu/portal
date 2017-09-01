<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',
    ['as' => 'index', 'uses' => 'WebController@index']
);

Route::post('/',
    ['as' => 'locale', 'uses' => 'WebController@locale']
);

Route::get('/news_detail/{id}',
    ['as' => 'news.detail.id', 'uses' => 'WebController@news_detail']
)->where('id', '[0-9]+');

Route::get('/news_list',
    ['as' => 'news.list', 'uses' => 'WebController@news_list']
);

Route::get('/pages/{id}',
    ['as' => 'pages.id', 'uses' => 'WebController@pages']
)->where('id', '[0-9]+');