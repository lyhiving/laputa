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
        $where = array('target' => $cid ,'type' => 1);
        $order = "createdTime DESC";
        $field = "object";

        self::ListActionmultiVideo($where, $order, $field, $page_size, $count, $page_link);
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

    /**
     * Action 筛选作品列表
     * @param string $where   Action的排除属性
     * @param string $order   Action的顺序属性
     * @param string $field   Action的输出表属性
     * @param string $page_size   页面容量
     * @param string $count   输入筛选总计
     * @param string $page_link   页面基本链接
     */
    public function ListActionmultiVideo($where, $order, $field, $page_size, $count, $page_link) {

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
        $Actions = M('actionmulti')->field($field)->order($order)->where($where)->page($page.','.$page_size)->select();
        foreach ($Actions as $a) {$Action[] = $a[object];};
        $Action = join(",",$Action);
        $vfield = "url,pre_tag,tags,collection,verify,card,score,play_url";
        $vwhere[id] = array('in',$Action);
        $post = M()->table(C('DB_PREFIX')."video")->where($vwhere)->field($vfield,true)
                ->query('select %FIELD% from %TABLE% %WHERE% order by field(id,'.$Action.')',true);
        $this->post = postreplace($post);
    }

}
?>