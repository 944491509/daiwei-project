<?php

namespace App\StandAdmin\Controllers\Fault;

use App\Dao\District\AreaStandDao;
use App\Models\Fault\NetworkFaultSource;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

class SourceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '故障来源';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $areaStandId = session('AreaStandId');
        $model = (new NetworkFaultSource())->where(['area_stand_id'=>$areaStandId]);
        $grid = new Grid($model);
        $grid->model()->with(['stand']);
        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('created_at', __('Created at'));

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
        $form = new Form(new NetworkFaultSource());
        $form->hidden('area_stand_id')->default($areaStandId);
        $form->text('name', __('Name'))->required();

        return $form;
    }
}
