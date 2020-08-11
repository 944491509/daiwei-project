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

use Dcat\Admin\Grid;
use Dcat\Admin\Form;

Grid::resolving(function (Grid $grid) {
    $grid->disableViewButton();

});


Form::resolving(function (Form $form) {
    $form->disableViewButton();
    $form->disableEditingCheck();
    $form->disableCreatingCheck();
    $form->disableViewCheck();
    $form->tools(function (Form\Tools $tools) {
        $tools->disableDelete();
    });

});


