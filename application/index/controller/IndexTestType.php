<?php
namespace app\index\controller;
use app\index\model\TestType;
use app\index\model\TestGroupTestType;
use think\Request;

class IndexTestType
{
    
    public function getTestTypeListByBigType(Request $req)
    {
        $big_type = $req->get('big_type');    
        $where = [];
        if ($big_type) {
            $where[] = ['big_type', '=', $big_type];
        }  
        $list = TestType::where($where)->select();   
        $return = [
            'code' => 0,
            'data' => $list
        ];
        
        return json_encode($return);
    }

    public function getTestTypeListByGroup(Request $req)
    {
        $group_id = $req->get('group_id');    
        $where = [];
        if ($group_id) {
            $where[] = ['test_group_test_type.test_group_id', '=', $group_id];
        }  
        $list = TestGroupTestType::where($where)
                        ->join('test_type', 'test_group_test_type.test_type_id = test_type.id')
                        ->field('test_type.*')
                        ->select();  
        $return = [
            'code' => 0,
            'data' => $list
        ];
        
        return json_encode($return);
    }
}