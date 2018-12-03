<?php
namespace app\index\controller;
use app\index\model\User;
use app\index\model\AdminUser;
use think\Request;

class IndexUser
{
    public function adminLogin(Request $req)
    {
        $name = $req->post('username');
        $password = md5($req->post('password'));
        $user_one = AdminUser::get(['name' => $name, 'password' => $password]);
            if ($user_one) {
                $user_one->token = '111';
                $return = [
                    'code' => 0,
                    'data' => $user_one
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '登录失败，请重新输入'
                ];
            }
        return json_encode($return);
    }

    public function login(Request $req)
    {
        $phone = $req->post('phone');
        $password = md5($req->post('password'));
        $user_one = User::get(['phone' => $phone, 'password' => $password]);
            if ($user_one) {
                $user_one->token = '999';
                $return = [
                    'code' => 0,
                    'data' => $user_one
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '登录失败，请重新输入'
                ];
            }
        return json_encode($return);
    }

    public function userList(Request $req)
    {
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = User::count();
        $list = User::page($curr_page, $per_page)->select();          
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ]
        ];
        
        return json_encode($return);
    }

    public function add(Request $req)
    {
        $phone = $req->post('phone');
        $child_name = $req->post('child_name');
        $child_sex = $req->post('child_sex');
        $child_both = $req->post('child_both');
        $child_both_place = $req->post('child_both_place');
        $child_rank = $req->post('child_rank');
        $child_gestational_age = $req->post('child_gestational_age');
        $child_both_type = $req->post('child_both_type');
        $child_both_weight = $req->post('child_both_weight');
        $child_both_score = $req->post('child_both_score');
        $child_eat_type = $req->post('child_eat_type');
        $home_type = $req->post('home_type');
        $child_five_year = $req->post('child_five_year');
        $scores = $req->post('scores');
        $password = $req->post('password');
        
        $user = User::get(['phone' => $phone]);
        if ($user) {
            $return = [
                'code' => 1,
                'msg' => '手机号已存在'
            ];
            $user = null;
        } else {
            $user = new User;
            $user->phone = $phone;
            $user->child_name = $child_name;
            $user->child_sex = $child_sex;
            $user->child_both = $child_both;
            $user->child_both_place = $child_both_place;
            $user->child_rank = $child_rank;
            $user->child_gestational_age = $child_gestational_age;
            $user->child_both_type = $child_both_type;
            $user->child_both_weight = $child_both_weight;
            $user->child_both_score = $child_both_score;
            $user->child_eat_type = $child_eat_type;
            $user->home_type = $home_type;
            $user->child_five_year = $child_five_year;
            $user->scores = $scores;
            $user->password = md5($password);
            $result = $user->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $user
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '操作失败'
                ];
            }
        }
        return json_encode($return);
    }

    public function update(Request $req)
    {
        $id = $req->post('id');
        $phone = $req->post('phone');
        $child_name = $req->post('child_name');
        $child_sex = $req->post('child_sex');
        $child_both = $req->post('child_both');
        $child_both_place = $req->post('child_both_place');
        $child_rank = $req->post('child_rank');
        $child_gestational_age = $req->post('child_gestational_age');
        $child_both_type = $req->post('child_both_type');
        $child_both_weight = $req->post('child_both_weight');
        $child_both_score = $req->post('child_both_score');
        $child_eat_type = $req->post('child_eat_type');
        $home_type = $req->post('home_type');
        $child_five_year = $req->post('child_five_year');
        $scores = $req->post('scores');
        $password = $req->post('password');
        $user = User::get($id);
        if ($user) {
            $user->phone = $phone;
            $user->child_name = $child_name;
            $user->child_sex = $child_sex;
            $user->child_both = $child_both;
            $user->child_both_place = $child_both_place;
            $user->child_rank = $child_rank;
            $user->child_gestational_age = $child_gestational_age;
            $user->child_both_type = $child_both_type;
            $user->child_both_weight = $child_both_weight;
            $user->child_both_score = $child_both_score;
            $user->child_eat_type = $child_eat_type;
            $user->home_type = $home_type;
            $user->child_five_year = $child_five_year;
            $user->scores = $scores;
            $user->password = md5($password);
            $result = $user->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $user
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '操作失败'
                ];
            }
        } else {
            $return = [
                'code' => 1,
                'msg' => '用户不存在'
            ];  
        }
        return json_encode($return);
    }
    public function exportUserData(){
        $list = User::select();
        $title = [
            ['text' => '手机号码','key' => 'phone'],
            ['text' => '小孩名称','key' => 'child_name'],
            ['text' => '小孩性别','key' => 'child_sex'],
            ['text' => '小孩生日','key' => 'child_both'],
            ['text' => '出生地','key' => 'child_both_place'],
            ['text' => '排行','key' => 'child_rank'],
            ['text' => '胎龄','key' => 'child_gestational_age'],
            ['text' => '出生方式','key' => 'child_both_type'],
            ['text' => '出生体重','key' => 'child_both_weight'],
            ['text' => '出生分数','key' => 'child_both_score'],
            ['text' => '半岁内喂养','key' => 'child_eat_type'],
            ['text' => '家庭类型','key' => 'home_type'],
            ['text' => '5岁前抚养','key' => 'child_five_year']
        ];
        $name = "所有用户数据";
        // var_dump($list->toArray());
        create_excel($title, $list->toArray(), $name);
    }
}