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
 * 视频部分控制器
 */
class VideoAction extends CommonAction {

	public function newlist() {
		if ( I('limit') ) { $limit = $_GET['limit']; } else { $limit = 10; };
		$videos = M('video')->order('id desc')->limit($limit)->select();

		self::output($videos);

	}

	public function hot() {
		if ( I('limit') ) { $limit = $_GET['limit']; } else { $limit = 10; };
		$videos = M('video')->order('viewed desc, id desc')->limit($limit)->select();

		self::output($videos);

	}

	public function random() {
		if ( I('limit') ) { $limit = $_GET['limit']; } else { $limit = 10; };
		$videos = M('video')->order('RAND( )')->limit($limit)->select();

		self::output($videos);

	}



	private function output($videos) {

		foreach($videos as $video) {
			$output[data][] = $video;
		};
		echo json_encode($output);

	}

}

?>