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
 * 程序通用控制器
 * 主要作为登陆验证控制
 */
class CommonAction extends Action{


    public static $user;
     // 自动加载方法
    public static function _initialize() {
        self::visitor();
        if(self::$user){
            self::$user[avatar] = getavatar(self::$user);
            self::getmessage();
        }
    }

    public static function visitor() {
        if (!self::$user || self::$user->id != session('uid')) {

            if (isset($_SESSION['uid'])) {
                $temp_user = M('User')->find(session('uid'));
                self::$user = $temp_user;
            } elseif (self::cookieget('__u')) {
                $temp_user = M('User')->find(intval(self::cookieget('__u')));
                if (sha1($temp_user[id] . '3stc' . $temp_user[password]) == self::cookieget('__c')) {
                    self::$user = $temp_user;
                    }
            }
        }
    }


	private static function cookieget($name) {
        return isset($_COOKIE[$name]) ? trim($_COOKIE[$name]) : null;

    }

    private function getmessage() {
        if (!self::cookieget('__m')) {
            $vid = self::$user[id];
            $mids = M('message')->where(array('target'=>$vid, 'status'=>0))->count();
            cookie('__m',$mids);
        }
        self::$user[message] = self::cookieget('__m');
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


    /**
     * Action 筛选作品列表
     * @param string $where   Action的排除属性
     * @param string $order   Action的顺序属性
     * @param string $field   Action的输出表属性
     * @param string $page_size   页面容量
     * @param string $count   输入筛选总计
     * @param string $page_link   页面基本链接
     */
    public function ListActionVideo($where, $order, $field, $page_size, $count, $page_link, $target='target') {

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
        foreach ($Actions as $a) {$Action[] = $a[$target];};
        $Action = join(",",$Action);
        $vfield = "url,pre_tag,tags,collection,verify,card,score,play_url";
        $vwhere[id] = array('in',$Action);
        $post = M()->table(C('DB_PREFIX')."video")->where($vwhere)->field($vfield,true)
                ->query('select %FIELD% from %TABLE% %WHERE% order by field(id,'.$Action.')',true);
        $this->post = postreplace($post);
    }



    // 用户筛选通用方法
    public function ListUser($where, $order, $field, $page_size, $page_link) {
        $users = M('user');
        $count = $users->where($where)->count();// 查询满足要求的总记录数
        $this->post_count = $count;

        // 先设置小页面获取值
        $page = isset($_GET['p']) ? intval($_GET['p']) : 1;

        import('Class.Page', APP_PATH);
        $page_nav = new SubPages($page_size,$count,$page,10, $page_link."/p/",2);
        $this->page_nav = $page_nav->subPageCss2() ;
        $this->page_link = $page_link;


        $user = $users->order($order)->where($where)->field($field, true)->page($page.','.$page_size)->select();
        $this->user = userpost($user);

    }

    /**
     * Action 筛选用户列表
     * @param string $where   Action的排除属性
     * @param string $order   Action的顺序属性
     * @param string $field   Action的输出表属性
     * @param string $page_size   页面容量
     * @param string $count   输入筛选总计
     * @param string $page_link   页面基本链接
     */
    public function ListActionUser($where, $order, $field, $page_size, $count, $page_link, $target='target') {

        $this->post_count = $count;
        // 先设置小页面获取值
        $page = isset($_GET['p']) ? intval($_GET['p']) : 1;

        import('Class.Page', APP_PATH);
        $page_nav = new SubPages($page_size,$count,$page,10, $page_link."/p/",2);
        $this->page_nav = $page_nav->subPageCss2() ;
        $this->page_link = $page_link;


        //列出相关数组
        $Actions = M('action')->field($field)->order($order)->where($where)->page($page.','.$page_size)->select();
        foreach ($Actions as $a) {$Action[] = $a[$target];};
        $Action = join(",",$Action);
        $ufield = "password";
        $uwhere[id] = array('in',$Action);
        $user = M()->table(C('DB_PREFIX')."user")->where($uwhere)->field($ufield,true)
                ->query('select %FIELD% from %TABLE% %WHERE% order by field(id,'.$Action.')',true);
        $this->users = userpost($user);
    }


}
?>