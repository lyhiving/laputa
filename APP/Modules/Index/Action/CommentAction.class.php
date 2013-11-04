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
 * AMZ 评论控制器
 * 主要有多说同步数据等动作
 */
class CommentAction extends CommonAction {

    // 首页
    public function sync() {
    	import('Class.DuoShuo', APP_PATH);
        $id = DuoShuo::syncComment(1);
        DuoShuo::syncCommentNum($id);

    }
}
?>