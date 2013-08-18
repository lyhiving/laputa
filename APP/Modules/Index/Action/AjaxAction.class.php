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
 * Action [ FavPost => 1, LikeUser => 2, CollVideo => 3 ]
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
            $where = array('object' => $vid ,'target' => $cid ,'type' => 3);
            $Action = M('action')->where($where)->find();
            if ($Action[id]){
                M('action')->where($where)->delete();
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
            $data = array('userid' => $uid ,'object' => $vid ,'target' => $cid ,'type' => 3 ,'createdTime' => time() );
            $result = M('action')->add($data);
            if ($result){
                M('collection')->where(array('id' => $cid))->setInc('count');
                M('collection')->where(array('id' => $cid))->setField('UpdateTime',time());
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
        $where = array('object' => $vid ,'type' => 3 );
        $Actions = M('action')->where($where)->select();
        foreach ($Actions as $a) {$vids[] = $a[target];};
        $vids = join(",",$vids);
        return $vids ;
    }




    // 关注用户
    public function LikeUser($myuid, $uid) {

    }

    // 上传封面图片区域

    //上传头像
    public function uploadImg(){
        import('ORG.Net.UploadFile');
        $upload = new UploadFile();                                  // 实例化上传类
        $upload->maxSize = 2*1024*1024;                 //设置上传图片的大小
        $upload->allowExts = array('jpg','png','gif');             //设置上传图片的后缀
        $upload->uploadReplace = true;                 //同名则替换
        $upload->saveRule = 'uniqid';                     //设置上传头像命名规则(临时图片),修改了UploadFile上传类
        $upload->thumbRemoveOrigin = true;             //生成缩略图后是否删除原图
        $upload->autoSub = false;                      //是否使用子目录保存上传文件

        //完整的头像路径
        $path = './upload/temp/';
        $upload->savePath = $path;

        if(!$upload->upload()) {                        // 上传错误提示错误信息
            $this->ajaxReturn('',$upload->getErrorMsg(),0,'json');
        }else{                                          // 上传成功 获取上传文件信息
            $info =  $upload->getUploadFileInfo();
            $picName = $info[0]['savename'];
            $temp_size = getimagesize($path.$picName);
            if($temp_size[0] < 420 || $temp_size[1] < 320){//判断宽和高是否符合头像要求
                @unlink($path.$picName);//删除临时文件
                $this->ajaxReturn(0,'图片尺寸过小！',0,'json');
            }
            $this->ajaxReturn('/upload/temp/'.$picName,$info,1,'json');
        }
    }
    //裁剪并保存用户头像
    public function cropImg(){
        //图片裁剪数据
        $params = $this->_post();                       //裁剪参数
        if(!isset($params) && empty($params)){
            return;
        }

        //目录地址
        $nowtime = date( "Y").'/'.date( "m").'/';
        $path = './upload/thumb/'.$nowtime;

        if(!is_dir($path)) {
            mkdir($path,0777,true);
        }

        //要保存的图片
        $newName = md5(time());
        $real_path = $path.$newName.'.jpg';
        //临时图片地址
        $pic_path = '.'.$params['src'];
        import('ORG.Util.Image.ThinkImage');
        $Think_img = new ThinkImage(THINKIMAGE_GD);
        //裁剪原图
        $Think_img->open($pic_path)->crop($params['w'],$params['h'],$params['x'],$params['y'])->save($real_path);
        //生成缩略图
        $Think_img->open($real_path)->thumb(420,320, 1)->save($path.$newName.'_420.jpg');
        @unlink($pic_path);//删除临时文件

        $oldthumb = M('video')->where(array('id' => $params['id']))->getField('customImageName');
        if ($oldthumb) {self::deleteImg($params['id']);}


        $result = M('video')->where(array('id' => $params['id']))->setField('customImageName',$nowtime.$newName);

        if ($result) {
            $data['pic'] = $nowtime.$newName.'_420.jpg';
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        };
        $this->ajaxReturn($data, 'json');

    }

    public function unsetImg(){
        $vid = I('vid');
        $data = self::deleteImg($vid);
        $this->ajaxReturn($data, 'json');
    }

    private function deleteImg($vid) {

        $oldthumb = M('video')->where(array('id' => $vid))->getField('customImageName');
        $thumbname = M('video')->where(array('id' => $vid))->getField('imageUrl');
        $result = M('video')->where(array('id' => $vid))->setField('customImageName',"");
        @unlink('./upload/thumb/'.$oldthumb.'_420.jpg');//删除原文件
        @unlink('./upload/thumb/'.$oldthumb.'.jpg');//删除临时文件

        if ($result) {
            $data['pic'] = $thumbname;
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        };

        return $data;
    }






}
?>