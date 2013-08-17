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
 * AMZ 选辑功能主控制器
 * 主要有选辑页面以及列表页面生成等方法
 */
class CollectionAction extends CommonAction {

    // 首页
    public function Index() {

        $page_size = 24;
        $this->page_name = "collection";

        $this->page_cat = "collection";
        $this->page_link = $page_link = '/collection';
        $where = "id > 1";

        $order = "`UpdateTime` desc, id desc";
        $field = "";

        self::ListColl($where, $order, $field, $page_size, $page_link);
        //p($this->coll);die;
        $this->display('index');

    }

    //选辑列表
    public function view() {

        $cid = I('id');
        //页面控制
        $page_size = 24;
        $this->page_name = videogetColl($cid);
        $this->page_cat = "collection";
        $this->page_link = $page_link = '/collection/'.$cid;

        //作品控制
        $count = M('collection')->where(array('id' => $cid))->getField('count');
        $where = array('target' => $cid ,'type' => 3);
        $order = "createdTime DESC";
        $field = "object";

        self::ListActionVideo($where, $order, $field, $page_size, $count, $page_link, 'object');
        $this->display('list');

    }


    // 选辑封面筛选
    public function ListColl($where, $order, $field, $page_size, $page_link, $nav = 0) {
        $colls = M('collection');
        $count = $colls->where($where)->count();// 查询满足要求的总记录数
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

        $coll = $colls->order($order)->where($where)->field($field, true)->page($page.','.$page_size)->select();
        $this->coll = collreplace($coll);

    }



}
?>