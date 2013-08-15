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
        self::listnew();
    }

    public function listnew() {

        $page_size = 24;
        $this->page_name = "listnew";

        if ( !I('creator') ) {
            $this->page_cat = "share";
            $this->page_link = $page_link = '/share';
            $where = array("verify" => 0);
        } else {
            $this->page_cat = "creator";
            $this->page_link = $page_link = '/creator';
            $where = array("verify" => 1);
        }
        $order = "id DESC";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');

    }

    // 最热视频
    public function hot() {

        $page_size = 24;
        $this->page_name = "hot";
        $type = I('id');

        if ( !I('creator') ) {
            $this->page_cat = "share";
            $this->page_link = $page_link = '/share/hot/'.$type;
            $where = array("verify" => 0);
        } else {
            $this->page_cat = "creator";
            $this->page_link = $page_link = '/creator/hot/'.$type;
            $where = array("verify" => 1);
        };

        if ( $type == 'view' ) {
            $order = "`viewed` desc, id desc";
        } elseif ( $type == 'comment' ) {
            $order = "`comment` desc, id desc";
        } elseif ( $type == 'fav' ) {
            $order = "`like` desc, id desc";
        };

        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');

    }

    // 视频分类
    public function tag() {

       $page_size = 24;
        $this->page_name = "tag";
        $id = I('id');

        if ( !I('creator') ) {
            $this->page_cat = "share";
            $this->page_link = $page_link = '/share/tag/'.$id;
            $where = array("verify" => 0,"pre_tag" => $id);
        } else {
            $this->page_cat = "creator";
            $this->page_link = $page_link = '/creator/tag/'.$id;
            $where = array("verify" => 1,"pre_tag" => $id);
        };

        $order = "id DESC";
        $field = "url,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        $this->display('index');

    }


    // 随机视频
    public function Discover() {
        $page_size = 24;
        $this->page_name = "discover";

        $this->page_cat = "share";
        $this->page_link = $page_link = '/share/discover';
        $where = array("verify" => 0);

        $order = "RAND( )";
        $field = "url,pre_tag,tags,collection,verify,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link, 1);
        $this->display('index');

    }

    // 用户列表
    public function author() {
        $this->error('开发中');

    }

}
?>