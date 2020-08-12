<?php

namespace App\Admin\Controllers\District;

use App\Models\Stand\StandAdminUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator as AdministratorModel;
use Dcat\Admin\Models\Repositories\Administrator;
use Illuminate\Http\Request;

class StandAdminUserController extends AdminController
{

    protected $title = '项目部管理员';


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $areaStandId = request()->get('area_stand_id');
        session(['area_stand_id'=>$areaStandId]);

        $model = (new StandAdminUser())->where(['area_stand_id'=>$areaStandId]);
        $grid = Grid::make($model);
        $grid->id->sortable();
        $grid->username;
        $grid->name;
        $grid->created_at;
        $grid->model()->setConstraints([
            'area_stand_id' => $areaStandId,
        ]);
        return $grid;

    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new \App\Models\Stand\Repositories\StandAdminUser('roles'), function (Form $form) {
            $areaStandId = request()->get('area_stand_id');
            $userTable = config('stand-admin.database.users_table');

            $connection = config('stand-admin.database.connection');
            $id = $form->getKey();
            $form->display('id', 'ID');
            $form->hidden('area_stand_id')->default($areaStandId);
            $form->text('username', trans('admin.username'))
                ->required()
                ->creationRules(['required', "unique:{$connection}.{$userTable}"])
                ->updateRules(['required', "unique:{$connection}.{$userTable},username,$id"]);
            $form->text('name', trans('admin.name'))->required();
            $form->image('avatar', trans('admin.avatar'));

            if ($id) {
                $form->password('password', trans('admin.password'))
                    ->minLength(5)
                    ->maxLength(20)
                    ->customFormat(function () {
                        return '';
                    });
            } else {
                $form->password('password', trans('admin.password'))
                    ->required()
                    ->minLength(5)
                    ->maxLength(20);
            }

            $form->password('password_confirmation', trans('admin.password_confirmation'))->same('password');

            $form->ignore(['password_confirmation']);

            if (config('stand-admin.permission.enable')) {
                $roleModel = config('stand-admin.database.roles_model');

                $roles = $roleModel::all()->pluck('name', 'id');
                $form->multipleSelect('roles', trans('admin.roles'))
                    ->options($roles)
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            }

            $form->display('created_at', trans('admin.created_at'));
            $form->display('updated_at', trans('admin.updated_at'));

            if ($id == AdministratorModel::DEFAULT_ID) {
                $form->disableDeleteButton();
            };
            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->get('password') != $form->password) {
                    $form->password = bcrypt($form->password);
                }

                if (!$form->password) {
                    $form->deleteInput('password');
                }

            });
        });
    }
}
