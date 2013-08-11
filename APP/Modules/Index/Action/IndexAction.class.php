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
 * AMZ前台首页
 * 主要作为作品列表控制器
 */
class IndexAction extends CommonAction {

    // 网站首页 最新视频
    public function Index() {
        $this->redirect('Index/index/now');
    }

    public function now() {

        $page_size = 24;
        $page_link = '/index/index/now';
        $where = "";
        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');


    }

    // 最热视频
    public function hot() {

        $page_size = 24;
        $page_link = '/index/index/hot';
        $where = "";
        $order = "viewed DESC,id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');

    }

    // 认证视频
    public function Verify() {
        echo 111;
    }

    // 随机视频
    public function Discover() {
        echo 111;
    }

    // 视频筛选通用方法
    public function ListVideo($where, $order, $field, $page_size, $page_link) {
        $posts = M('video');
        $count = $posts->where($where)->count();// 查询满足要求的总记录数
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
        if (ceil($count/$page_size)> $page) {
        	$this->page_next = "<a href='$page_link/jspage/$next_page/'>下一页</a> ";
        }

        $post = $posts->order($order)->where($where)->field($field, true)->page($page.','.$page_size)->select();
        $this->post = postreplace($post);

    }

}
?>