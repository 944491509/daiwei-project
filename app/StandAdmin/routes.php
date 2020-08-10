<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Dcat\Admin\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->group(['prefix' => 'district'], function (Router $router) {
        $router->resource('departments', 'District\DepartmentController');
        $router->resource('task-groups', 'District\TaskGroupController');
        $router->resource('automobiles', 'District\AutomobileController');
        $router->resource('instruments', 'District\InstrumentController');
        $router::resource('users', 'District\UserController');
    });

    // 网络故障
    $router->group(['prefix' => 'fault'], function (Router $router) {
        // 故障来源
        $router->resource('source', 'Fault\SourceController');
        // 故障性质
        $router->resource('nature', 'Fault\NatureController');
        // 故障列表
        $router->resource('list', 'Fault\NetworkFaultController');
    });
});
