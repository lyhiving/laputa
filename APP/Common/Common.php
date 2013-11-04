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


/**
 * 全站通用函数
 */

// 打印函数
function p($arr) {

    echo '<pre>'. print_r($arr, true) . '<pre>';

 }

// 获取头像
function getavatar($user) {
    if ($user[weiboId]){
        import('Class.Avatar', APP_PATH);
        $link = new WeiboAvatar($user[weiboId]);
        return $link->link();

      } else {
        import('Class.Avatar', APP_PATH);
        $link = new Avatar($user[email]);
        return  $link->link();
    }
}

// 视频资料替换
function postreplace($data) {
    foreach ($data as $v) {
        if ($v['description']) { $v['description'] = trim(mb_substr($v['description'] ,0, 70,"UTF-8"));
             } else { $v['description'] = "作品之美 胜于言表"; } ;

        if (!$v['imageUrl']) { $v['imageUrl'] = "__PUBLIC__/images/noimage.jpg" ;}

        $user = M('user')->field('username,email,weiboId')->find($v['userid']);

        $v[username] = $user[username];
        $v[useravatar] = getavatar($user);
        $post[] = $v;
        }
    return $post;
}

// 视频封面替换
function videothumb($data){
    foreach ($data as $v) {
        if ($v['customImageName']) {
        	$v['imageUrl'] = "http://aimozhen.com/upload/thumb/".$v['customImageName']."_420.jpg";
         } ;

        $post[] = $v;
        }
    return $post;
}


// 用户资料替换
function userpost($data) {
    foreach ($data as $u) {

        $u[avatar] = getavatar($u);

        $days = abs(time() - $u[createdTime])/86400;   //入住天数
        $u[days] = floor($days);
        $where = array ('userid' => $u[id] ,'verify' => 1);
        $videos = M('video')->where($where)->order('id DESC')->limit(3)->field("id,title,imageUrl,customImageName")->select();
        $u[video] = $videos;
        $user[] = $u;
        }
    return $user;
}

// 选辑资料替换
function collreplace($data) {
    foreach ($data as $c) {


        $video = M('video')->field('imageUrl')->find($c['thumbid']);
        $user = M('user')->field('username')->find($c['userid']);

        $c[username] = $user[username];
        $c[thumb] = $video[imageUrl];
        $coll[] = $c;
        }
    return $coll;
}

// 用户资料替换
function userreplace($data) {
    foreach ($data as $u) {

        if (!$u[location]){ $u[location] = '尚未填写'; } ;
        if (!$u[career]){ $u[career] = '尚未填写'; } ;
        if (!$u[aboutme]){ $u[aboutme] = '欢迎访问我的主页'; } ;
        $u[avatar] = getavatar($u);
        $user[] = $u;
        }
    return $user;
}

// 获取视频Tag类名称
function videogettag($tid) {
    $tname = M('tag')->where(array('id' => $tid))->getField('name');
    return $tname;
}

// 获取全部Tag
function getalltag() {
    $tags = M('tag')->order('sort asc')->select();
    return $tags;
}

// 获取视频Collection类名称
function videogetColl($cid) {
    $cname = M('collection')->where(array('id' => $cid))->getField('name');
    return $cname;
}

// 获取全部Collection
function getallcoll() {
    $colls = M('collection')->order('UpdateTime desc')->select();
    return $colls;
}

// 收藏判断
function isfav($user, $video) {
    $where = array ('type'=>1,'userid'=>$user,'target'=>$video);
    $num = M('action')->where($where)->count();
    return $num > 0;
}

// 关注判断
function isfollow($vid, $uid) {
    $where = array ('type'=>2,'userid'=>$vid,'target'=>$uid);
    $num = M('action')->where($where)->count();
    return $num > 0;
}

// 站内信
function messagereplace($data) {
    $vid = CommonAction::$user[id];
    foreach ($data as $m) {
        $message = M('message')->where(array('object'=>$m[id],'target'=>$vid))->find();
        if ($m[recId]==0){
        	$m[fromname] = '系统邮件';
        	$m[userlink] = '#';
        } else {
        	$m[userlink] = '/user/'.$message[userid].'/';
            $m[fromname] = M('user')->where(array('id'=> $message[userid]))->getField('username');
        };
        if (!$m[title]) $m[title] = '无标题';
        $m[status] = $message[status];
        $messages[] = $m;
        }
    return $messages;
}

// 认领作品
function copyright($vid, $olduid, $newuid, $verify) {
	if (CommonAction::$user['group']!=1) $this->redirect('/');
	M('video')->where("id=$vid")->setField("userid",$newuid);

	if ($verify) {
    	M('user')->where("id=$newuid")->setInc('postOriginal');
		M('user')->where("id=$olduid")->setDec('postOriginal');
	}
	M('user')->where("id=$newuid")->setInc('post');
	M('user')->where("id=$olduid")->setDec('post');

}


?>

