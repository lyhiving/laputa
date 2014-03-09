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
 * AMZ 观看作品主控制器
 * 主要有作品页面生成，观看次数叠加等方法
 */
class ViewAction extends CommonAction {

    // 作品详情观看页面生成
    public function Index() {

        $vid = I('id');
        $video = M('video')->find($vid);
        if (!$video[id]) {
        	$this->error('该视频已经被删除');
        } else {
            //赋值视频、用户、标签数据
            if (!$video['description']) { $video['description'] = "作品之美 胜于言表"; } ;
            $video[content] = self::content($video[url],$video[playId]);
            $video[tagname] = videogettag($video[pre_tag]);
            $userfield = "username,shortname,verify,extraemail,extraweibo,extrablog,weiboId,post,follow,likecount";
            $user = M('user')->field($userfield)->find($video[userid]);
            $user[avatar] = getavatar($user);
            $this->user = $user;
            $this->video = $video;

            // 增加用户数量以及作品浏览量
            $visitor = CommonAction::$user;
            if($video['userid']!=$visitor['id']) {
	            M('user')->where(array('id' => $visitor['id']))->setInc('myViewed');
	            M('video')->where(array('id' => $vid))->setInc('viewed');
            }


            // 前一个
            if ( $pre_video = M('video')->where("id<$vid")->order('id DESC')->field('id,title')->find() ) {
            	$this->pre_video = $pre_video;
            }
            // 后一个
            if ( $ord_video = M('video')->where("id>$vid")->order('id ASC')->field('id,title')->find() ) {
            	$this->ord_video = $ord_video;
            }

            if($video[verify]){
            	$this->page_cat = "creator";
            } else {
            	$this->page_cat = "share";
            };
            $this->page_name = "view";
            $this->display();
        }

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
}
?>