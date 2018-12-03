<?php
namespace app\index\controller;
use app\index\model\QuestionOption;
use think\Request;

class IndexQuestionOption
{

    public function add(Request $req)
    {
        $option_name = $req->post('option_name');
        $question_id = $req->post('question_id');
        $correct = $req->post('correct');
        $option_score = $req->post('option_score');
        $option_type = $req->post('option_type');
        $option_img_path = $req->post('option_img_path');
        $questionOption = new QuestionOption;
        $questionOption->option_name = $option_name;
        $questionOption->question_id = $question_id;
        $questionOption->correct = $correct;
        $questionOption->option_score = $option_score;
        $questionOption->option_type = $option_type;
        $questionOption->option_img_path = $option_img_path;
        $result = $questionOption->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $questionOption,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '选项添加失败，请重试'
            ];
        }
        return json_encode($return);
    }

    public function update(Request $req)
    {
        $id = $req->post('id');
        $option_name = $req->post('option_name');
        $question_id = $req->post('question_id');
        $correct = $req->post('correct');
        $option_score = $req->post('option_score');
        $option_type = $req->post('option_type');
        $option_img_path = $req->post('option_img_path');
        $questionOption = Question::get($id);
        if ($questionOption) {
            $questionOption->option_name = $option_name;
            $questionOption->question_id = $question_id;
            $questionOption->correct = $correct;
            $questionOption->option_score = $option_score;
            $questionOption->option_type = $option_type;
            $questionOption->option_img_path = $option_img_path;
            $result = $questionOption->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $question
                ];
            } else {
                $return = [
                    'code' => 1,
                    'msg' => '题目修改失败，请重试'
                ];
            }
        } else {
            $return = [
                'code' => 1,
                'msg' => '选项不存在'
            ];
        }
        return json_encode($return);
    }

    public function getByQuestionId(Request $req)
    {
        $question_id = $req->get('question_id');
        $where[] = ['question_id', '=', $question_id];
        $list = QuestionOption::where($where)->select();  
        $return = [
            'code' => 0,
            'data' => $list,
            'msg' => ''
        ];
        return json_encode($return);
    }

    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = QuestionOption::destroy($id);
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
}