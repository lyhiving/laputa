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

function cookieget($name) {

    return isset($_COOKIE[$name]) ? trim($_COOKIE[$name]) : null;

}

?>

