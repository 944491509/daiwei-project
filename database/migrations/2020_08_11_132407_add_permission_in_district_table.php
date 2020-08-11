<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPermissionInDistrictTable extends Migration
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
            $data1 = [
                'name' => '区站基础资料',
                'slug' => 'district',
                'http_path' => '',
                'order' => 7,
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $p1 = DB::table('stand_admin_permissions')->insertGetId($data1);
            // 部门
            $department = [
                'name' => '部门管理',
                'slug' => 'district.departments',
                'http_path' => '',
                'order' => 1,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $departmentId = DB::table('stand_admin_permissions')->insertGetId($department);
            $departments = [
                [
                    'name' => '列表',
                    'slug' => 'departments.list',
                    'http_path' => '/district/departments',
                    'order' => 1,
                    'parent_id' => $departmentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'departments.create',
                    'http_path' => '/district/departments/create',
                    'order' => 2,
                    'parent_id' => $departmentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'departments.edit',
                    'http_path' => '/district/departments/*/edit',
                    'order' => 3,
                    'parent_id' => $departmentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($departments);
            // 班组
            $taskGroup = [
                'name' => '班组管理',
                'slug' => 'district.task-groups',
                'http_path' => '',
                'order' => 2,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $taskGroupId = DB::table('stand_admin_permissions')->insertGetId($taskGroup);
            $taskGroups = [
                [
                    'name' => '列表',
                    'slug' => 'task-groups.list',
                    'http_path' => '/district/task-groups',
                    'order' => 1,
                    'parent_id' => $taskGroupId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'task-groups.create',
                    'http_path' => '/district/task-groups/create',
                    'order' => 2,
                    'parent_id' => $taskGroupId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'task-groups.edit',
                    'http_path' => '/district/task-groups/*/edit',
                    'order' => 3,
                    'parent_id' => $taskGroupId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($taskGroups);
            // 人员
            $user = [
                'name' => '人员管理',
                'slug' => 'district.users',
                'http_path' => '',
                'order' => 3,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $userId = DB::table('stand_admin_permissions')->insertGetId($user);
            $users = [
                [
                    'name' => '列表',
                    'slug' => 'users.list',
                    'http_path' => '/district/users',
                    'order' => 1,
                    'parent_id' => $userId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'users.create',
                    'http_path' => '/district/users/create',
                    'order' => 2,
                    'parent_id' => $userId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'users.edit',
                    'http_path' => '/district/users/*/edit',
                    'order' => 3,
                    'parent_id' => $userId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($users);

            // 车辆
            $automobile = [
                'name' => '车辆管理',
                'slug' => 'district.automobiles',
                'http_path' => '',
                'order' => 4,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $automobileId = DB::table('stand_admin_permissions')->insertGetId($automobile);
            $automobiles = [
                [
                    'name' => '列表',
                    'slug' => 'automobiles.list',
                    'http_path' => '/district/automobiles',
                    'order' => 1,
                    'parent_id' => $automobileId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'automobiles.create',
                    'http_path' => '/district/automobiles/create',
                    'order' => 2,
                    'parent_id' => $automobileId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'automobiles.edit',
                    'http_path' => '/district/automobiles/*/edit',
                    'order' => 3,
                    'parent_id' => $automobileId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($automobiles);

            // 仪器
            $instrument = [
                'name' => '仪器管理',
                'slug' => 'district.instruments',
                'http_path' => '',
                'order' => 5,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $instrumentId = DB::table('stand_admin_permissions')->insertGetId($instrument);
            $instruments = [
                [
                    'name' => '列表',
                    'slug' => 'instruments.list',
                    'http_path' => '/district/instruments',
                    'order' => 1,
                    'parent_id' => $instrumentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'instruments.create',
                    'http_path' => '/district/instruments/create',
                    'order' => 2,
                    'parent_id' => $instrumentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'instruments.edit',
                    'http_path' => '/district/instruments/*/edit',
                    'order' => 3,
                    'parent_id' => $instrumentId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('stand_admin_permissions')->insert($instruments);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e ->getMessage());
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
            $parent = DB::table('stand_admin_permissions')->where(['name'=>'区站基础资料'])->first();
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
