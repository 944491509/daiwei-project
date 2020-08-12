<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddAdminPermissionInDistrictTable extends Migration
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
                'name' => '区站基础资料',
                'slug' => 'district',
                'http_path' => '',
                'order' => 7,
                'parent_id' => 0,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $p1 = DB::table('admin_permissions')->insertGetId($parent);
            // 服务商
            $facilitator = [
                'name' => '服务商',
                'slug' => 'district.facilitators',
                'http_path' => '',
                'order' => 1,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $facilitatorId = DB::table('admin_permissions')->insertGetId($facilitator);
            $facilitators = [
                [
                    'name' => '列表',
                    'slug' => 'facilitators.list',
                    'http_path' => '/district/facilitators',
                    'order' => 1,
                    'parent_id' => $facilitatorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'facilitators.create',
                    'http_path' => '/district/facilitators/create',
                    'order' => 2,
                    'parent_id' => $facilitatorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'facilitators.edit',
                    'http_path' => '/district/facilitators/*/edit',
                    'order' => 3,
                    'parent_id' => $facilitatorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('admin_permissions')->insert($facilitators);
            // 项目部管理
            $areaStand = [
                'name' => '部门管理',
                'slug' => 'district.area-stands',
                'http_path' => '',
                'order' => 2,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $areaStandId = DB::table('admin_permissions')->insertGetId($areaStand);
            $areaStands = [
                [
                    'name' => '列表',
                    'slug' => 'area-stands.list',
                    'http_path' => '/district/area-stands',
                    'order' => 1,
                    'parent_id' => $areaStandId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'area-stands.create',
                    'http_path' => '/district/area-stands/create',
                    'order' => 2,
                    'parent_id' => $areaStandId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'area-stands.edit',
                    'http_path' => '/district/area-stands/*/edit',
                    'order' => 3,
                    'parent_id' => $areaStandId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('admin_permissions')->insert($areaStands);

            // 部门
            $department = [
                'name' => '部门管理',
                'slug' => 'district.departments',
                'http_path' => '',
                'order' => 3,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $departmentId = DB::table('admin_permissions')->insertGetId($department);
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
            DB::table('admin_permissions')->insert($departments);

            //专业
            $major = [
                'name' => '专业管理',
                'slug' => 'district.majors',
                'http_path' => '',
                'order' => 4,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $majorId = DB::table('admin_permissions')->insertGetId($major);
            $majors = [
                [
                    'name' => '列表',
                    'slug' => 'majors.list',
                    'http_path' => '/district/majors',
                    'order' => 1,
                    'parent_id' => $majorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'majors.create',
                    'http_path' => '/district/majors/create',
                    'order' => 2,
                    'parent_id' => $majorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'majors.edit',
                    'http_path' => '/district/majors/*/edit',
                    'order' => 3,
                    'parent_id' => $majorId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('admin_permissions')->insert($majors);

            // 岗位
            $post = [
                'name' => '岗位管理',
                'slug' => 'district.posts',
                'http_path' => '',
                'order' => 5,
                'parent_id' => $p1,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ];
            $postId = DB::table('admin_permissions')->insertGetId($post);
            $posts = [
                [
                    'name' => '列表',
                    'slug' => 'posts.list',
                    'http_path' => '/district/posts',
                    'order' => 1,
                    'parent_id' => $postId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '新增',
                    'slug' => 'posts.create',
                    'http_path' => '/district/posts/create',
                    'order' => 2,
                    'parent_id' => $postId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
                [
                    'name' => '编辑',
                    'slug' => 'posts.edit',
                    'http_path' => '/district/posts/*/edit',
                    'order' => 3,
                    'parent_id' => $postId,
                    'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                    'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
                ],
            ];
            DB::table('admin_permissions')->insert($posts);

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
            $taskGroupId = DB::table('admin_permissions')->insertGetId($taskGroup);
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
            DB::table('admin_permissions')->insert($taskGroups);
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
            $userId = DB::table('admin_permissions')->insertGetId($user);
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
            DB::table('admin_permissions')->insert($users);

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
            $automobileId = DB::table('admin_permissions')->insertGetId($automobile);
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
            DB::table('admin_permissions')->insert($automobiles);

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
            $instrumentId = DB::table('admin_permissions')->insertGetId($instrument);
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
            DB::table('admin_permissions')->insert($instruments);
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
            $parent = DB::table('admin_permissions')->where(['name'=>'区站基础资料'])->first();
            $list = DB::table('admin_permissions')->where(['parent_id'=>$parent->id])->get();
            foreach ($list as $key => $item) {
                DB::table('admin_permissions')->where(['parent_id'=>$item->id])->delete();
            }
            DB::table('admin_permissions')->where(['parent_id'=>$parent->id])->delete();
            DB::table('admin_permissions')->where(['id'=>$parent->id])->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

    }
}
