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
 * 后台控制中心 数据纠正
 */
class UpdateAction extends CommonAction {

	public function video() {
		if (CommonAction::$user['group']!=1) $this->redirect('/');
		$max_id = M('video')->max('id');
		echo $max_id.'<br>';

		$allid = '';
		$num = 0;
		while ($num <= $max_id) {
			$video = M('video')->where("id=$num")->find();
			if (!$video){
				$num ++;
			} else {
				$allid .= $video[id].",";
				$num ++;
			}
		}

		import('Class.DuoShuo', APP_PATH);
        $result = DuoShuo::syncCommentNum($allid);

		echo ($result);

	}

	public function tag() {
		if (CommonAction::$user['group']!=1) $this->redirect('/');
		$max_id = M('tag')->max('id');
		echo $max_id.'<br>';

		$all = '';
		$num = 0;
		while ($num <= $max_id) {
			$where = array('pre_tag' => $num, 'verify' => 0);
			$count = M('video')->where($where)->count();
			M('tag')->where("id=$num")->setField('count',$count);

			$vwhere = array('pre_tag' => $num, 'verify' => 1);
			$vcount = M('video')->where($vwhere)->count();
			M('tag')->where("id=$num")->setField('countOriginal',$vcount);

			$all .= "tag|$num -- 分享|$count -- 原创|$vcount <br/>";

			$num ++;
		}


		echo $all.'<br/>';

	}

	public function collection() {
		if (CommonAction::$user['group']!=1) $this->redirect('/');
		$max_id = M('collection')->max('id');
		echo $max_id.'<br>';

		$all = '';
		$num = 0;
		while ($num <= $max_id) {
			$where = array('target'=>$num, 'type'=>3);
			$count = M('action')->where($where)->count();
			M('collection')->where("id=$num")->setField("count",$count);

			$all .= "$num | $count  <br/>";
			$num ++;
		}


		echo $all.'<br/>';

	}

	public function user() {
		if (CommonAction::$user['group']!=1) $this->redirect('/');
		$max_id = M('user')->max('id');
		echo $max_id.'<br>';

		$all = '';
		$num = 0;
		while ($num <= $max_id) {
			$user = M('user')->where("id=$num")->find();
			if (!$user){
				$num ++;
			} else {
				$postCount = M('video')->where("userid=$num")->count();

				$postOriginalWhere = array('userid'=>$num, 'verify'=> 1);
				$postOriginalCount = M('video')->where($postOriginalWhere)->count();

				$likeWhere = array('userid'=>$num, 'type'=> 1);
				$likeCount = M('action')->where($likeWhere)->count();

				$followWhere = array('userid'=>$num, 'type'=> 2);
				$followCount = M('action')->where($followWhere)->count();

				$data = array(
					'post' => $postCount,
					'postOriginal' => $postOriginalCount,
					'likecount' => $likeCount,
					'follow' => $followCount
				);
				M('user')->where("id=$num")->save($data);

				$all .= $num."  |  ".$user[username]."  | -- 总分享|$postCount -- 原创|$postOriginalCount -- 收藏|$likeCount --关注|$followCount <br/>";

				$num ++;
			}
		}
		echo $all.'<br/>';

	}




	public function autocoll() {
		if (CommonAction::$user['group']!=1) $this->redirect('/');
		$max_id = M('video')->max('id');
		echo $max_id.'<br>';

		$all = '';
		$num = 0;
		while ($num <= $max_id) {
			$video = M('video')->where("id=$num")->find();
			if (!$video){
				$num ++;
			} else {
				if (($video[collection] !=0)&&($video[collection] !=1) ) {
					$data = array('userid' => 4 ,'object' => $num ,'target' => $video[collection] ,'type' => 3 ,'createdTime' => time() );
					M('action')->add($data);
					$all .= "V | $num -- C|$video[collection] <br/>";
				} elseif ($video[collection] == 1) {
					$video = M('video')->where("id=$num")->setField("collection",'');
				}
				$num ++;
			}
		}

		echo ($all);

	}








}
?>