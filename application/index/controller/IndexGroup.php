<?php
namespace app\index\controller;
use app\index\model\TestGroup;
use app\index\model\TestType;
use app\index\model\TestGroupTestType;
use think\Request;

class IndexGroup
{
    public function getGroupList(Request $req)
    {
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = TestGroup::count();
        $list = TestGroup::page($curr_page, $per_page)->select();          
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ],
            'msg' => ''
        ];
        
        return json_encode($return);
    }

    public function add(Request $req)
    {
        $group_name = $req->post('group_name');
        $money = $req->post('money');
        $group = new TestGroup;
        $group->group_name = $group_name;
        $group->money = $money;
        $result = $group->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $group,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '添加失败'
            ]; 
        }
        return json_encode($return);
    }
    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = TestGroup::destroy($id);
        if ($result) {
            $return = [
                'code' => 0,
                'data' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'msg' => '删除失败，请重试'
            ]; 
        }
        return json_encode($return);
    }

    public function update(Request $req)
    {
        $id = $req->post('id');
        $group_name = $req->post('group_name');
        $money = $req->post('money');

        $group = TestGroup::get($id);
        if ($group) {
            $group->group_name = $group_name;
            $group->money = $money;
            $result = $group->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $group,
                    'msg' => ''
                ];
            } else {
                $return = [
                    'code' => 1,
                    'data' => '',
                    'msg' => '修改失败'
                ]; 
            }
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '数据不存在'
            ]; 
        }
        return json_encode($return);
    }
    public function addTestType(Request $req)
    {
        $group_id = $req->post('group_id');
        $type_id = $req->post('type_id');

        $group_type = TestGroupTestType::get(['test_group_id' => $group_id, 'test_type_id' => $type_id]);
        if ($group_type) {
            $return = [
                'code' => 0,
                'data' => '已存在',
                'msg' => ''
            ];
        } else {
            $group_type = new TestGroupTestType;
            $group_type->test_group_id = $group_id;
            $group_type->test_type_id = $type_id;
            $result = $group_type->save();
            if ($result) {
                $return = [
                    'code' => 0,
                    'data' => '添加成功',
                    'msg' => ''
                ]; 
            } else {
                $return = [
                    'code' => 1,
                    'data' => '',
                    'msg' => '设置失败'
                ]; 
            }
            
        }
        return json_encode($return);
    }

    public function deleteTestType(Request $req)
    {
        $id = $req->post('id');
        $group_type_test_type = TestGroupTestType::get($id);
        if ($group_type_test_type) {
            $result = $group_type_test_type->delete();
            if ($result) {
                $return = [
                    'code' => 0,
                    'data' => '',
                    'msg' => ''
                ];
            } else {
                $return = [
                    'code' => 1,
                    'data' => '',
                    'msg' => '删除失败'
                ];
            }
            
        } else {
            $return = [
                'code' => 0,
                'data' => '本来就不存在',
                'msg' => ''
            ]; 
        }
        return json_encode($return);
    }
    public function getTestType(Request $req)
    {
        $group_id = $req->get('group_id');
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        $where = [];
        if ($group_id) {
            $where[] = ['test_group_id','=',$group_id];
        }
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = TestGroupTestType::where($where)->count();
        $list = TestGroupTestType::where($where)
                        ->page($curr_page, $per_page)
                        ->join('test_type', 'test_type.id = test_group_test_type.test_type_id')
                        ->field('test_type.test_type_name, test_group_test_type.id')
                        ->select();
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ],
            'msg' => ''
        ];
        return json_encode($return);
    }
}   