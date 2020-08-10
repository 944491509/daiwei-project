<?php

use Illuminate\Database\Seeder;
use App\Models\Stand\StandAdminMenu;

class StandAdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $model = new StandAdminMenu;
        $data = [
            'parent_id'=> 0,
            'order' => 0,
            'title' => '区站基础资料',
            'icon' => 'fa-bars',
        ];

        $result = $model->create($data);
        $add = [
            [
                'parent_id' => $result->id,
                'order' => 1,
                'title' => '部门管理',
                'icon' => 'fa-user',
                'uri' => 'district/departments',
            ],
            [
                'parent_id' => $result->id,
                'order' => 2,
                'title' => '班组管理',
                'icon' => 'fa-group',
                'uri' => 'district/task-groups',
            ],
            [
                'parent_id' => $result->id,
                'order' => 3,
                'title' => '人员管理',
                'icon' => 'fa-user',
                'uri' => 'district/users',
            ],
            [
                'parent_id' => $result->id,
                'order' => 4,
                'title' => '车辆管理',
                'icon' => 'fa-car',
                'uri' => 'district/automobiles',
            ],
            [
                'parent_id' => $result->id,
                'order' => 5,
                'title' => '仪器管理',
                'icon' => 'fa-balance-scale',
                'uri' => 'district/instruments',
            ],

        ];

        foreach ($add as $key => $item) {
            $model->create($item);
        }

    }
}
