<?php


namespace App\StandAdmin;


use Dcat\Admin\Admin;
use Illuminate\Support\Facades\Auth;
use Dcat\Admin\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class StandAdmin extends Admin
{

    /**
     * 获取登录用户模型.
     *
     * @return Model|Authenticatable|HasPermissions
     */
    public static function user()
    {
        return static::guard()->user();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard|GuardHelpers
     */
    public static function guard()
    {
        return Auth::guard(config('stand-admin.auth.guard') ?: 'stand-admin');
    }
}
