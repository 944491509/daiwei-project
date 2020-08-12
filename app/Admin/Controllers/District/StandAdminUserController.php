<?php

namespace App\Admin\Controllers\District;

use App\Models\Stand\StandAdminUser;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Controllers\AdminController;
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

        return Grid::make(new StandAdminUser(), function (Grid $grid) {
            $grid->id->sortable();
            $grid->username;
            $grid->name;
            $grid->created_at;

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('area_stand_id');
            });
        });
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new StandAdminUser(), function (Form $form) {
            $form->display('id');
            $form->text('username');
            $form->text('password');
            $form->text('name');
            $form->text('avatar');
            $form->text('remember_token');
            $form->text('area_stand_id');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
