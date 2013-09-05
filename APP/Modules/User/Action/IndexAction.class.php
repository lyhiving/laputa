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
        $visitor = CommonAction::$user;
        if ($visitor){
             $this->redirect('/user/'.$visitor[id].'/follow/');
        } else {
             $this->redirect('/');
        }
    }

    // 编辑用户
    public function setting() {

        $visitor = CommonAction::$user;
        if (!$visitor) $this->redirect('/');

        import('Class.Weibo', APP_PATH);
		define( "WB_CALLBACK_URL" , 'http://aimozhen.com/User/Weibo/avatar/' );
		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );
		$this->code_url = $code_url = $o->getAuthorizeURL( WB_CALLBACK_URL );

        $this->page_name = "setting";
        $this->page_cat = "user";

        //用户控制

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