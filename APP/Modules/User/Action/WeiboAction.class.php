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
		if(isset($_GET['code'])) {

			$code = $_GET['code'];

			$ch = curl_init('https://api.weibo.com/oauth2/access_token');

			curl_setopt($ch, CURLOPT_POST, true);

			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array(

				'client_id' => C('WEIBO_ID'),

				'client_secret' => C('WEIBO_SECRET'),

				'grant_type' => 'authorization_code',

				'code' => $code,

				'redirect_uri' => 'http://aimozhen.com/User/Weibo/avatar/'



			)));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$user = json_decode(curl_exec($ch));

			if ($user->uid) {
				$visitor = CommonAction::$user;
				$data = array('id'=>$visitor[id], 'weiboId' => $user->uid, 'extraweibo' => 'http://www.weibo.com/' . $user->uid );
				M('user')->save($data);
			}

			$this->redirect("/home/setting");

		}

    }


}
?>