<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMenusInStandAdminTroubleTable extends Migration
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
            'order' => 0,
            'title' => '网络隐患',
            'icon' => 'fa-chain-broken',
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
        ];
        $id = DB::table('stand_admin_menu')->insertGetId($menu);

        $data = [
            [
                'parent_id' => $id,
                'order' => 1,
                'title' => '隐患申报',
                'icon' => 'fa-clipboard',
                'uri' => 'trouble/trouble-form',
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ]
        ];
        DB::table('stand_admin_menu')->insert($data);
    }

    /**
     * Reverse the migrations.`
     *
     * @return void
     */
    public function down()
    {
        $title = ['网络隐患', '网络隐患申报'];
        DB::table('stand_admin_menu')->whereIn('title', $title)->delete();
    }
}
