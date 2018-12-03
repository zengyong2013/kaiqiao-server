<?php
namespace app\index\controller;
use app\index\model\Article;
use think\Request;

class IndexArticle
{
    public function add(Request $req)
    {
        $type1 = $req->post('type1');
        $type2 = $req->post('type2');
        $title = $req->post('title');
        $money = $req->post('money');
        $content = $req->post('content');
        $voice = $req->post('voice');

        $article = new Article;
        $article->type1 = $type1;
        $article->type2 = $type2;
        $article->title = $title;
        $article->money = $money;
        $article->content = $content;
        $article->voice = $voice;
        $result = $article->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $article,
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
        $type1 = $req->post('type1');
        $type2 = $req->post('type2');
        $title = $req->post('title');
        $money = $req->post('money');
        $content = $req->post('content');
        $voice = $req->post('voice');
        $article = Article::get($id);
        if ($article) {
            $article->type1 = $type1;
            $article->type2 = $type2;
            $article->title = $title;
            $article->money = $money;
            $article->content = $content;
            $article->voice = $voice;
            $result = $article->save();
            if ($result !== false) {
                $return = [
                    'code' => 0,
                    'data' => $article
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
    public function getList(Request $req)
    {
        $per_page = $req->get('per_page');
        $curr_page = $req->get('curr_page');
        // $where = [];
        if (!$per_page) {
            $per_page = 10;
        }
        if (!$curr_page) {
            $curr_page = 1;
        }
        $total = Article::count();
        $list = Article::page($curr_page, $per_page)->select();          
        $return = [
            'code' => 0,
            'data' => [
                'total' => $total,
                'data' => $list
            ]
        ];
        return json_encode($return);
    }
    public function getList2(Request $req)
    {
        $list = Article::field('id, type1, type2, title, money, voice, update_time')->select();          
        $return = [
            'code' => 0,
            'data' => $list
        ];
        return json_encode($return);
    }
    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = Article::destroy($id);
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
    public function detail(Request $req){
        $id = $req->get('id');
        $article_one = Article::get($id);
        $return = [
            'code' => 0,
            'data' => $article_one,
            'msg' => ''
        ];
        return json_encode($return);
    }
}