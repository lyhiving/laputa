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
 * 后台控制中心首页
 */
class IndexAction extends CommonAction {


    public function index() {
    	$this->redirect('/admin/message');
    }

    // 站内信页面
    public function message() {

        if (CommonAction::$user['group']!=1) $this->redirect('/');

        $this->display();
    }



}
?>