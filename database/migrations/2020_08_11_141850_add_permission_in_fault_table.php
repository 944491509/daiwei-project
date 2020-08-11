<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionInFaultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            DB::beginTransaction();
            $parent = [
                'name' => '故障管理',
                'slug' => 'fault',
                'http_path' => '',
                'order' => 8,
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $p1 = DB::table('stand_admin_permissions')->insertGetId($parent);
            // 故障来源
            $source = [
                'name' => '故障来源',
                'slug' => 'fault.source',
                'http_path' => '',
                'order' => 1,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $sourceId = DB::table('stand_admin_permissions')->insertGetId($source);
            $sources = [
                [
                    'name' => '列表',
                    'slug' => 'source.list',
                    'http_path' => '/fault/source',
                    'order' => 1,
                    'parent_id' => $sourceId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'source.create',
                    'http_path' => '/fault/source/create',
                    'order' => 2,
                    'parent_id' => $sourceId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'source.edit',
                    'http_path' => '/fault/source/*/edit',
                    'order' => 3,
                    'parent_id' => $sourceId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($sources);

            // 故障性质
            $nature = [
                'name' => '故障性质',
                'slug' => 'fault.nature',
                'http_path' => '',
                'order' => 2,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $natureId = DB::table('stand_admin_permissions')->insertGetId($nature);
            $natures = [
                [
                    'name' => '列表',
                    'slug' => 'nature.list',
                    'http_path' => '/fault/nature',
                    'order' => 1,
                    'parent_id' => $natureId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'nature.create',
                    'http_path' => '/fault/nature/create',
                    'order' => 2,
                    'parent_id' => $natureId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'nature.edit',
                    'http_path' => '/fault/nature/*/edit',
                    'order' => 3,
                    'parent_id' => $natureId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($natures);

            // 故障列表
            $list = [
                'name' => '故障列表',
                'slug' => 'fault.list',
                'http_path' => '',
                'order' => 3,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $listId = DB::table('stand_admin_permissions')->insertGetId($list);
            $lists = [
                [
                    'name' => '列表',
                    'slug' => 'list.list',
                    'http_path' => '/fault/list',
                    'order' => 1,
                    'parent_id' => $listId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'list.create',
                    'http_path' => '/fault/list/create',
                    'order' => 2,
                    'parent_id' => $listId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'list.edit',
                    'http_path' => '/fault/list/*/edit',
                    'order' => 3,
                    'parent_id' => $listId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($lists);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            DB::beginTransaction();
            $parent = DB::table('stand_admin_permissions')->where(['name'=>'故障管理'])->first();
            $list = DB::table('stand_admin_permissions')->where(['parent_id'=>$parent->id])->get();
            foreach ($list as $key => $item) {
                DB::table('stand_admin_permissions')->where(['parent_id'=>$item->id])->delete();
            }
            DB::table('stand_admin_permissions')->where(['parent_id'=>$parent->id])->delete();
            DB::table('stand_admin_permissions')->where(['id'=>$parent->id])->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
