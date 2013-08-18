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
 * 用户控制中心首页
 * 主要有用户数据展示、编辑等功能
 */
class IndexAction extends CommonAction {


    // 用户分享跳转
    public function video() {
        $visitor = CommonAction::$user;
        if ($visitor){
        	 $this->redirect('/user/'.$visitor[id].'/');
        } else {
        	 $this->redirect('/');
        }
    }

    // 用户收藏跳转
    public function like() {
        $visitor = CommonAction::$user;
        if ($visitor){
             $this->redirect('/user/'.$visitor[id].'/like/');
        } else {
             $this->redirect('/');
        }
    }

    // 用户关注跳转
    public function follow() {
        $this->error('开发中');
    }

    // 编辑用户
    public function setting() {

        $this->page_name = "setting";
        $this->page_cat = "user";

        //用户控制
        $visitor = CommonAction::$user;
        if (!$visitor) $this->redirect('/');
        $this->user = $visitor;

        $this->display();
    }

    // 编辑用户
    public function message() {

        $this->page_name = "message";
        $this->page_cat = "user";

        cookie('__m', null);
        self::$user[message] = 0;
        $vid = self::$user[id];
        $where[recId] = array(in,array(0,$vid));
        $messages = M('messagetext')->order('id DESC')->field('message',true)->where($where)->select();
        $this->messages = messagereplace($messages);

        $this->display();
    }

}
?>