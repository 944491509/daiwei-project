<?php

namespace App\Admin\Controllers\District;

use App\Dao\District\AreaStandDao;
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

        $grid = new Grid(new TaskGroup());
<<<<<<< HEAD
        $grid->model()->with(['areaStand', 'department']);

=======
        $grid->model()->with(['areaStand','department']);
>>>>>>> 72adb433a79a2e98083bddd671891296983f361a
        $grid->column('id', __('Id'));
        $grid->column('areaStand.name', __('Stand'));
        $grid->column('department.name', __('Department'));
        $grid->column('name', '班组' . __('Name'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableFilter(); // 去掉筛选

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(TaskGroup::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('stand_id', __('Stand id'));
        $show->field('department_id', __('Department id'));
        $show->field('name', __('Name'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
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
        $areaStandDao = new AreaStandDao();
        $stands = $areaStandDao->getAreaStandOption();

        $form->select('stand_id', __('Stand'))->options($stands)
            ->load('department_id',
                '/api/stand/get-departments','id',
                'name')->required();

        $form->select('department_id', __('Department'))->options(function ($id) {
            return Department::where('id', $id)->pluck('name', 'id');
        })->required();
        $form->text('name', '班组'.__('Name'))->required();

        return $form;
    }
}
