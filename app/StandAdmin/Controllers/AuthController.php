<?php

namespace App\StandAdmin\Controllers;

use Dcat\Admin\Form;
use App\StandAdmin\StandAdmin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Controllers\AuthController as BaseAuthController;

class AuthController extends BaseAuthController
{
    /**
     * User setting page.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $form = $this->settingForm();
        $form->tools(
            function (Form\Tools $tools) {
                $tools->disableList();
            }
        );

        return $content
            ->title(trans('admin.user_setting'))
            ->body($form->edit(StandAdmin::user()->getKey()));
    }
}
