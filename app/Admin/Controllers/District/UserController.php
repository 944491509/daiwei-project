<?php

namespace App\Admin\Controllers\District;

use App\Dao\District\AreaStandDao;
use App\Dao\District\MajorDao;
use App\Dao\District\PostDao;
use App\Models\ChinaArea;
use App\Models\District\Department;
use App\Models\District\Major;
use App\Models\District\Post;
use App\Models\District\TaskGroup;
use App\Models\District\User;
use App\Models\District\UserProfile;
use App\Models\InitialValue\ProfessionalClass;
use App\Models\InitialValue\ProfessionalSkill;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Tests\Models\Profile;


class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '人员管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {

        $grid = new Grid(new User());

        $grid->model()->with(['profile', 'profile.areaStand', 'profile.department', 'profile.group', 'profile.major', 'profile.post']);

        $grid->quickSearch('name', 'mobile', 'phone')->placeholder('搜索 名字 手机号');
        $dao = new AreaStandDao();
        $areaDao = $dao->getAllAreaStand();
        $area = $areaDao->pluck('name', 'id');
        $postDao = new postDao;
        $postData = $postDao->getAllPost();
        $posts = [];
        foreach ($postData as $val) {
            $posts[$val->id] = $val->name;
        }

        $grid->filter(function ($filter) use ($area, $posts) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();
            $filter->column(1 / 3, function ($filter) use ($area) {
                $filter->equal('profile.area_stand_id', '项目部')->select($area)->load('profile.department_id', url('/api/stand/get-departments'), 'id', 'name');
                $filter->equal('profile.department_id', '部门')->select()->load('profile.group_id', url('/api/stand/get-group'), 'id', 'name');
            });

            $filter->column(1 / 3, function ($filter) use ($posts) {
                $filter->equal('profile.group_id', '班组')->select()->load('profile.major_id', url('/api/stand/get-major'), 'id', 'name');
                $filter->equal('profile.post_id', '岗位')->select($posts);
            });
        });
        $grid->column('profile.area_stand', '项目部')->display(function ($obj) {
            return $obj['name'];
        });
        $grid->column('profile.department', '部门')->display(function ($obj) {
            return $obj['name'];
        });
        $grid->column('profile.group', '班组')->display(function ($obj) {
            return $obj['name'];
        });
        $grid->column('profile.major', '专业')->display(function ($obj) {
            return $obj['name'] ?? '';
        });
        $grid->column('profile.post', '岗位')->display(function ($obj) {
            return $obj['name'];
        });

        $grid->column('name', '姓名');
        $grid->column('gender', '性别')->using([User::GENDER_MAN => '男', User::GENDER_WOMAN => '女']);
        $grid->column('mobile', '手机号1');
        $grid->column('phone', '手机号2');
        $grid->column('group_cornet', '集团短号');
        $grid->column('profile.education', '学历')->using(UserProfile::getAllEducation());
        $grid->column('profile.birthday', '生日');
        $grid->column('profile.id_number', '身份证号码');

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {

        return Form::make(User::with(['profile', 'userMajor']), function (Form $form) {
            $dao = new AreaStandDao;
            $areaDao = $dao->getAllAreaStand();
            $area = $areaDao->pluck('name', 'id');

            $postDao = new postDao;
            $postData = $postDao->getAllPost();
            $posts = [];
            foreach ($postData as $val) {
                $posts[$val->id] = $val->name;
            }

            $skill = ProfessionalSkill::all()->pluck('name', 'id');

            if ($form->isCreating()) {
                $form->column(1 / 2, function ($form) {
                    $form->text('name', '姓名')->required();
                    $form->text('profile.number', '工号')->required();
                    $form->radio('gender', '性别')->options([
                        User::GENDER_MAN => '男',
                        User::GENDER_WOMAN => '女'
                    ])->default(User::GENDER_MAN)->required();
                    $form->select('profile.education', '学历')->options(UserProfile::getAllEducation())->required();
                    $form->mobile('mobile', '手机号1')->required();
                    $form->mobile('phone', '手机号2');
                    $form->text('group_cornet', '集团短号');
                    $form->email('email', '邮箱');
                    $form->text('profile.address', '家庭住址');
                    $form->text('profile.id_number', '身份证号')->required();
                    $form->date('profile.birthday', '生日')->format('YYYY-MM-DD');
                });
                $form->column(1 / 2, function ($form) use ($area, $posts) {

                $form->select('profile.area_stand_id', '所属项目部')->options(function () use ($area) {
                    return $area;
                })->load('profile.department_id', url('/api/stand/get-departments'), 'id', 'name')->required();

                $form->select('profile.department_id', '部门')->options(function ($id) {
                    return Department::where('id', $id)->pluck('name', 'id');
                })->load('profile.group_id', url('/api/stand/get-group'), 'id', 'name')->required();

                $form->select('profile.group_id', '班组')->options(function ($id) {
                    return TaskGroup::where('id', $id)->pluck('name', 'id');
                })->required();

                $form->select('profile.post_id', '岗位')->options($posts)->load('profile.major_id', url('/api/stand/get-major'), 'id', 'name')->required();

                $form->select('profile.major_id', '专业')->options(function ($id) {
                    return Major::where('id', $id)->pluck('name', 'id');
                })->required();

                $form->date('profile.entry_time', '入职日期')->format('YYYY-MM-DD')->required();
                $form->date('profile.signing_time', '签约日期')->format('YYYY-MM-DD');
                $form->date('profile.due_time', '合同到期日期')->format('YYYY-MM-DD');
                $form->text('profile.serial', '合同编号');
                $form->textarea('profile.note', '备注')->rows(5);
            });
            }

            if ($form->isEditing()) {

                $form->tab('个人信息', function ($form) {
                    $form->model()->with(['profile', 'userMajor']);
                    $form->text('name', '姓名')->required();
                    $form->text('profile.number', '工号')->required();
                    $form->radio('gender', '性别')->options([
                        User::GENDER_MAN => '男',
                        User::GENDER_WOMAN => '女'
                    ])->default(User::GENDER_MAN)->required();
                    $form->select('profile.education', '学历')->options(UserProfile::getAllEducation())->required();
                    $form->mobile('mobile', '手机号1')->required();
                    $form->mobile('phone', '手机号2');
                    $form->text('group_cornet', '集团短号');
                    $form->email('email', '邮箱');
                    $form->text('profile.address', '家庭住址');
                    $form->text('profile.id_number', '身份证号')->required();
                    $form->date('profile.birthday', '生日')->format('YYYY-MM-DD');
                    $form->date('profile.entry_time', '入职日期')->format('YYYY-MM-DD')->required();
                    $form->date('profile.signing_time', '签约日期')->format('YYYY-MM-DD');
                    $form->date('profile.due_time', '合同到期日期')->format('YYYY-MM-DD');
                    $form->text('profile.serial', '合同编号');
                    $form->date('profile.departure_time', '离职日期')->format('YYYY-MM-DD');
                    $form->radio('profile.status', '是否在职')->options(UserProfile::whether())->default(1)->required();

                })->tab('附加信息', function ($form) {
                    $form->text('profile.pay_card', '工资卡号');
                    $form->radio('profile.certificate', '代维资格证书')->options(UserProfile::whether())->default(0);
                    $form->radio('profile.accommodation', '是否住宿')->options(UserProfile::whether())->default(0);
                    $form->text('profile.dormitory_num', '宿舍号');
                    $form->text('profile.card_num', '劳保编号');
                    $form->date('profile.card_time', '劳保办理日期')->format('YYYY-MM-DD');
                    $form->radio('profile.is_insurance', '是否缴纳意外保险')->options(UserProfile::whether())->default(0);
                    $form->text('profile.insurance_company', '保险公司');
                    $form->date('profile.insurance_time', '意外保险到期时间')->format('YYYY-MM-DD');
                    $form->radio('profile.vehicle_card', '是否有车辆行驶证')->options(UserProfile::whether())->default(0);
                    $form->date('profile.get_vehicle_card_time', '车辆行驶证初领时间')->format('YYYY-MM-DD');
                    $form->text('profile.vehicle_model', '准假车型');
                    $form->text('profile.vehicle_card_num', '驾照编号');
                    $form->date('profile.vehicle_card_audit_time', '驾照年审时间')->format('YYYY-MM-DD');
                    $form->date('profile.next_vehicle_card_audit_time', '下次驾照年审时间')->format('YYYY-MM-DD');
                })->tab('部门信息', function ($form) use ($area, $posts) {

                    $form->select('profile.area_stand_id', '所属项目部')->options(function () use ($area) {
                        return $area;
                    })->load('profile.department_id', url('/api/stand/get-departments'), 'id', 'name')->required();

                    $form->select('profile.department_id', '部门')->options(function ($id) {
                        return Department::where('id', $id)->pluck('name', 'id');
                    })->load('profile.group_id', url('/api/stand/get-group'), 'id', 'name')->required();

                    $form->select('profile.group_id', '班组')->options(function ($id) {
                        return TaskGroup::where('id', $id)->pluck('name', 'id');
                    })->required();

                    $form->select('profile.post_id', '岗位')->options($posts)->load('profile.major_id', url('/api/stand/get-major'), 'id', 'name')->required();

                    $form->select('profile.major_id', '专业')->options(function ($id) {
                        return Major::where('id', $id)->pluck('name', 'id');
                    })->required();

                    $form->textarea('profile.note', '备注')->rows(5);
                })->tab('专业技能', function ($form)use ($skill) {

                    $form->select('user_major.major_id_one', '专业技能1')->options($skill)
                        ->load('user_major.major_level_one', url('/api/stand/get-major-classes'), 'id', 'name');

                    $form->select('user_major.major_level_one', '专业技能1 级别')->options(function ($id) {
                        return ProfessionalClass::where('id', $id)->pluck('name', 'id');
                    });

                    $form->select('user_major.major_id_two', '专业技能2')->options($skill)
                        ->load('user_major.major_level_two', url('/api/stand/get-major-classes'), 'id', 'name');

                    $form->select('user_major.major_level_two', '专业技能2 级别')->options(function ($id) {
                        return ProfessionalClass::where('id', $id)->pluck('name', 'id');
                    });

                    $form->select('user_major.major_id_three', '专业技能3')->options($skill)
                        ->load('user_major.major_level_three', url('/api/stand/get-major-classes'), 'id', 'name');

                    $form->select('user_major.major_level_three', '专业技能3 级别')->options(function ($id) {
                        return ProfessionalClass::where('id', $id)->pluck('name', 'id');
                    });

                    $form->select('user_major.skill', '职业技能鉴定名称')->options([]);
                    $form->select('user_major.skill_type', '职业技能鉴定类别')->options([]);
                    $form->select('user_major.skill_level', '职业技能鉴定级别')->options([]);
                    $form->text('user_major.skill_num', '职业技能鉴定编号');
                    $form->date('user_major.skill_time', '职业技能鉴定时间')->format('YYYY-MM-DD');
                });
            }
        });
    }


}
