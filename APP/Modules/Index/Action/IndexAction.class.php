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

        $this->display();
    }

    // 最热视频
    public function Hot() {
        echo 111;
    }

    // 认证视频
    public function Verify() {
        echo 111;
    }

    // 随机视频
    public function Discover() {
        echo 111;
    }
}
?>