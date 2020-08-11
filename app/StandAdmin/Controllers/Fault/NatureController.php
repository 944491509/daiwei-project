<?php

namespace App\StandAdmin\Controllers\Fault;

use App\Dao\District\AreaStandDao;
use App\Dao\Fault\SourceDao;
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
        $areaStandId = session('AreaStandId');
        $model = (new NetworkFaultNature());
        $grid = new Grid($model->where(['area_stand_id'=>$areaStandId]));
        $grid->model()->with(['source','times']);
        $grid->column('id', __('Id'));
        $grid->column('type', '故障'.__('Type'))->using(
            $model->allType()
        );
        $grid->column('source.name', '故障'.__('Source'));
        $grid->column('name', __('Name'));
        $grid->column('times',__('Times'))->display(function ($times) {
            $res = array_map(function ($times) {
                return "<span class='label' style='background-color: rgba(0,75,166,0.8);'>{$times['hour']}小时</span>";
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
        $areaStandId = session('AreaStandId');
        $model = new NetworkFaultNature();
        $type = $model->allType();
        $form = new Form($model);
        $sourceDao = new SourceDao();
        $sources = $sourceDao->getSourcesByAreaStandId($areaStandId);
        $list= [];
        foreach ($sources as $key => $item) {
            $list[$item->id] = $item->name;
        }
        $form->hidden('area_stand_id')->default($areaStandId);
        $form->radio('type', '故障'.__('Type'))
            ->options($type)->when(1, function (Form $form) use ($list){

                $form->select('source_id', '故障'.__('Source'))->options($list);
                $form->hasMany('times',__('Times'), function (Form\NestedForm $form) {
                    $form->number('hour', __('Hour'));
                });
            })->default(1);
            $form->text('name', '性质'.__('Name'))->required();

        return $form;
    }
}
