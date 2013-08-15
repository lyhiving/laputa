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
 * ActionMulti [ CollPost => 1 ]
 */
class AjaxAction extends CommonAction {


    // 收藏视频
    public function FavPost() {
        if (!CommonAction::$user) $this->redirect('/');
        if(!IS_AJAX) _404('页面不存在...');
        $uid = CommonAction::$user['id'] ;
        $vid = I('vid');
        if (I('faved')){
        	//取消收藏
            $where = array('userid' => $uid, 'type' => '1', 'target' => $vid );
            $Action = M('action')->where($where)->find();
            if (M('action')->where($where)->delete()){
                M('video')->where(array('id' => $vid))->setDec('likecount');
                M('user')->where(array('id' => $uid))->setDec('likecount');
                $data['content'] = '取消收藏';
                $data['status'] = 1;
            }
        } else {
        	//收藏
            $data = array('userid' => $uid, 'type' => '1', 'target' => $vid, 'createdTime' => time() );
            $result = M('action')->add($data);
            if ($result){
                M('video')->where(array('id' => $vid))->setInc('likecount');
                M('user')->where(array('id' => $uid))->setInc('likecount');
                $data['content'] = '收藏';
                $data['status'] = 1;
            } else {
            	$data['status'] = 0;
            }
        };
        $this->ajaxReturn($data, 'json');

    }

    // 将视频添加至选辑
    public function CollPost() {
        if (!CommonAction::$user) $this->redirect('/');
        //if(!IS_AJAX) _404('页面不存在...');
        $uid = CommonAction::$user['id'] ;
        $vid = I('vid');
        $cid = I('cid');

        if (I('colled')){
            //取消选辑
            $where = array('object' => $vid ,'target' => $cid ,'type' => 1);
            $Action = M('actionmulti')->where($where)->find();
            if ($Action[id]){
                M('actionmulti')->where($where)->delete();
                M('collection')->where(array('id' => $cid))->setDec('count');
                $value = self::ListCollsId($vid);
                M("video")->where("id=$vid")->setField('collection',$value);
                $ctitle = M('collection')->where(array('id' => $cid))->getField('name');
                $data['title'] = $ctitle;
                $data['content'] = '取消选辑';
                $data['status'] = 1;
            }
        } else {
            //添加选辑
            $data = array('userid' => $uid ,'object' => $vid ,'target' => $cid ,'type' => 1 ,'createdTime' => time() );
            $result = M('actionmulti')->add($data);
            if ($result){
                M('collection')->where(array('id' => $cid))->setInc('count');
                $value = self::ListCollsId($vid);
                M("video")->where("id=$vid")->setField('collection',$value);
                $ctitle = M('collection')->where(array('id' => $cid))->getField('name');
                $data['title'] = $ctitle;
                $data['content'] = '添加选辑';
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
        };
        $this->ajaxReturn($data, 'json');

    }


    public function ListCollsId($vid) {
        $where = array('object' => $vid ,'type' => 1 );
        $Actions = M('actionmulti')->where($where)->select();
        foreach ($Actions as $a) {$vids[] = $a[target];};
        $vids = join(",",$vids);
        return $vids ;
    }




    // 关注用户
    public function LikeUser($myuid, $uid) {

    }
}
?>