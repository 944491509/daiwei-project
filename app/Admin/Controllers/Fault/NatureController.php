<?php

namespace App\Admin\Controllers\Fault;

use App\Dao\District\AreaStandDao;
use App\Models\Fault\NetworkFaultNature;
use App\Models\Fault\NetworkFaultSource;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class NatureController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '故障性质';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model = new NetworkFaultNature();
        $grid = new Grid($model);
        $grid->model()->with(['source','times']);
        $grid->column('id', __('Id'));
        $grid->column('type', '故障'.__('Type'))->using(
            $model->allType()
        );
        $grid->column('source.name', '故障'.__('Source'));
        $grid->column('name', __('Name'));
        $grid->column('times',__('Times'))->display(function ($times) {
            $res = array_map(function ($times) {
                return "<span class='label' style='background-color: #00a65a;'>{$times['hour']}小时</span>";
            }, $times);
            return join(' ', $res);
        });

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
        $model = new NetworkFaultNature();
        $type = $model->allType();
        $form = new Form($model);
        $areaStandDao  = new AreaStandDao;
        $stands = $areaStandDao->getAreaStandOption();
        $form->radio('type', '故障'.__('Type'))
            ->options($type)->when(1, function (Form $form) use ($stands){

                $form->select('area_stand_id', __('Stand'))->options($stands)
                    ->load('source_id','/api/fault/getSourceByStandId', 'id', 'name');
                $form->select('source_id', '故障'.__('Source'))->options(function ($id) {
                    return NetworkFaultSource::where('id', $id)->pluck('name', 'id'); // 回显
                });
                $form->hasMany('times',__('Times'), function (Form\NestedForm $form) {
                    $form->number('hour', __('Hour'));
                });
            })->when(2, function (Form $form) use($stands){
                $form->select('area_stand_id', __('Stand'))->options($stands);
            })->required();
            $form->text('name', '性质'.__('Name'))->required();

        return $form;
    }
}
