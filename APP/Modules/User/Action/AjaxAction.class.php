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
 * 用户控制中心 AJAX动作控制器
 * 主要作为用户编辑 关注等动作
 * Action [ FavPost => 1, LikeUser => 2 ]
 */
class AjaxAction extends CommonAction {

    //用户修改
    public function edituser() {
       $visitor = CommonAction::$user;
       $uid = I('id');
       if ($visitor[id]!=$uid) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');

       if  (I('type')=="password") {
            $password = md5(I('pass1'));
            $data = array('password' => $password);
            M("User")->where("id=$uid")->save($data);

       }
		// 通知多说 同步用户
        import('Class.DuoShuo', APP_PATH);
        DuoShuo::syncUser($uid);
		$this->success('修改成功','/home/setting/','1');

    }

    //逐个修改Ajax
    public function edituserfield() {
       $uid = I('pk');
       $visitor = CommonAction::$user;
       if ( $visitor[id]!=$uid ) $this->redirect('/');
       if (!IS_AJAX) _404('页面不存在...');

       $field = I('name');
       $value = I('value');
       if ($field == 'shortname'){
	        $newid = M('user')->where(array('shortname' => $value))->getField('id');
			if ($newid) {
				$data['status'] = 'error';
				$data['msg'] = '用户名存在';
			} else {
				M("user")->where("id=$uid")->setField('shortname',$value);
				$data['status'] = 'success';
			}
	        $this->ajaxReturn($data, 'json');
       } else {
       		M("user")->where("id=$uid")->setField($field,$value);
       }


		// 通知多说 同步用户
		import('Class.DuoShuo', APP_PATH);
		DuoShuo::syncUser($uid);

    }


    /**
     * 关注用户
     */
    public function followuser() {
        if (!CommonAction::$user) $this->redirect('/');
        if(!IS_AJAX) _404('页面不存在...');
        $vid = CommonAction::$user['id'] ;
        $uid = I('uid');
        if (I('faved')){
        	//取消收藏
            $where = array('userid' => $vid, 'type' => '2', 'target' => $uid );
            $Action = M('action')->where($where)->find();
            if (M('action')->where($where)->delete()){
                M('user')->where(array('id' => $vid))->setDec('follow');
                $data['content'] = '取消关注';
                $data['status'] = 1;
            }
        } else {
        	//收藏
            $data = array('userid' => $vid, 'type' => '2', 'target' => $uid, 'createdTime' => time() );
            $result = M('action')->add($data);
            if ($result){
                M('user')->where(array('id' => $vid))->setInc('follow');
                $data['content'] = '关注';
                $data['status'] = 1;
            } else {
            	$data['status'] = 0;
            }
        };
        $this->ajaxReturn($data, 'json');

    }

    /**
     * 关注用户
     */
    public function featureVideo() {
        if (!CommonAction::$user) $this->redirect('/');
        if(!IS_AJAX) _404('页面不存在...');
        $uid = I('uid');
        $vid = I('vid');

        $result = M('user')->where("id=$uid")->setField('featureId',$vid);

		if ($result) {
			$data['status'] = 'success';
		} else {
			$data['status'] = 'error';
		}
        $this->ajaxReturn($data, 'json');

    }


/**
 * 发送私信
 */
	public function sendMessage() {
		$message = I('message');
		if(!$message) $this->error('请输入内容');
        if (!CommonAction::$user) $this->redirect('/');
        if(!IS_POST) _404('页面不存在...');
        $visitor = CommonAction::$user;
        $uid = I('uid');

		$data = array(
            'title' => $visitor[username].' 发来的私信',
            'message' => $message.'<br/> <a href="/'.$visitor[shortname].'/" target="_blank">点此回复Ta</a>',
            'recId' => $uid,
            'creatTime' => time()
            );
        $mid = M('messagetext')->add($data);
    	if ( $mid ) {
	        $data = array('userid' => $visitor[id] ,'object' => $mid ,'target' => $uid ,'createdTime' => time() );
	        M('message')->add($data);
	        $this->success('发送成功');
    	} else {
    		$this->error('发送失败');
    	}
	}

    public function getmessage() {
        if(!IS_AJAX) _404('页面不存在...');

        $mid = I('mid');
        $message = M('messagetext')->where("id=$mid")->getField('message');

        if ($message) {
        	$data['message'] = nl2br($message);
            $vid = CommonAction::$user[id];
            M('message')->where(array('object'=>$mid,'target'=>$vid))->setField('status','1');
            $data['status'] = 1;
        } else {
        	$data['status'] = 0;
        }
        cookie('__m', null);
        $this->ajaxReturn($data, 'json');

    }

    public function unreadmessage() {
        if(!IS_AJAX) _404('页面不存在...');

        $mid = I('mid');
        $vid = CommonAction::$user[id];
        $result = M('message')->where(array('object'=>$mid,'target'=>$vid))->setField('status','0');
        if ($result) {
        	$data['status'] = 1;
        } else {
        	$data['status'] = 0;
        }

        cookie('__m', null);
        $this->ajaxReturn($data, 'json');

    }


}
?>