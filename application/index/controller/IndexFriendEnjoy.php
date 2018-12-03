<?php
namespace app\index\controller;
use app\index\model\FriendEnjoy;
use think\Request;

class IndexFriendEnjoy
{
    public function add(Request $req)
    {
        $type = $req->post('type');
        $msg_id = $req->post('msg_id');
        $nick_name = $req->post('nick_name');
        $user_id = $req->post('user_id');
        $content_title = $req->post('content_title');
        $content = $req->post('content');
        $friendEnjoy = new FriendEnjoy;
        $friendEnjoy->type = $type;
        $friendEnjoy->nick_name = $nick_name;
        $friendEnjoy->msg_id = $msg_id;
        $friendEnjoy->content = $content;
        $friendEnjoy->content_title = $content_title;
        $friendEnjoy->user_id = $user_id;
        $result = $friendEnjoy->save();
        if ($result) {
            $return = [
                'code' => 0,
                'data' => $friendEnjoy,
                'msg' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'data' => '',
                'msg' => '操作失败，请重试'
            ];
        }
        return json_encode($return);
    }

    public function getFriendEnjoyList(Request $req)
    {
        $type = $req->get('type');
        $msg_id = $req->get('msg_id');
        $where = [];
        if ($type) {
            $where[] = ['type', '=', $type];
        }
        if ($msg_id) {
            $where[] = ['msg_id', '=', $msg_id];
        }
        $list = FriendEnjoy::where($where)->select();          
        $return = [
            'code' => 0,
            'data' => $list
        ];
        
        return json_encode($return);
    }

    public function delete(Request $req)
    {
        $id = $req->post('id');
        $result = FriendEnjoy::destroy($id);
        if ($result) {
            $return = [
                'code' => 0,
                'data' => ''
            ];
        } else {
            $return = [
                'code' => 1,
                'msg' => '取消失败，请重试'
            ]; 
        }
        return json_encode($return);
    }
}