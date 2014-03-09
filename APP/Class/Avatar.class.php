<?php
// +----------------------------------------------------------------------
// | AIMOZHEN [ SHARE VIDES SHARE LIFES ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://aimozhen.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: lianghonghao <lianghonghao@baixing.com>
// +----------------------------------------------------------------------

/**
 * Gravatar Class
 */


class Avatar {
	public $email;
	public $default = "http://aimozhen.com/public/images/amzlogo.jpg";

	public function __construct($email) {
		$this->email = $email;
	}

	public function link($size = 32) {
		return "http://www.gravatar.com/avatar/"
			. md5( strtolower( trim( $this->email ) ) )
			. "?d=" . urlencode( $this->default )
			. "&s=" . $size;
	}

	public function editLink() {
		return "https://api.weibo.com/oauth2/authorize?client_id=2517727821&response_type=code&redirect_uri=http://aimozhen.com/ajax/oauth/weibo.php";
	}
}

class WeiboAvatar {
    private $id;
    public function __construct($id) {
        $this->id = $id;
    }
    public function link() {
        return "http://tp1.sinaimg.cn/{$this->id}/180/0/1";
    }

    public function editLink() {
        return "javascript:alert('这个就是微博头像……');";
    }
}


