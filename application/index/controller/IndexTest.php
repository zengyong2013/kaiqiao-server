<?php
namespace app\index\controller;
use app\index\model\Test;
use think\Request;

class IndexTest
{
    public function detail(Request $req){
        $test_id = $req->get('test_id');
        $test_one = Test::get($test_id);
        $return = [
            'code' => 0,
            'data' => $test_one,
            'msg' => ''
        ];
        return json_encode($return);
    }
    public function add(Request $req)
    {
        $test_name = $req->post('test_name');
        $tips = $req->post('tips');
        $home_img = $req->post('home_img');
        $per_time = $req->post('per_time');
        $total_time = $req->post('total_time');
        $money = $req->post('money');
        $test_type_id = $req->post('test_type_id');
        $min_age = $req->post('min_age');
        $max_age = $req->post('max_age');
        $test = new Test;
        $test->test_name = $test_name;
        $test->tips = $tips;
        $test->home_img = $home_img;
        $test->per_time = $per_time;
        $test->total_time = $total_time;
        $test->money = $money;
        $test->test_type_id = $test_type_id;
        $test->min_age = $min_age;
        $test->max_age = $max_age;
        $result = $test->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $test,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '添加失败，请重试'
            ];
        }
        return json_encode($return);
    }

    public function update(Request $req)
    {
        $id = $req->post('id');
        $test_name = $req->post('test_name');
        $tips = $req->post('tips');
        $home_img = $req->post('home_img');
        $per_time = $req->post('per_time');
        $total_time = $req->post('total_time');
        $money = $req->post('money');
        $test_type_id = $req->post('test_type_id');
        $min_age = $req->post('min_age');
        $max_age = $req->post('max_age');
        $test = Test::get($id);
        if ($test) {
            $test->test_name = $test_name;
            $test->tips = $tips;
            $test->home_img = $home_img;
            $test->per_time = $per_time;
            $test->total_time = $total_time;
            $test->money = $money;
            $test->test_type_id = $test_type_id;
            $test->min_age = $min_age;
            $test->max_age = $max_age;
            $result = $test->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $test
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '修改失败，请重试'
                ];
            }
        } else {
            $return = [
                'code' => 1,
                'msg' => '数据不存在'
            ];
        }
        return json_encode($return);
    }
    public function getTestList(Request $req)
    {
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        $test_type_id = $req->get('test_type_id');
        $where = [];
        if ($test_type_id) {
            $where[] = ['test_type_id', '=', $test_type_id];
        }
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = Test::where($where)->count();
        $list = Test::where($where)->page($curr_page, $per_page)->select();          
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ]
        ];
        
        return json_encode($return);
    }
}