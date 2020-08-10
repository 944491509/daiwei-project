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
        $router->resource('departments', District\DepartmentController::class);
        $router->resource('task-groups', District\TaskGroupController::class);
        $router->resource('automobiles', District\AutomobileController::class);
        $router->resource('instruments', District\InstrumentController::class);
    });

    // 网络故障
    $router->group(['prefix' => 'fault'], function (Router $router) {
        // 故障来源
        $router->resource('source', Fault\SourceController::class);
        // 故障性质
        $router->resource('nature', Fault\NatureController::class);
        // 故障列表
        $router->resource('list', Fault\NetworkFaultController::class);
    });

});
