<?php
namespace app\index\controller;
use app\index\model\Question;
use app\index\model\QuestionOption;
use think\Request;

class IndexQuestion
{

    public function add(Request $req)
    {
        $question_title = $req->post('question_title');
        $question_type = $req->post('question_type');
        $voice_path = $req->post('voice_path');
        $img_path = $req->post('img_path');
        $test_id = $req->post('test_id');
        $test_type_id = $req->post('test_type_id');
        $question = new Question;
        $question->question_title = $question_title;
        $question->question_type = $question_type;
        $question->voice_path = $voice_path;
        $question->img_path = $img_path;
        $question->test_id = $test_id;
        $question->test_type_id = $test_type_id;
        $result = $question->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $question,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '题目添加失败，请重试'
            ];
        }
        return json_encode($return);
    }

    public function update(Request $req)
    {
        $id = $req->post('id');
        $question_title = $req->post('question_title');
        $question_type = $req->post('question_type');
        $voice_path = $req->post('voice_path');
        $img_path = $req->post('img_path');
        $test_id = $req->post('test_id');
        $test_type_id = $req->post('test_type_id');
        $question = Question::get($id);
        if ($question) {
            $question->question_title = $question_title;
            $question->question_type = $question_type;
            $question->voice_path = $voice_path;
            $question->img_path = $img_path;
            $question->test_id = $test_id;
            $question->test_type_id = $test_type_id;
            $result = $question->save();
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
                'msg' => '题目不存在'
            ];
        }
        return json_encode($return);
    }

    public function getList(Request $req)
    {
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        $test_id = $req->get('test_id');
        $where = [];
        if ($test_id) {
            $where[] = ['test_id', '=', $test_id];
        }
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = Question::where($where)->count();
        $list = Question::where($where)->page($curr_page, $per_page)->select();          
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ]
        ];
        
        return json_encode($return);
    }
    public function getAllOptionByTestId(Request $req)
    {
        $test_id = $req->get('test_id');
        $where[] = ['test_id', '=', $test_id];
        $list = Question::where($where)
                ->join('question_option', 'question.id = question_option.question_id')
                // ->group('question.id')
                ->field('question.*, question_option.*, question_option.id as option_id')
                ->select();
        $result = [];
        $item = null;
        for ($i=0;$i<count($list);$i++) {
            if ($item['question_id'] == $list[$i]['question_id']) {
                $item['options'][] = [
                    'option_id' => $list[$i]['option_id'],
                    'option_name' => $list[$i]['option_name'],
                    'option_type' => $list[$i]['option_type'],
                    'option_img_path' => $list[$i]['option_img_path'],
                    'option_score' => $list[$i]['option_score']
                ];
            } else {
                if ($item) {
                   $result[] = $item;
                }
                $item = [
                    'question_id' => $list[$i]['question_id'],
                    'img_path' => $list[$i]['img_path'],
                    'question_title' => $list[$i]['question_title'],
                    'question_type' => $list[$i]['question_type'],
                    'voice_path' => $list[$i]['voice_path'],
                    'options' => []
                ];
                $item['options'][] = [
                    'option_id' => $list[$i]['option_id'],
                    'option_name' => $list[$i]['option_name'],
                    'option_type' => $list[$i]['option_type'],
                    'option_img_path' => $list[$i]['option_img_path'],
                    'option_score' => $list[$i]['option_score']
                ];
            }
        }
        if ($item) {
            $result[] = $item;
        }
        $return = [
            'code' => 0,
            'data' => $result
        ];
        
        return json_encode($return);
    }

    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = Question::destroy($id);
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