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
    'APP_GROUP_LIST' => 'Index,User,Admin,Api',
    'DEFAULT_GROUP' =>'Index',
    'APP_GROUP_MODE' => 1,
    'APP_GROUP_PATH' => 'Modules',
    'URL_HTML_SUFFIX' => '',

    //数据库连接参数
    'DB_HOST' => 'localhost',
    'DB_USER' => 'DB_USER',
    'DB_PWD' => '',
    'DB_NAME' => 'DB_NAME',
    'DB_PREFIX' => 'DB_PREFIX_',

    //Mail账户设置
    'MAIL_ADDRESS'=>'name@example.com', // 邮箱地址
	'MAIL_SMTP'=>'smtp.example.com', // 邮箱SMTP服务器
	'MAIL_LOGINNAME'=>'name@example.com', // 邮箱登录帐号
	'MAIL_PASSWORD'=>'password', // 邮箱密码
	'MAIL_CHARSET'=>'UTF-8',//编码
	'MAIL_AUTH'=>true,//邮箱认证
	'MAIL_HTML'=>true,//true HTML格式 false TXT格式

	// 多说账户信息
	'DUOSHUO_USER' => 'DUOSHUO_USER',
	'DUOSHUO_SECRET' => 'DUOSHUO_SECRET',

	// 新浪微博账户信息
	'WEIBO_ID' => 'WEIBO_ID',
	'WEIBO_SECRET' => 'WEIBO_SECRET',

    //地址设置
    'URL_MODEL' => 2,
    'URL_CASE_INSENSITIVE' => TRUE,

    //Cookie设置
    'COOKIE_EXPIRE'         => 604800,          // Coodie有效期7天
    'COOKIE_DOMAIN'         => 'example.com',  // Cookie有效域名
    'COOKIE_PATH'           => '/',             // Cookie路径
    'COOKIE_PREFIX'         => '',          // Cookie前缀 避免冲突

    //URL路由
    'LOAD_EXT_CONFIG' => 'route',

    'SHOW_PAGE_TRACE' => true ,
	//'TMPL_EXCEPTION_FILE'=>'./App/Tpl/404.html' ,


);
?>