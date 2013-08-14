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
 * 主程序通用控制器
 * 主要作为登陆验证控制
 */
class CommonAction extends Action{


    public static $user;
     // 自动加载方法
    public static function _initialize() {
        self::visitor();
    }

    public static function visitor() {
        if (!self::$user || self::$user->id != session('uid')) {

            if (isset($_SESSION['uid'])) {
                $temp_user = M('User')->find(session('uid'));
                self::$user = $temp_user;
                self::$user[avatar] = getavatar($temp_user);

            } elseif (self::cookieget('__u')) {

                $temp_user = M('User')->find(intval(self::cookieget('__u')));
                if (sha1($temp_user[id] . '3xtc' . $temp_user[password]) == self::cookieget('__c')) {
                    self::$user = $temp_user;
                    self::$user[avatar] = getavatar($temp_user);
                    }

            }
        }
    }


	private static function cookieget($name) {
        return isset($_COOKIE[$name]) ? trim($_COOKIE[$name]) : null;

    }



    // 视频筛选通用方法
    public function ListVideo($where, $order, $field, $page_size, $page_link, $nav = 0) {
        $posts = M('video');
        $count = $posts->where($where)->count();// 查询满足要求的总记录数
        $this->post_count = $count;

        // 先设置小页面获取值
        $jspage = isset($_GET['p']) ? intval($_GET['p']) : 1;
        // 再设置传给数据库的标准值 $page
        if (isset($_GET['jspage'])) { $page = $_GET['jspage']; } else { $page = ($jspage-1)*3+1 ;}

        if (!$nav) {
            import('Class.Page', APP_PATH);
            $page_nav = new SubPages($page_size,($count/3),$jspage,10, $page_link."/p/",2);
            $this->page_nav = $page_nav->subPageCss2() ;
        } else {
            $this->page_nav = "<a href=".$page_link."/>再换一批</a> </div>";
        };

        $this->page_link = $page_link;
        //判断页面是否到尽头
        $next_page = $page + 1;
        if (ceil($count/$page_size) > ($page)) {
            $this->page_next = "<a href='$page_link/jspage/$next_page/'>下一页</a> ";
        }

        $post = $posts->order($order)->where($where)->field($field, true)->page($page.','.$page_size)->select();
        $this->post = postreplace($post);

    }


}
?>