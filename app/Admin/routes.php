<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
//    'domain' => config('admin.route.domain'),
    'prefix'        => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('area-stands', 'District\AreaStandController');

    //  区站基础管理
    $router->group(['prefix' => 'district'], function (Router $router) {
        $router->resource('users', 'District\UserController');
        $router->resource('area-stands', 'District\AreaStandController');
        $router->resource('facilitators', 'District\FacilitatorsController');
        $router->resource('departments', 'District\DepartmentController');
        $router->resource('posts', 'District\PostController');
        $router->resource('task-groups', 'District\TaskGroupController');
        $router->resource('majors', 'District\MajorController');
        $router->resource('automobiles', 'District\AutomobileController');
        $router->any('outputExcel', 'District\AutomobileController@outputExcel');
        $router->resource('instruments', 'District\InstrumentController');
        $router->resource('StandUser', 'District\StandAdminUserController');

    });

    // 基础资料
    $router->group(['prefix' => 'initialValue'], function (Router $router) {
        $router->resource('professional-skills', 'InitialValue\ProfessionalSkillController');
    });


    // 网络隐患
    $router->group(['prefix' => 'trouble'], function (Router $router) {
        $router->resource('trouble-form', 'Trouble\TroubleFormController');
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
