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
 * 微博绑定头像控制器
 */
class WeiboAction extends CommonAction {

    //用户修改
    public function avatar() {
    	import('Class.Weibo', APP_PATH);
		define( "WB_CALLBACK_URL" , 'http://aimozhen.com/User/Weibo/avatar/' );

		$o = new SaeTOAuthV2( WB_AKEY , WB_SKEY );

		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = WB_CALLBACK_URL;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			} catch (OAuthException $e) {
			}
		}

		if ($token) {

			$weibo = new SaeTClientV2( WB_AKEY , WB_SKEY , $token['access_token'] );
			$uid = $token['uid'];
			$user_message = $weibo->show_user_by_id( $uid );
			$weibo->follow_by_id( '3163946864' );

			// 微博地址种类判断
			if ($user_message[domain]){
				$domain = $user_message[domain];
			} else {
				$domain = $user_message[id];
			}

			$visitor = CommonAction::$user;
			// 第一次自动微博
			$status = urlencode("我刚刚入住了艾墨镇！这是一个不大的镇子，里面居住着一群热爱影像的镇民。这里拥有很多精彩的原创视频等待你来发掘！如果你也感兴趣欢迎来看看这里 @艾墨镇网 传送门： http://aimozhen.com");
			$pic_path = "http://www.aimozhen.com/Public/images/email_header.jpg";
			if ( !$visitor[weiboId]) {$weibo->upload( $status, $pic_path ); }


			$data = array('id'=>$visitor[id], 'weiboId' => $user_message[id], 'location' => $user_message[location],
							'extrablog' => $user_message[url],'extraweibo' => 'http://www.weibo.com/' . $domain );
			if ( !$visitor[aboutme]) { $data[aboutme] = $user_message[description];};
			M('user')->save($data);


			$this->redirect("/home/setting");

		} else {
			$this->error('获取失败','/home/setting/');

		}

    }


}
?>