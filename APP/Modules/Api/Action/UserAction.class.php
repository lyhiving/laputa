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
 * 网站API接口
 * 用户部分控制器
 */
class UserAction extends Action {

	public function creator() {
		if ( I('limit') ) { $limit = $_GET['limit']; } else { $limit = 10; };
		$field = "id,username,shortname,createdTime,email,weiboId,postOriginal";
		$users = M('user')->order('lastPost desc')->where("verify>0 and postOriginal>0")->field($field)->limit($limit)->select();

		self::output($users);

	}



	private function output($users) {

		foreach($users as $user) {
			$days = abs(time() - $user[createdTime])/86400;
			$user[days] = floor($days);
			$user[avatar] = getavatar($user);
			$output[data][] = $user;

		};
		echo json_encode($output);

	}

}

?>