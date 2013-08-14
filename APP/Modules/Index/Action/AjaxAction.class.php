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
 * AMZ AJAX动作控制器
 * 主要作为用户关注、收藏、添加选集等动作
 * Action [ FavPost => 1, LikeUser => 2 ]
 */
class AjaxAction extends CommonAction {


    // 收藏视频
    public function FavPost($vid=0) {
        if (!CommonAction::$user) $this->redirect('/');
        if(!IS_AJAX) _404('页面不存在...');
        $uid = CommonAction::$user['id'] ;
        $vid = I('vid');
        if (I('faved')){
        	//取消收藏
            $where = array('userid' => $uid, 'type' => '1', 'target' => $vid );
            $Action = M('action')->where($where)->find();
            if ($Action[id]){
            	M('action')->where($where)->delete();
                M('video')->where(array('id' => $vid))->setDec('like');
                M('user')->where(array('id' => $uid))->setDec('fav');
                $data['content'] = '取消收藏';
                $data['status'] = 1;
            }
        } else {
        	//收藏
            $data = array('userid' => $uid, 'type' => '1', 'target' => $vid, 'createdTime' => time() );
            $result = M('action')->add($data);
            if ($result){
                M('video')->where(array('id' => $vid))->setInc('like');
                M('user')->where(array('id' => $uid))->setInc('fav');
                $data['content'] = '收藏';
                $data['status'] = 1;
            } else {
            	$data['status'] = 0;
            }
        };
        $this->ajaxReturn($data, 'json');

    }

    // 将视频添加至选辑
    public function CollPost($cid, $vid, $uid) {

    }

    // 关注用户
    public function LikeUser($myuid, $uid) {

    }
}
?>