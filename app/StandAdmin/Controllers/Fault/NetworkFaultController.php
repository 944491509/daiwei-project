<?php

namespace App\StandAdmin\Controllers\Fault;

use App\Dao\District\AreaStandDao;
use App\Dao\Fault\SourceDao;
use App\Models\Fault\NetworkFault;
use App\Models\Fault\NetworkFaultNature;
use App\Models\Fault\NetworkFaultSource;
use App\Models\Fault\NetworkFaultTime;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;

class NetworkFaultController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '故障';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $areaStandId = session('AreaStandId');
        $model = new NetworkFault();
        $grid = new Grid($model->where(['area_stand_id'=>$areaStandId]));
        $grid->model()->with(['source','time', 'nature']);

        $grid->column('id', __('Id'));
        $grid->column('source.name', __('Source'));
        $grid->column('nature.name', __('Nature'));
        $grid->column('time.hour', __('Times'));
        $grid->column('kind', __('Kind'))->using(
            $model->allKind()
        );
        $grid->column('happen_time', __('HappenTime'));
        $grid->column('accept_time', __('AcceptTime'));
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
        $model = new NetworkFault();
        $form = new Form($model);
        $kinds = $model->allKind();
        $areaStandId = session('AreaStandId');
        $sourceDao = new SourceDao();
        $sources = $sourceDao->getSourcesByAreaStandId($areaStandId);
        $list = [];
        foreach ($sources as $key => $item) {
            $list[$item->id] = $item->name;
        }
        $form->hidden('area_stand_id')->default($areaStandId);
        $form->select('source_id', __('Source'))->options($list)->load('nature_id',
            url('/api/fault/getNatureBySourceId'), 'id', 'name');
        $form->select('nature_id', '故障'.__('Nature'))->options(function ($id) {
            return NetworkFaultNature::where('id', $id)->pluck('name', 'id'); // 回显
        })->load('time_id', url('/api/fault/getTimesByNatureId'), 'id', 'hour');

        $form->select('time_id', __('Times'))->options(function ($id) {
            return NetworkFaultTime::where('id', $id)->pluck('hour', 'id');
        });
        $form->select('kind', __('Kind'))->options($kinds);
        $form->datetime('happen_time', __('HappenTime'))->default(date('Y-m-d'));
        $form->datetime('accept_time', __('AcceptTime'))->default(date('Y-m-d H:i:s'));
        $form->textarea('business', '故障'.__('Business'));
        $form->textarea('message', '故障'.__('Message'));

        return $form;
    }
}
