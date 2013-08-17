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
 * 后台控制中心 AJAX动作控制器
 * Action [ FavPost => 1, LikeUser => 2 ]
 */
class AjaxAction extends CommonAction {



    public function addmessage() {

        if (!I('title')) $this->error('没有标题');
        if (!I('message')) $this->error('没有内容');
        $visitorId = CommonAction::$user['id'] ;
        $data = array(
            'title' => I('title'),
            'message' => I('message'),
            'recId' => 0,
            'creatTime' => time()
            );
        $mid = M('messagetext')->add($data);
    	if ( $mid ) {

             $uids = M('user')->getField('id',true);

             foreach ( $uids as $uid ) {
                $data = array('userid' => $visitorId ,'object' => $mid ,'target' => $uid ,'createdTime' => time() );
                M('message')->add($data);
             };

             $this->success('发送成功');
    	} else {
    		$this->error('发送失败');
    	}
    }





}
?>