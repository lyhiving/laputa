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



    // 添加视频
    public function addvideo() {
       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       $url = I('url');
       $exists_video = M('video')->field('id,url')->where(array('url' => $url))->find();

       //验证是否存在
       if ($exists_video[id]){

            $this->redirect("/view/".$exists_video[id]."/");

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
            $sourceSite = $Video->sourceSite();

            //准备数据
            $data = array(
                'createdTime' => time(),
                'userid' => $userid,
                'pre_tag' => 1,
                'url' => $url,
                'imageUrl' => $info['img'],
				'description' => $info['description'],
				'tags' => $info['tags'],
                'title' => $info['title'],
                'playId' => $info['playId'],
                'videoSite' => $sourceSite
            );
            //存入数据
            $vid = M('video')->add($data);

            if ($vid) {
	            M('user')->where(array('id' => $userid))->setInc('post');
	            M('tag')->where(array('id' => 1))->setInc('count');
	            $this->redirect("/edit/".$vid."/");
            } else {
            	$this->error('添加失败，换个网址再试试吧:-D'.'/');
            }


       }

    }

    //编辑视频页面生成
    public function editvideo() {

       if (!CommonAction::$user) $this->redirect('/');
       $visitor = CommonAction::$user;

       $vid = I('id');
       $exists_video = M('video')->find($vid);

       //验证是否存在视频
       if ($exists_video[id]){
           $video = $exists_video;
           //验证有用户权限
           if ( ($visitor[id] == $video[userid])||($visitor[group] == 1) ){
               $user = M('user')->field('username,email,weiboId')->find($video['userid']);
               $user[avatar] = getavatar($user);
               $this->user = $user;
               $this->video = $video;
               $this->display();
           } else {
                $this->error('您没有权限','/');
           }

       } else {
           $this->error('该视频已被删除了','/');
       }

    }


    //编辑视频页面生成
    public function editvideopost() {

       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       $visitor = CommonAction::$user;

       $vid = I('id');
       $exists_video = M('video')->find($vid);

       //验证是否存在视频
       if ($exists_video[id]){

           $video = $exists_video;
           //验证有用户权限
           if ( ($visitor[id] == $video[userid])||($visitor[group] == 1) ){

                if ($video[pre_tag]) {
                    $old_tag = M('tag')->find($video[pre_tag]);
                    if ($old_tag[count] > 0)  {
                        if ($video[verify]){
                            M('tag')->where(array('id' => $video[pre_tag]))->setDec('countOriginal');
                        } else {
                        	M('tag')->where(array('id' => $video[pre_tag]))->setDec('count');
                        }
                    }
                }
                if (I('verify')){
                    M('tag')->where(array('id' => I('pre_tag') ))->setInc('countOriginal');
                    M('user')->where(array('id' => $video[userid] ))->setField('lastPost',$video['id']);
                } else {
                    M('tag')->where(array('id' => I('pre_tag') ))->setInc('count');
                }

				$time = I('createdTime');
				$time = substr($time,0,4).'-'.substr($time,9,2).'-'.substr($time,16,2);

               $data = array (
               'title' => I('title'),
               'pre_tag' => I('pre_tag'),
               'tags' => I('tags'),
               'description' => I('description'),
			   'createdTime' => strtotime($time)
               );


                if ( I('userid') && (I('userid')!=$video[userid]) ) {
                    copyright($vid, $video[userid], I('userid'), $video[verify]);
                };

                if (I('viewed')) { $data[viewed] = I('viewed'); };

                if (I('url')) {
                    import('Class.VideoUrlParser', APP_PATH);
                    $data[url] = I('url');
                    $info = VideoUrlParser::parse(I('url'));
                    $data[imageUrl] = $info['img'];
                    import('Class.Video', APP_PATH);
                    $Video = new Video(I('url'));
                    $data[videoSite] = $Video->sourceSite();
                };

                if (I('userid')) { $userid = I('userid'); } else { $userid = $visitor[id]; }
				if (I('verify')) {
                    $data[verify] = 1;
                    if (!$video[verify]) {
                    	M('user')->where(array('id' => $userid ))->setInc('postOriginal');
                        }
                } else {
                    $data[verify] = 0;
                    if ($video[verify]) {
                        M('user')->where(array('id' => $userid ))->setDec('postOriginal');
                        }
                };

                M('video')->where(array('id' => $video[id]))->save($data);

                $this->redirect("/view/".$video[id]."/");


           } else {
                $this->error('您没有权限','/');
           }

       } else {
           $this->error('该视频已被删除了','/');
       }

    }


    public function deletevideo() {
       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_GET) _404('页面不存在...');
       $visitor = CommonAction::$user;

       $vid = I('id');
       $video = M('video')->find($vid);

       //验证有用户权限
       if ( ($visitor[id] == $video[userid])||($visitor[group] == 1) ){

            if (M('video')->delete($vid)) {
                $this->success("该视频已经被删除~","/");
            } else {
                $this->error('没有修改或修改发生问题',"/view/".$video[id]."/");
            }

       } else {
            $this->error('您没有权限','/');
       }
    }




}
?>