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
 * 程序参数总控
 */

return array (
    //开启分组模式
    'APP_GROUP_LIST' => 'Index,User',
    'DEFAULT_GROUP' =>'Index',
    'APP_GROUP_MODE' => 1,
    'APP_GROUP_PATH' => 'Modules',
    'URL_HTML_SUFFIX' => '',

    //数据库连接参数
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PWD' => '',
    'DB_NAME' => 'newaimozhen',
    'DB_PREFIX' => 'amz_',

    //地址设置
    'URL_MODEL' => 2,
    'URL_CASE_INSENSITIVE' => TRUE,

    //Cookie设置
    'COOKIE_EXPIRE'         => 604800,          // Coodie有效期7天
    //'COOKIE_DOMAIN'         => 'aimozhen.com',  // Cookie有效域名
    'COOKIE_PATH'           => '/',             // Cookie路径
    'COOKIE_PREFIX'         => '',          // Cookie前缀 避免冲突



    'SHOW_PAGE_TRACE' =>true



    //'LOAD_EXT_CONFIG' => 'verify'
);
?>