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
        if ($v['description']) { $v['description'] = trim(mb_substr($v['description'] ,0, 50,"UTF-8"));
             } else { $v['description'] = "作品之美 胜于言表"; } ;

        if (!$v['imageUrl']) { $v['imageUrl'] = "__PUBLIC__/images/noimage.jpg" ;}

        $user = M('user')->field('username,email,weiboId')->find($v['userid']);

        $v[username] = $user[username];
        $v[useravatar] = getavatar($user);
        $post[] = $v;
        }
    return $post;
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
    $colls = M('collection')->where('id>1')->order('UpdateTime desc')->select();
    return $colls;
}

// 收藏判断
function isfav($user, $video) {
    $where = array ('type'=>1,'userid'=>$user,'target'=>$video);
    $num = M('action')->where($where)->count();
    return $num > 0;
}


?>

