<?php
// +----------------------------------------------------------------------
// | AIMOZHEN [ SHARE VIDES SHARE LIFES ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://aimozhen.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Gavin Foo <fuxiaopang@msn.com>
// +----------------------------------------------------------------------


/*
 * 用户控制中心 AJAX动作控制器
 * 主要作为用户编辑 关注等动作
 * Action [ FavPost => 1, LikeUser => 2 ]
 */
class AjaxAction extends CommonAction {

    //用户修改
    public function edituser() {
       $visitor = CommonAction::$user;
       $uid = I('id');
       if ($visitor[id]!=$uid) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');

       if (I('type')=="basic") {
            $data = array('username' => I('username'));
            M("User")->where("id=$uid")->save($data);

       } elseif (I('type')=="password") {
            $password = md5(I('pass1'));
            $data = array('password' => $password);
            M("User")->where("id=$uid")->save($data);

       } elseif (I('type')=="extra"){

            $data = array(
                'extraemail' => I('extraemail'),
                'extraweibo' => I('extraweibo'),
                'extrablog' => I('extrablog')
                );
            M("User")->where("id=$uid")->save($data);
       }

       $this->success('修改成功','/home/setting/','1');

    }

    //逐个修改Ajax
    public function edituserfield() {
       $uid = I('pk');
       $visitor = CommonAction::$user;
       if ( $visitor[id]!=$uid ) $this->redirect('/');
       if (!IS_AJAX) _404('页面不存在...');

       $field = I('name');
       $value = I('value');
       M("User")->where("id=$uid")->setField($field,$value);

    }

    public function getmessage() {
        if(!IS_AJAX) _404('页面不存在...');

        $mid = I('mid');
        $message = M('messagetext')->where("id=$mid")->getField('message');

        if ($message) {
        	$data['message'] = nl2br($message);
            $vid = CommonAction::$user[id];
            M('message')->where(array('object'=>$mid,'target'=>$vid))->setField('status','1');
            $data['status'] = 1;
        } else {
        	$data['status'] = 0;
        }
        cookie('__m', null);
        $this->ajaxReturn($data, 'json');

    }

    public function unreadmessage() {
        if(!IS_AJAX) _404('页面不存在...');

        $mid = I('mid');
        $vid = CommonAction::$user[id];
        $result = M('message')->where(array('object'=>$mid,'target'=>$vid))->setField('status','0');
        if ($result) {
        	$data['status'] = 1;
        } else {
        	$data['status'] = 0;
        }

        cookie('__m', null);
        $this->ajaxReturn($data, 'json');

    }


}
?>