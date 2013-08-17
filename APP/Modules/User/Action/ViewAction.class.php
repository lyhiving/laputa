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
 * 用户作品展示首页
 * 主要有用户数据展示、编辑等功能
 */
class ViewAction extends CommonAction {


    // 用户首页
    public function index() {

        $uid = I('id');
        //页面控制
        $page_size = 24;
        $this->page_name = "postOriginal";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/user/'.$uid;

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $where = array("userid" => $uid,"verify" =>"1");
        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        if ($this->post_count == 0) $this->redirect("/user/$uid/share/");
        if (CommonAction::$user[id]!=$uid ) M('user')->where(array('id' => $uid))->setInc('viewed');
        $this->display('index');
    }

    public function share() {

        $uid = I('id');
        //页面控制
        $page_size = 24;
        $this->page_name = "share";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/user/'.$uid.'/share/';

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $where = array("userid" => $uid,"verify" =>"0");
        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        //if ($this->post_count == 0) $this->redirect("/user/$uid/share/");
        if (CommonAction::$user[id]!=$uid ) M('user')->where(array('id' => $uid))->setInc('viewed');
        $this->display('index');
    }

    public function like() {

        $uid = I('id');
        //页面控制
        $page_size = 24;
        $this->page_name = "like";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/user/'.$uid.'/like/';

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $count = $user[0][likecount];
        $where = array('userid' => $uid, 'type' => 1);
        $order = "createdTime DESC";
        $field = "target,createdTime";

        self::ListActionVideo($where, $order, $field, $page_size, $count, $page_link);
        $this->display('index');
    }


}
?>