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
 * 程序URL路由控制
 */

return array (

    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
        'video/:id\d'    => 'Index/View/index',
        'edit/:id\d'    => 'Index/Post/editvideo',
        'share'    => array('Index/Index/listnew', 'creator=0'),
        'creator'    => array('Index/Index/listnew', 'creator=1'),
        'search'    => array('Index/Search/index')
)

);

?>
