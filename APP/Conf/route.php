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
 * ! 顺序很重要 ！
 */

return array (

    'URL_ROUTER_ON'   => true, //开启路由
    'URL_ROUTE_RULES' => array( //定义路由规则
        'video/:id\d'    => 'Index/View/index',
        'edit/:id\d'    => 'Index/Post/editvideo',

        //视频列表正则控制
        '/share\/(tag|hot)\/([A-Za-z0-9]+)/'    => array('Index/Index/:1?id=:2', 'creator=0'),
        '/creator\/(tag|hot)\/([A-Za-z0-9]+)/'    => array('Index/Index/:1?id=:2', 'creator=1'),
        'share/discover'    => array('Index/Index/discover', 'creator=0'),
        'creator/author'    => array('Index/Index/author', 'creator=1'),
        'share'    => array('Index/Index/listnew', 'creator=0'),
        'creator'    => array('Index/Index/listnew', 'creator=1'),
        'search'    => array('Index/Search/index'),

        //选辑列表正则控制
        'collection/:id\d'    => 'Index/Index/collection',
        'collection'    => 'Index/Collection/index',

        //用户列表
        'user/:id\d'    => 'USer/View/index',
)

);

?>
