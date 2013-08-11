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
 * AMZ 编辑作品主控制器
 * 主要有作品编辑等方法
 */
class PostAction extends CommonAction {


    // 首页
    public function addvideo() {
       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       $url = I('url');
       $exists_video = M('video')->field('id,url')->where(array('url' => $url))->find();

       //验证是否存在
       if ($exists_video[id]){

            $this->redirect("/video/".$exists_video[id]."/");

       } else {

            //获取UID
            $userid = CommonAction::$user[id];
            //引入验证与提取类
            import('Class.VideoUrlParser', APP_PATH);
            import('Class.Video', APP_PATH);
            //再次验证地址合法性
            $Video = new Video($url);
            if ($Video->type() == -1) $this->redirect('/');
            //获取截图标题
            $info = VideoUrlParser::parse($url);
            //准备数据
            $data = array(
                'createdTime' => time(),
                'userid' => $userid,
                'pre_tag' => 1,
                'url' => $url,
                'imageUrl' => $info['img'],
                'title' => $info['title']
            );
            //存入数据
            $vid = M('video')->add($data);
            M('user')->where(array('id' => $userid))->setInc('post');
            M('tag')->where(array('id' => 1))->setInc('count');

            $this->redirect("/edit/".$vid."/");

       }

    }
}
?>