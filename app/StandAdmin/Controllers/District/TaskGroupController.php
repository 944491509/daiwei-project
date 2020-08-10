<?php

namespace App\StandAdmin\Controllers\District;

use App\Dao\District\AreaStandDao;
use App\Dao\District\DepartmentDao;
use App\Models\District\Department;
use App\Models\District\TaskGroup;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class TaskGroupController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '班组管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $areaStandId = session('AreaStandId');

        $model = (new TaskGroup())->where(['stand_id'=>$areaStandId]);
        $grid = new Grid($model);
        $grid->model()->with(['areaStand', 'department']);
        $grid->column('id', __('Id'));
        $grid->column('department.name', __('Department'));
        $grid->column('name', '班组' . __('Name'));
        $grid->column('created_at', __('Created at'));

        $grid->disableFilter(); // 去掉筛选

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $taskGroup = new TaskGroup();
        $form = new Form($taskGroup);
        $areaStandId = session('AreaStandId');
        $departmentDao = new DepartmentDao();
        $departments = $departmentDao->getDepartmentsByStandId($areaStandId);
        $list = [];
        foreach ($departments as $key => $item) {
            $list[$item->id] = $item->name;
        }
        $form->hidden('stand_id')->default($areaStandId);
        $form->select('department_id', __('Department'))->options($list)->required();
        $form->text('name', '班组'.__('Name'))->required();

        return $form;
    }
}
