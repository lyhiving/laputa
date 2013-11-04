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
class VideoAction extends Action {


	public function id() {
		if ( I('vid') ) { $vid = $_GET['vid']; } ;
		$videos = M('video')->where("id=$vid")->select();

		self::output($videos);

	}

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

	public function collection() {
		$cid = I('cid');
		if ( I('limit') ) { $limit = $_GET['limit']; } else { $limit = 1; };
		if ( I('page') ) { 
			$page = $_GET['page'];
			$counts = M('collection')->where("id=$cid")->getField('count'); 
			$num = floor($counts / $limit);
			if ($num < $page) { $page = $num ; };
		} else { $page = 1; };
			 
		//列出相关数组
        $Actions = M('action')->field("object")->order("createdTime DESC")->where(array('target' => $cid ,'type' => 3))->limit($limit)->page($page)->select();
        foreach ($Actions as $a) {
        	$videos[] = M('video')->find($a['object']);
        };

		self::output($videos);

	}


	private function output($videos) {

		$videos = videothumb($videos);
		foreach($videos as $video) {
			$output[data][] = $video;
		};
		header('Access-Control-Allow-Origin: *');
		echo json_encode($output);

	}

}

?>