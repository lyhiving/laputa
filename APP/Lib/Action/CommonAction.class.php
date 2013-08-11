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
 * 主程序通用控制器
 * 主要作为登陆验证控制
 */
class CommonAction extends Action{


    public static $user;
     // 自动加载方法
    public static function _initialize() {
        self::visitor();
    }

    public static function visitor() {
        if (!self::$user || self::$user->id != session('uid')) {

            if (isset($_SESSION['uid'])) {
                $temp_user = M('User')->find(session('uid'));
                self::$user = $temp_user;
                self::$user[avatar] = getavatar($temp_user);

            } elseif (self::cookieget('__u')) {

                $temp_user = M('User')->find(intval(self::cookieget('__u')));
                if (sha1($temp_user[id] . '3xtc' . $temp_user[password]) == self::cookieget('__c')) {
                    self::$user = $temp_user;
                    self::$user[avatar] = getavatar($temp_user);
                    }

            }
        }
    }


	private static function cookieget($name) {
        return isset($_COOKIE[$name]) ? trim($_COOKIE[$name]) : null;

    }

}
?>