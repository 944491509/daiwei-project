<?php

namespace App\Admin\Controllers\District;

use App\Dao\District\AreaStandDao;
use App\Models\District\Department;
use App\Models\District\Post;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '岗位管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $post = new Post();
        $grid = new Grid($post);
        $grid->column('id', __('Id'));
        $grid->column('name', '岗位' . __('Name'));
        $grid->column('explain', __('Explain'));
        $grid->column('require', __('Require'));
        $grid->column('level', __('Level'));
        $grid->column('belong_to', __('BelongTo'))->display(function ()use($post) {
            $belongTos = $post->getAllBelongTo();
            $data = [];
            foreach ($this->belong_to as $key => $item) {
                $data[] = $belongTos[$item];
            }
            return implode(',', $data);
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->disableFilter(); // 去掉筛选

        return $grid;
    }



    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $post = new Post();
        $form = new Form($post);
        $belongTo = $post->getAllBelongTo();

        $form->text('name', __('Name'))->required();
        $form->multipleSelect('belong_to', __('BelongTo'))->options($belongTo)->required();
        $form->textarea('require', __('Require'));
        $form->textarea('explain', __('Explain'));
        $form->number('level', __('Level'))->default(1)->required();
        return $form;
    }
}
