<?php
namespace app\index\controller;
use app\index\model\Friend;
use think\Request;

class IndexFriend
{
    public function add(Request $req)
    {
        $type = $req->post('type');
        $nick_name = $req->post('nick_name');
        $head_img = $req->post('head_img');
        $content = $req->post('content');
        $imgs = $req->post('imgs');
        $user_id = $req->post('user_id');
        $friend = new Friend;
        $friend->type = $type;
        $friend->nick_name = $nick_name;
        $friend->head_img = $head_img;
        $friend->content = $content;
        $friend->imgs = $imgs;
        $friend->user_id = $user_id;
        $result = $friend->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $friend,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '发布失败，请重试'
            ];
        }
        return json_encode($return);
    }

    public function getFriendList(Request $req)
    {
        $type = $req->get('type');
        $user_id = $req->get('user_id');
        $where = [];
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($user_id) {
            $where[] = ['user_id', '=', $user_id];
        }
        $list = Friend::where($where)->select();          
        $return = [
            'code' => 0,
            'data' => $list
        ];
        
        return json_encode($return);
    }

    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = Friend::destroy($id);
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