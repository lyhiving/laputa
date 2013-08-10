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
// 视频资料替换
function postreplace($data) {
    foreach ($data as $v) {
        if ($v['description']) { $v['description'] = trim(mb_substr($v['description'] ,0, 50,"UTF-8"));
             } else { $v['description'] = "作品之美 胜于言表"; } ;

        if (!$v['imageUrl']) { $v['imageUrl'] = "__PUBLIC__/images/noimage.jpg" ;}

        $user = M('user')->field('username,email,weiboId')->select($v['userid']);

        $v[username] = $user[0][username];
        $v[useravatar] = getavatar($user[0]);
        $post[] = $v;
        }
    return $post;
}

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

?>

