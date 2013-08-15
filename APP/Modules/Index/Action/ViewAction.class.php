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
            if ($video['description']) { $video['description'] = trim(mb_substr($video['description'] ,0, 50,"UTF-8"));
             } else { $video['description'] = "作品之美 胜于言表"; } ;
            $video[content] = self::content($video[url]);
            $video[tagname] = videogettag($video[pre_tag]);
            $userfield = "username,verify,extraemail,extraweibo,extrablog,weiboId,post,follow,like";
            $user = M('user')->field($userfield)->find($video[userid]);
            $user[avatar] = getavatar($user);
            $this->user = $user;
            $this->video = $video;
            M('video')->where(array('id' => $vid))->setInc('viewed');
            if($video[verify]){
            	$this->page_cat = "creator";
            } else {
            	$this->page_cat = "share";
            };
            $this->display();
        }

    }




    //获取视频嵌入代码
    private function content($url) {
        //引入处理与提取类
        import('Class.VideoUrlParser', APP_PATH);
        import('Class.Video', APP_PATH);
        $Video = new Video($url);
        //验证客户端
        if(strpos($_SERVER["HTTP_USER_AGENT"],"iPad")) {
            $content = $Video->padcontent();
        } else if(strpos($_SERVER["HTTP_USER_AGENT"],"iPhone"))  {
            $content = $Video->phonecontent();
        } else  {
            $content = $Video->content();
            };
        return $content;

    }
}
?>