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

        if (!self::$user || self::$user->id != session('uid')) {

            if (isset($_SESSION['uid'])) {
                $temp_user = M('User')->select(session('uid'));
                self::$user = $temp_user[0];
            } elseif (cookieget('__u')) {

                $temp_user = M('User')->select(intval(cookieget('__u')));

                if (sha1($temp_user[0][id] . '3xtc' . $temp_user[0][password]) == cookieget('__c')) {

                    self::$user = $temp_user[0];

                    }

            }
        }
    }

}
?>