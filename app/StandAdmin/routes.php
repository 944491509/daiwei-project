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
    });
});
