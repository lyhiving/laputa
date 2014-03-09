<?php
//fuxiaopang@msn.com
/**
 * DuoShuo
 */
class DuoShuo {


	public function syncUser($user_id) {

		$user = M('user')->find($user_id);
		$url = 'http://api.duoshuo.com/users/import.json';

		$data = array(
			'short_name' => C('DUOSHUO_USER'),
			'secret' => C('DUOSHUO_SECRET'),
			'users' => array(
			 )
		);
		$data['users'][]=  array(
			'user_key' => $user[id],
			'name' => $user[username],
			'avatar_url' => getavatar($user),
			'email' => $user[email],
			'url' => 'http://aimozhen.com/'.$user[shortname].'/',
			'created_at' => date('Y-m-d H:i:s', $user[createdTime])
			);
		$result = self::request_by_curl($url,http_build_query($data));
		if (!$user[duoshuoId]) {
			$content = json_decode ($result);
			M('user')->where("id=$user_id")->setField("duoshuoId",$content->response->$user_id);
			}


		return  $result;
	}

	// 未更新
	public function syncPost($video_id) {

		$video = new Video($video_id);
		$url = 'http://api.duoshuo.com/threads/import.json';

		$data = array(
			'short_name' => C('DUOSHUO_USER'),
			'secret' => C('DUOSHUO_SECRET'),
			'threads' => array(
			 )
		);
		$data['threads'][]=  array(
			'thread_key' => $video->id,
			'title' => $video->title,
			'url' => 'http://aimozhen.com/video/'.$video->id.'/',
			'author_key' => $video->userid
			);
		$result = self::request_by_curl($url,http_build_query($data));
		return  $result;
	}

	//更新文章数目
	public function syncCommentNum($post_id) {
		$handle = fopen("http://api.duoshuo.com/threads/counts.json?short_name=".C('DUOSHUO_USER')."&threads=".$post_id,"rb");
		$all = "";
		while (!feof($handle)) {
			$content .= fread($handle, 1000000);
		}
		fclose($handle);
		$content = json_decode($content);

		foreach ($content->response as $key) { ;
			M('video')->where("id=".$key->thread_key)->setField("comment",$key->comments);
			$all .= "VIDEO - $key->thread_key | -- $key->comments <br/>";
	     }


		 return $all;
	}

	//获取最近更新ID
	public function syncComment($nums) {

			$handle = fopen("http://api.duoshuo.com/log/list.json?short_name=".C('DUOSHUO_USER')."&secret=".C('DUOSHUO_SECRET')."&limit=".$nums."&order=desc","rb");
			$allid = '';
			while (!feof($handle)) {
				$content .= fread($handle, 10000);
			}
			fclose($handle);
			$content = json_decode($content);

			foreach ($content->response as $key) { ;
				$allid .=  $key->meta->thread_key.",";
		 }

		 return $allid;
	}




	public function syncCommentContent($nums) {
			$config = Config::get('env.duoshuo');

			$handle = fopen("http://api.duoshuo.com/log/list.json?short_name=".$config['short_name']."&secret=".$config['secret']."&limit=".$nums."&order=desc","rb");
			$content = "";
			$allid = '';
			while (!feof($handle)) {
				$content .= fread($handle, 10000);
			}
			fclose($handle);
			$content = json_decode($content);

			foreach ($content->response as $key) { ;
				$user = new User();
				$user->duoshuoId = $key->user_id;
				$comment = new Comment();
				$comment->duoshuoId = $key->meta->post_id;
				if ($comment->count()) {} else {
					if ($user->count()) {
						$the_user = current($user->find());
							if ($the_user) {
								$comment = new Comment();
								$comment->comment = htmlentities($key->meta->message, 0, 'UTF-8');
								$comment->userid = $the_user->id;
								$comment->createdTime = strtotime($key->meta->created_at);
								$comment->videoid = $key->meta->thread_key;
								$comment->duoshuoId = $key->meta->post_id;
								$comment->save();
							}
					}
				}
				$allid .=  $key->meta->thread_key.",";
		 	}
		 return $allid;
	}


	private function request_by_curl($remote_server, $post_string)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $remote_server);
	curl_setopt( $handle, CURLOPT_POST, true );
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//curl_setopt($ch, CURLOPT_USERAGENT, "aimozhen");
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}


}
