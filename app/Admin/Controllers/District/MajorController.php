<?php

namespace App\Admin\Controllers\District;

use App\Dao\District\PostDao;
use App\Models\District\Major;
use App\Models\District\Post;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class MajorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '专业管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Major());
        $postDao = new PostDao;
        $posts = $postDao->getAllPost();

        $data = [];
        foreach ($posts as $key => $val) {
            $data[$val->id] = $val->name;
        }
        // 快速添加
        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) use ($data) {
            $create->select('post_id', '所属岗位')->options($data)->required();
            $create->text('name', '专业名称')->required();
        });

        $grid->disableFilter(); // 去掉筛选

        // 列表
        $grid->column('posts.name', '所属岗位');
        $grid->column('name', '专业')->filter();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));


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
