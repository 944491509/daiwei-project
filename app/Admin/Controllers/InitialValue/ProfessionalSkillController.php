<?php

namespace App\Admin\Controllers\InitialValue;

use App\Models\InitialValue\ProfessionalSkill;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;
use function foo\func;

class ProfessionalSkillController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '专业技能';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProfessionalSkill());
        $grid->model()->with(['classes']);
        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'));
        $grid->column('classes',__('professionalClasses'))->display(function ($class) {

                $res = array_map(function ($class) {
                    return $class['name']. ',';
                }, $class);

                return substr(join(' ', $res),0, -1);
        });

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
        $show = new Show(ProfessionalSkill::findOrFail($id));

        $show->field('id', __('Id'));
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
        $form = new Form(new ProfessionalSkill());
        $form->text('name', '技能'.__('Name'));
        $form->hasMany('classes',__('professionalClasses'), function (Form\NestedForm $form) {
            $form->text('name', __('Name'));
        });

        return $form;
    }



}
