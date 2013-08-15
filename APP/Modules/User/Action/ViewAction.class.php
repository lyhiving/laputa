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

    /**
     * Action 筛选作品列表
     * @param string $where   Action的排除属性
     * @param string $order   Action的顺序属性
     * @param string $field   Action的输出表属性
     * @param string $page_size   页面容量
     * @param string $count   输入筛选总计
     * @param string $page_link   页面基本链接
     */
    public function ListActionVideo($where, $order, $field, $page_size, $count, $page_link) {

        $this->post_count = $count;
        // 先设置小页面获取值
        $jspage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        // 再设置传给数据库的标准值 $page
        if (isset($_GET['jspage'])) { $page = $_GET['jspage']; } else { $page = ($jspage-1)*3+1 ;}

        import('Class.Page', APP_PATH);
        $page_nav = new SubPages($page_size,($count/3),$jspage,10, $page_link."/p/",2);
        $this->page_nav = $page_nav->subPageCss2() ;
        $this->page_link = $page_link;

        //判断页面是否到尽头
        $next_page = $page + 1;
        if (ceil($count/$page_size) > ($page)) {
            $this->page_next = "<a href='$page_link/jspage/$next_page/'>下一页</a> ";
        }

        //列出相关数组
        $Actions = M('action')->field($field)->order($order)->where($where)->page($page.','.$page_size)->select();
        foreach ($Actions as $a) {$Action[] = $a[target];};
        $Action = join(",",$Action);
        $vfield = "url,pre_tag,tags,collection,verify,card,score,play_url";
        $vwhere[id] = array('in',$Action);
        $post = M()->table(C('DB_PREFIX')."video")->where($vwhere)->field($vfield,true)
                ->query('select %FIELD% from %TABLE% %WHERE% order by field(id,'.$Action.')',true);
        $this->post = postreplace($post);
    }

}
?>