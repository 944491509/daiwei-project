<?php


namespace App\StandAdmin\Controllers\District;


use App\Dao\District\AreaStandDao;
use App\Models\District\AreaStand;
use App\Models\District\Department;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

class DepartmentController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '部门管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $areaStandId = session('AreaStandId');
        $model = (new Department())->where(['area_stand_id'=>$areaStandId]);
        $grid = new Grid($model);
        $grid->disableFilter();

        $grid->quickSearch('name')->placeholder('搜索 部门名称');

        $grid->column('name', '部门名称');
        $grid->column('rank', '等级');

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $areaStandId = session('AreaStandId');
        $form = new Form(new Department());

        $form->hidden('area_stand_id')->default($areaStandId);
        $form->text('name', '部门名称')->required();
        $form->number('rank', '等级')->rules('required|min:0|integer')->default(0);

        return $form;
    }
}
