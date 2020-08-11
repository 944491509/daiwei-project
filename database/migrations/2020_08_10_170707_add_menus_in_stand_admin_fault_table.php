<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenusInStandAdminFaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 添加一级菜单
        $menu = [
            'parent_id' => 0,
            'order' => 4,
            'title' => '故障管理',
            'icon' => 'fa-exclamation-triangle',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ];
        $id = DB::table('stand_admin_menu')->insertGetId($menu);
        $data = [
            [
                'parent_id' => $id,
                'order' => 1,
                'title' => '故障来源',
                'icon' => 'fa-soundcloud',
                'uri' => 'fault/source',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
            [
                'parent_id' => $id,
                'order' => 2,
                'title' => '故障性质',
                'icon' => 'fa-code-fork',
                'uri' => 'fault/nature',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
            [
                'parent_id' => $id,
                'order' => 3,
                'title' => '故障列表',
                'icon' => 'fa-list',
                'uri' => 'fault/list',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ],
        ];
        DB::table('stand_admin_menu')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $title = ['故障管理', '故障来源', '故障性质', '故障列表'];
        DB::table('stand_admin_menu')->whereIn('title', $title)->delete();
    }
}
