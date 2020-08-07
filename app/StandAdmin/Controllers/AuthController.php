<?php

namespace App\StandAdmin\Controllers;

use App\Models\Stand\StandAdminUser;
use Dcat\Admin\Form;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AuthController as BaseAuthController;
use Dcat\Admin\Layout\Content;

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
