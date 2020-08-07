<?php

namespace App\Models\District;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const GENDER_MAN = 1;
    const GENDER_WOMAN = 2;

    protected $fillable = [
        'name', 'email', 'gender', 'mobile', 'phone', 'group_cornet', 'type'
    ];

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function user_major()
    {
        return $this->hasOne(UserMajor::class, 'user_id', 'id');
    }

    /**
     * 项目部
     */
    public function areaStand()
    {
        return $this->belongsToMany(AreaStand::class);
    }

    /**
     * 部门
     */
    public function department()
    {
        return $this->belongsToMany(Department::class);
    }

    /**
     * 班组
     */
    public function group()
    {
        return $this->belongsToMany(TaskGroup::class);
    }

    /**
     * 专业
     */
    public function major()
    {
        return $this->belongsToMany(Major::class);
    }

    /**
     * 岗位
     */
    public function post()
    {
        return $this->belongsToMany(Post::class);
    }
}
