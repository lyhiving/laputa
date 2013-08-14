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
 * AMZ 搜索作品控制器
 * 主要有作品筛选等方法
 */
class SearchAction extends CommonAction {

    //搜索类型判断
    public function index() {
    	if (I('type') == title) {
            self::title();
    	}

    }

    // 搜索视频标题
    public function title() {

        $search = I('q');

        $page_size = 48;
        $this->page_name = "search";
        $this->page_link = $page_link = '/search/';
        $where = "`title` LIKE  '%".trim($search)."%'";

        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index/index');


    }
}
?>