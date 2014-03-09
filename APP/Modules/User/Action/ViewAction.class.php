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
 * 用户作品展示首页
 * 主要有用户数据展示、编辑等功能
 */
class ViewAction extends CommonAction {


    // 用户首页
    public function index() {

        $shortname = I('shortname');
        if( $shortname ) {
        	$uid = M('user')->where(array('shortname' => $shortname))->getField('id');
        	if(!$uid) { $this->error('用户不存在','/'); }
        }
        // 页面控制
        $page_size = 24;
        $this->page_name = "postOriginal";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/'.$shortname;

        // 作品控制
        $where = array("userid" => $uid,"verify" =>"1");
        $order = "createdTime DESC";
        $field = "url,pre_tag,tags,collection,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        if ($this->post_count == 0) $this->redirect("/$shortname/share/");
        if (CommonAction::$user[id]!=$uid ) M('user')->where(array('id' => $uid))->setInc('viewed');

        // 用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        // 主打作推荐
        $field = "id,title,description,url,videoSite,createdTime,playId";
		if ($user[0]['featureId']){
			$featureVideo = M('video')->find($user[0]['featureId']);
		} else {
			$featureVideo = M('video')->where(array("userid" => $uid,"verify" =>"1"))->field($field)->order('viewed DESC')->find();
		}
		$featureVideo['content'] = self::content($featureVideo['url'],$featureVideo['playId']);
		$this->featureVideo = $featureVideo;


        $this->display('index');
    }


    //获取视频嵌入代码
    private function content($url,$playId) {
        //引入处理与提取类
        import('Class.VideoUrlParser', APP_PATH);
        import('Class.Video', APP_PATH);
        $Video = new Video($url,$playId);
        $content = $Video->content();

        //验证客户端

        $devices = array("iPad", "iPhone", "iPod", "android");
        foreach ($devices as $device) {
			$result = stripos($_SERVER["HTTP_USER_AGENT"],$device);
			if ($result) break;
        }

        if($result) {
            return $content['mobile'];
        } else  {
            return $content['pc'];
        };

    }


    public function share() {

        $shortname = I('shortname');
        if( $shortname ) {
        	$uid = M('user')->where(array('shortname' => $shortname))->getField('id');
        	if(!$uid) { $this->error('用户不存在','/'); }
        }
        //页面控制
        $page_size = 24;
        $this->page_name = "share";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/'.$shortname.'/share';

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $where = array("userid" => $uid,"verify" =>"0");
        $order = "createdTime DESC";
        $field = "url,pre_tag,tags,collection,card,score,play_url";

        self::ListVideo($where, $order, $field, $page_size, $page_link);
        if (CommonAction::$user[id]!=$uid ) M('user')->where(array('id' => $uid))->setInc('viewed');
        $this->display('index');
    }

    public function like() {

        $shortname = I('shortname');
        if( $shortname ) {
        	$uid = M('user')->where(array('shortname' => $shortname))->getField('id');
        	if(!$uid) { $this->error('用户不存在','/'); }
        }
        //页面控制
        $page_size = 24;
        $this->page_name = "like";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/'.$shortname.'/like';

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $count = $user[0][likecount];
        $where = array('userid' => $uid, 'type' => 1);
        $order = "createdTime DESC";
        $field = "target,createdTime";

        self::ListActionVideo($where, $order, $field, $page_size, $count, $page_link);
        $this->display('index');
    }

    public function follow() {

        $shortname = I('shortname');
        if( $shortname ) {
        	$uid = M('user')->where(array('shortname' => $shortname))->getField('id');
        	if(!$uid) { $this->error('用户不存在','/'); }
        }
        //页面控制
        $page_size = 24;
        $this->page_name = "follow";
        $this->page_type = "users";
        $this->page_cat = "user";
        $this->page_link = $page_link = '/'.$shortname.'/follow';

        //用户控制
        $user = M('user')->where(array("id" => $uid))->select();
        $user = userreplace($user);
        $this->user = $user[0];

        //作品控制
        $count = $user[0][follow];
        $where = array('userid' => $uid, 'type' => 2);
        $order = "createdTime DESC";
        $field = "target,createdTime";

        self::ListActionUser($where, $order, $field, $page_size, $count, $page_link);


        $this->display('index');
    }
}
?>