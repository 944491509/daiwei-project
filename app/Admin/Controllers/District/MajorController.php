<?php

namespace App\Admin\Controllers\District;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use App\Dao\District\PostDao;
use App\Models\District\Major;
use Dcat\Admin\Controllers\AdminController;

class MajorController extends AdminController
{
    protected $title = '专业管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Major());
        $grid->model()->with(['posts']);

        // 列表
        $grid->column('posts.name', '所属岗位')->filter();
        $grid->column('name', '专业');
        $grid->column('created_at', __('Created at'));

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
        $show = new Show(Major::findOrFail($id));


        return $show;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Major());
        $postDao = new PostDao;
        $posts = $postDao->getAllPost();

        $data = [];
        foreach ($posts as $key => $val) {
            $data[$val->id] = $val->name;
        }
        $form->select('post_id', '所属岗位')->options($data)->required();
        $form->text('name', '专业名称');

        return $form;
    }


}
