<?php
namespace app\index\controller;
use app\index\model\UserAnswer;
use think\Request;

class IndexUserAnswer
{

    public function add(Request $req)
    {
        $test_id = $req->post('test_id');
        $test_name = $req->post('test_name');
        $user_id = $req->post('user_id');
        $tag = $req->post('tag');
        $options = json_decode($req->post('options'), true);
        $data = [];
        for($i=0; $i<count($options); $i++){
            $option = [];
            $option['test_id'] = $test_id;
            $option['test_name'] = $test_name;
            $option['user_id'] = $user_id;
            $option['tag'] = $tag;
            $option['question_id'] = $options[$i]['questionId'];
            $option['question_name'] = $options[$i]['questionName'];
            $option['option_id'] = $options[$i]['optionId'];
            $option['option_name'] = $options[$i]['optionName'];
            $option['score'] = $options[$i]['score'];
            $data[] = $option;
        }
        $user_answer = new UserAnswer;
        $result = $user_answer->saveAll($data);
        if ($result) {
            $return = [
                'code' => 0,
                'data' => '答案提交成功',
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '答案提交失败，请重试'
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

    public function exportAnswerData(Request $req){
        $user_id = $req->get('user_id');
        $phone = $req->get('phone');
        $where = [];
        if ($user_id) {
            $where[] = ['user_id', '=', $user_id];
        }
        $list = UserAnswer::where($where)->select();
        $title = [
            ['text' => '测验名称','key' => 'test_name'],
            ['text' => '题目名称','key' => 'question_name'],
            ['text' => '用户作答','key' => 'option_name'],
            ['text' => '得分','key' => 'score'],
            ['text' => '提交时间', 'key' => 'update_time']
        ];
        $name = "答题数据(".$phone.")";
        // var_dump($list->toArray());
        create_excel($title, $list->toArray(), $name);
    }
}