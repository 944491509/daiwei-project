<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Dcat\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Dcat\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use Dcat\Admin\Form;
use Dcat\Admin\Grid;

//Dcat\Admin\Form::forget(['map', 'editor']);
//Form::init(function (Form $form) {
//    $form->disableViewCheck();
//    $form->tools(function (Form\Tools $tools) {
//        $tools->disableDelete();
//        $tools->disableView();
//    });
//});
//
//Grid::init(function (Grid $grid) {
//    $grid->actions(function (Grid\Displayers\Actions $actions) {
//        $actions->disableView();
//        $actions->disableDelete();
//    });
//});
