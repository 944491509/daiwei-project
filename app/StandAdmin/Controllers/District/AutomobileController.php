<?php


namespace App\StandAdmin\Controllers\District;


use App\Admin\Actions\Automobile\ImportAction;
use App\Admin\Actions\Automobile\OutputAction;
use App\Dao\District\UserDao;
use App\Models\District\Automobile;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

class AutomobileController extends AdminController
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '车辆';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $model = new Automobile();
        $areaStandId = session('AreaStandId');
        $grid = (new Grid($model));
        $grid->model()->with(['driver','stand'])->where(['stand_id'=>$areaStandId]);
        // 去掉默认的id过滤器
        $grid->column('number', __('Number'));
        $grid->column('type', __('Type'))->using(
            $model->allCatType()
        );
        $grid->column('bought_company', __('Bought company'));
        $grid->column('car_owner', __('Car owner'));
        $grid->column('driver.name', __('Driver'));
        $grid->column('nature', __('Nature'))->using(
            $model->allNature()
        );
        $grid->column('use', __('Use'))->using(
            $model->allUse()
        );
        $grid->column('bought_at', __('Bought at'));
        $grid->column('created_at', __('Created at'));
        // 添加到列表上
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new OutputAction());
            $tools->append(new ImportAction());
        });
        return $grid;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $automobile = new Automobile();
        $nature = $automobile->allNature();
        $use= $automobile->allUse();
        $userDao = new UserDao();
        $areaStandId = session('AreaStandId');
        $users = $userDao->getDriverByStandId($areaStandId);
        $driver = [];
        foreach ($users as $key => $item) {
            $driver[$item->id] = $item->name;
        }
        // 这里需要显式地指定关联关系
        $type = $automobile->allCatType();
        $form = new Form($automobile);
        $form->column(1/2, function ($form) use ($type, $nature, $use, $driver, $areaStandId){
            $form->hidden('stand_id')->default($areaStandId);
            $form->text('number', __('Number'))
                ->creationRules(['required', "unique:automobiles"])
                ->updateRules(['required', "unique:automobiles,number,{{id}}"]);
            $form->select('type', __('Type'))->options($type)->required();

            $form->select('user_id', __('Driver'))->options($driver)->required();

            $form->select('nature', __('Nature'))->options($nature)->required();
            $form->select('use', __('Use'))->options($use)->required();

            $form->text('car_owner', __('Car owner'));
            $form->text('manufacturers', __('Manufacturers'));
            $form->currency('price', '购买'.__('Price'))->symbol('￥');
            $form->currency('rent', __('Rent'))->symbol('￥');
            $form->date('bought_at', __('Bought at'))->default(date('Y-m-d'));
            $form->text('model', '车辆'.__('Model'));
            $form->text('displacement', __('Displacement'));
        });

        $form->column(1/2, function ($form) {

            $form->text('bought_company', __('Bought company'));
            $form->text('oil_wear', __('Oil wear'));
            $form->text('engine_num', __('Engine num'));
            $form->text('vin', __('Vin'));
            $form->text('loads', __('Loads'));
            $form->multipleImage('image','图片')->autoUpload()
                ->disk('alioss')->saving(function ($paths) {
                    return implode(',', $paths);
                });
            $form->textarea('explain', '车辆'.__('Explain'));

        });

        return $form;
    }

}
