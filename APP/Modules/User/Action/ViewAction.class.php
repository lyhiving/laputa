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
        $page_size = 24;
        $this->page_name = "user";

        $this->page_cat = "creator";
        $this->page_link = $page_link = '/user/'.$uid;
        $where = array("userid" => $uid);

        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');
    }

    public function fav() {

        $uid = I('id');
        $page_size = 24;
        $this->page_link = $page_link = '/user/'.$uid;

        $count = M("user")->where(array('id' => $uid))->getField('fav');
        $where = array('userid' => I('id'));
        $order = "createdTime DESC";
        $field = "target,createdTime";

        self::ListVideo($where, $order, $field, $page_size, $count, $page_link);
        $this->display('index');
    }

    // 视频筛选通用方法
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
        $vfield = "url,pre_tag,tags,collection,verify,card,score,play_url";
        $Actions = M('action')->field($field)->order($order)->where($where)->page($page.','.$page_size)->select();
        foreach ($Actions as $a) {
            $Action[] = $a[target];
            $post[] = M('video')->where("id=".$a[target])->field($vfield, true)->order()->find();
            };

        //$vwhere[id] = array('in',$Action);
        //$post = M('video')->where($vwhere)->field($vfield, true)->order()->select();

        $this->post = postreplace($post);

    }

}
?>