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

Route::group(['middleware' => 'auth'], function () {

    Route::post('/state_C/post',
        ['as' => 'state.C.post', 'uses' => 'AdminController@state_C_post']
    );

    Route::post('/state_A/post',
        ['as' => 'state.A.post', 'uses' => 'AdminController@state_A_post']
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

    Route::get('/lang_browser',
        ['as' => 'lang.browser', 'uses' => 'AdminController@lang_browser']
    );

    Route::get('/lang_edit/{label}',
        ['as' => 'lang.edit.label', 'uses' => 'AdminController@lang_edit_label']
    )->where('label', '[0-9]+');

    Route::patch('/lang_edit/{label}',
        ['as' => 'lang.edit.post', 'uses' => 'AdminController@lang_edit_post']
    )->where('label', '[0-9]+');

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
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+']);

    Route::get('/state_A_output_csv/{Year}/{Month}',
        ['as' => 'state.A.output.csv', 'uses' => 'AdminController@state_A_output_csv']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+']);

    Route::get('/state_C',
        ['as' => 'state.C', 'uses' => 'AdminController@state_C']
    );

    Route::get('/state_C_output/{Year}/{Month}',
        ['as' => 'state.C.output', 'uses' => 'AdminController@state_C_output']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+']);

    Route::get('/state_C_output_csv/{Year}/{Month}',
        ['as' => 'state.C.output.csv', 'uses' => 'AdminController@state_C_output_csv']
    )->where(['Year' => '[0-9]+', 'Month' => '[0-9]+']);

    $controllers = array(
        new \App\Http\Controllers\BannerController(),
        new \App\Http\Controllers\MenupageController(),
        new \App\Http\Controllers\BookController(),
        new \App\Http\Controllers\DbController(),
        new \App\Http\Controllers\NewsController(),
        new \App\Http\Controllers\AdController()
    );

    foreach ($controllers as $controller) {
        $className = get_class($controller);
        $reflector = new \ReflectionClass($className);
        $namespace = $reflector->getNamespaceName();
        $clazz = str_replace($namespace . '\\', '', $className);
        $entity = str_replace('Controller', '', $clazz);

        foreach ($reflector->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
            $methodName = $method->name;
            $func = new \ReflectionMethod($className, $methodName);
            $params = $func->getParameters();
            $action = $clazz . '@' . $methodName;
            $urlPrefix = '/' . strtolower($entity) . '/';
            $routePrefix = strtolower($entity) . '.';

            if (sizeof($params) == 0) {
                if ($methodName == 'index') {
                    Route::get($urlPrefix,
                        ['as' => $routePrefix . $methodName, 'uses' => $action]
                    );
                } else {
                    Route::get($urlPrefix . $methodName,
                        ['as' => $routePrefix . $methodName, 'uses' => $action]
                    );
                }
            } elseif (sizeof($params) == 1 && $params[0]->getName() == 'id') {
                if ($methodName == 'destroy') {
                    Route::delete($urlPrefix . '{id}/' . $methodName,
                        ['as' => $routePrefix . $methodName, 'uses' => $action]
                    )->where('id', '[0-9]+');
                } else {
                    Route::get($urlPrefix . '{id}/' . $methodName,
                        ['as' => $routePrefix . $methodName, 'uses' => $action]
                    )->where('id', '[0-9]+');
                }

            } elseif (sizeof($params) == 1 && $params[0]->getName() == 'request') {
                Route::post($urlPrefix . $methodName,
                    ['as' => $routePrefix . $methodName, 'uses' => $action]
                );
            } elseif (sizeof($params) == 2) {
                $isPatch = true;

                foreach ($params as $param) {
                    if ($param->getClass() == null) {
                        if ($param->getName() != 'id') {
                            $isPatch = false;
                        }
                    } else {
                        if ($param->getName() != 'request') {
                            $isPatch = false;
                        } else if ($param->getClass()->getName() != 'Illuminate\Http\Request') {
                            $isPatch = false;
                        }
                    }
                }

                if ($params[0]->getClass() == $params[1]->getClass()) {
                    $isPatch = false;
                }

                if ($isPatch) {
                    Route::patch($urlPrefix . '{id}/' . $methodName,
                        ['as' => $routePrefix . $methodName, 'uses' => $action]
                    )->where('id', '[0-9]+');
                }
            }
        }
    }
});

// vendor/laravel/framework/src/Illuminate/Foundation/Auth/AuthenticatesUsers.php

Route::get('/auth/login', ['as' => 'login.index', 'uses' => 'Auth\AuthController@getLogin']);
Route::post('/auth/login', ['as' => 'login.process', 'uses' => 'Auth\AuthController@postLogin']);