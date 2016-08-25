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


Route::post('/forget/post',
    ['as' => 'forget.post', 'uses' => 'AdminController@forget_post']
);
    
Route::get('/forget',
    ['as' => 'forget', 'uses' => 'AdminController@forget']
);

Route::group(['middleware' => 'auth'], function() {


    Route::post('/state_C/post',
        ['as' => 'state.C.post', 'uses' => 'AdminController@state_C_post']
    );


    Route::post('/state_A/post',
        ['as' => 'state.A.post', 'uses' => 'AdminController@state_A_post']
    );

    Route::post('/paper_add/post',
        ['as' => 'paper.add.post', 'uses' => 'AdminController@paper_add_post']
    );

    Route::get('/paper_add',
        ['as' => 'paper.add', 'uses' => 'AdminController@paper_add']
    );

    Route::post('/paper_edit/post',    
        ['as' => 'paper.edit.post', 'uses' => 'AdminController@paper_edit_post']
    );

    Route::get('/paper_edit/{id}',
        ['as' => 'paper.edit.id', 'uses' => 'AdminController@paper_edit_id']
    )->where('id', '[0-9]+');

//    Route::get('/paper_view/{id}',
//        ['as' => 'paper.view.id', 'uses' => 'AdminController@paper_view_id']
//    )->where('id', '[0-9]+');

    Route::get('/paper_browser/{id}/delete',
        ['as' => 'paper.browser.id.delete', 'uses' => 'AdminController@paper_browser_id_delete']
    )->where('id', '[0-9]+');

    Route::post('/news_add/post',
        ['as' => 'news.add.post', 'uses' => 'AdminController@news_add_post']
    );

    Route::get('/news_add',
        ['as' => 'news.add', 'uses' => 'AdminController@news_add']
    );

    Route::post('/news_edit/post',
        ['as' => 'news.edit.post', 'uses' => 'AdminController@news_edit_post']
    );

    Route::get('/news_edit/{id}',
        ['as' => 'news.edit.id', 'uses' => 'AdminController@news_edit_id']
    )->where('id', '[0-9]+');

//    Route::get('/news_view/{id}',
//        ['as' => 'news.view.id', 'uses' => 'AdminController@news_view_id']
//    )->where('id', '[0-9]+');

    Route::get('/news_browser/{id}/delete',
        ['as' => 'news.browser.id.delete', 'uses' => 'AdminController@news_browser_id_delete']
    )->where('id', '[0-9]+');

    Route::post('/books_add/post',
        ['as' => 'books.add.post', 'uses' => 'AdminController@books_add_post']
    );

    Route::get('/',
        ['as' => 'admin.browser.index', 'uses' => 'AdminController@index']
    );

    Route::get('/admin_browser',
            ['as' => 'admin.browser', 'uses' => 'AdminController@admin_browser']
    );

    Route::get('/admin_browser/{id}/delete',
        ['as' => 'admin.broweser.id.delete', 'uses' => 'AdminController@admin_browser_id_delete']
    )->where('id', '[0-9]+');

//    Route::get('/admin_view/{id}',
//        ['as' => 'admin.view', 'uses' => 'AdminController@admin_view']
//    )->where('id', '[0-9]+');

    Route::get('/admin_edit/{id}',
        ['as' => 'admin.edit', 'uses' => 'AdminController@admin_edit']
    )->where('id', '[0-9]+');

    Route::post('/admin_edit/edit',
        ['as' => 'admin_edit.edit', 'uses' => 'AdminController@admin_post_edit']
    );

    Route::get('/admin_add',
        ['as' => 'admin.add', 'uses' => 'AdminController@admin_add']
    );

    Route::post('/admin_add/post',
        ['as' => 'admin.add.post', 'uses' => 'AdminController@admin_add_post']
    );

    Route::get('/auth/logout', 
        ['as' => 'logout.process', 'uses' => 'Auth\AuthController@getLogout']
    );

    Route::get('/sys_edit',
        ['as' => 'sys.edit', 'uses' => 'AdminController@sys_edit']
    );

    Route::post('/sys_edit/next',
        ['as' => 'sys.edit.next', 'uses' => 'AdminController@sys_edit_next']
    );

    Route::get('/sys_edit_2',
        ['as' => 'sys.edit.2', 'uses' => 'AdminController@sys_edit_2']
    );

    Route::post('/sys_edit_2/next',
        ['as' => 'sys.edit.2.next', 'uses' => 'AdminController@sys_edit_2_next']
    );

    Route::get('/sys_edit_3',
        ['as' => 'sys.edit.3', 'uses' => 'AdminController@sys_edit_3']
    );

    Route::post('/sys_edit_3/next',
        ['as' => 'sys.edit.3.next', 'uses' => 'AdminController@sys_edit_3_next']
    );

    Route::get('/sys_edit_4',
        ['as' => 'sys.edit.4', 'uses' => 'AdminController@sys_edit_4']
    );

    Route::post('/sys_edit_4/next',
        ['as' => 'sys.edit.4.next', 'uses' => 'AdminController@sys_edit_4_next']
    );

    Route::get('/sys_edit_5',
        ['as' => 'sys.edit.5', 'uses' => 'AdminController@sys_edit_5']
    );

    Route::post('/sys_edit_5/post',
        ['as' => 'sys.edit.5.post', 'uses' => 'AdminController@sys_edit_5_post']
    );

    Route::get('/db_browser',
        ['as' => 'db.browser', 'uses' => 'AdminController@db_browser']
    );

    Route::get('/db_browser/{id}/delete',
        ['as' => 'db.browser.id.delete', 'uses' => 'AdminController@db_browser_id_delete']
    )->where('id', '[0-9]+');

//    Route::get('/db_browser/{id}',
//        ['as' => 'db.browser.id', 'uses' => 'AdminController@db_browser_id']
//    );

    Route::get('/db_add',
        ['as' => 'db.add', 'uses' => 'AdminController@db_add']
    );

    Route::post('/db_add/post',
        ['as' => 'db.add.post', 'uses' => 'AdminController@db_add_post']
    );

    Route::get('/db_edit/{id}',
        ['as' => 'db.edit.id', 'uses' => 'AdminController@db_edit_id']
    )->where('id', '[0-9]+');

    Route::patch('/db_edit/{id}',
        ['as' => 'db.edit.post', 'uses' => 'AdminController@db_edit_post']
    )->where('id', '[0-9]+');

    Route::get('/books_browser',
        ['as' => 'books.browser', 'uses' => 'AdminController@books_browser']
    );

    Route::get('/books_add',
        ['as' => 'books.add', 'uses' => 'AdminController@books_add']
    );

    Route::get('/books_browser/{id}/delete',
        ['as' => 'books.browser.id.delete', 'uses' => 'AdminController@books_browser_id_delete']
    )->where('id', '[0-9]+');

//    Route::get('/books_view/{id}',
//        ['as' => 'books.view.id', 'uses' => 'AdminController@books_view_id']
//    )->where('id', '[0-9]+');

    Route::get('/books_edit/{id}',
        ['as' => 'books.edit.id', 'uses' => 'AdminController@books_edit_id']
    )->where('id', '[0-9]+');

    Route::patch('/books_edit/{id}',
        ['as' => 'books.edit.post', 'uses' => 'AdminController@books_edit_post']
    );

    Route::get('/news_browser',
        ['as' => 'news.browser', 'uses' => 'AdminController@news_browser']
    );

    Route::get('/paper_browser',
        ['as' => 'paper.browser', 'uses' => 'AdminController@paper_browser']
    );

    Route::get('/my_info',
        ['as' => 'my.info', 'uses' => 'AdminController@my_info']
    );

    Route::post('/my_info/edit',
        ['as' => 'my_info.edit', 'uses' => 'AdminController@my_info_edit']
    );

    Route::get('/state_A',
        ['as' => 'state.A', 'uses' => 'AdminController@state_A']
    );

    Route::get('/state_A_output/{Year}/{Month}',
        ['as' => 'state.A.output', 'uses' => 'AdminController@state_A_output']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+'] );

    Route::get('/state_A_output_csv/{Year}/{Month}',
        ['as' => 'state.A.output.csv', 'uses' => 'AdminController@state_A_output_csv']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+'] );    

    Route::get('/state_C',
        ['as' => 'state.C', 'uses' => 'AdminController@state_C']
    );

    Route::get('/state_C_output/{Year}/{Month}',
        ['as' => 'state.C.output', 'uses' => 'AdminController@state_C_output']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+'] );

    Route::get('/state_C_output_csv/{Year}/{Month}',
        ['as' => 'state.C.output.csv', 'uses' => 'AdminController@state_C_output_csv']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+'] );


});


// vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php

Route::get('/auth/login' , ['as' => 'login.index'  , 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/auth/login', ['as' => 'login.process', 'uses' => 'Auth\AuthController@postLogin']);





