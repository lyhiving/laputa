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
//  allownetworking="internal"


class Video {

    private  $url;
    private  $playId;

    const VIDEO_TYPE_YOUKU = 1;
    const VIDEO_TYPE_TUDOU = 2;
    const VIDEO_TYPE_YINYUETAI = 3;
    const VIDEO_TYPE_LETV = 4;
    const VIDEO_TYPE_56 = 5;
    const VIDEO_TYPE_SINA = 6;
	const VIDEO_TYPE_SOHU = 7;
    const VIDEO_TYPE_KU6 = 8;
    const VIDEO_TYPE_UNKNOW = -1;


    function __construct($url,$playId) {
        $this->url = $url;
        $this->playId = $playId;
    }

    public function type() {
        if (strpos($this->url, 'youku')) {
            return self::VIDEO_TYPE_YOUKU;
        } elseif (strpos($this->url, 'tudou')) {
            return self::VIDEO_TYPE_TUDOU;
        } elseif (strpos($this->url, 'yinyuetai.com')) {
            return self::VIDEO_TYPE_YINYUETAI;
        } elseif (strpos($this->url, 'letv.com')) {
            return self::VIDEO_TYPE_LETV;
        } elseif (strpos($this->url, '56.com')) {
            return self::VIDEO_TYPE_56;
        } elseif (strpos($this->url, 'video.sina.com.cn')) {
            return self::VIDEO_TYPE_SINA;
        } elseif (strpos($this->url, 'tv.sohu.com')) {
            return self::VIDEO_TYPE_SOHU;
        } elseif (strpos($this->url, 'ku6.com')) {
            return self::VIDEO_TYPE_KU6;
        } else {
            return self::VIDEO_TYPE_UNKNOW;
        }
    }

    public function content() {
        switch ($this->type()) {
            case self::VIDEO_TYPE_YOUKU:
                return $this->youku_content();
            case self::VIDEO_TYPE_TUDOU:
                return $this->tudou_content();
            case self::VIDEO_TYPE_YINYUETAI:
                return $this->yinyuetai_content();
            case self::VIDEO_TYPE_LETV:
                return $this->letv_content();
            case self::VIDEO_TYPE_56:
                return $this->_56_content();
            case self::VIDEO_TYPE_SINA:
                return $this->sina_content();
           	case self::VIDEO_TYPE_SOHU:
                return $this->sohu_content();
            case self::VIDEO_TYPE_KU6:
                return $this->ku6_content();
            default :
                return $this->url;
        }
    }

	/**
	 *  返回网站名
	 */
	 public function sourceSite() {
        switch ($this->type()) {
            case self::VIDEO_TYPE_YOUKU:
                return "youku";
            case self::VIDEO_TYPE_TUDOU:
                return "tudou";
            case self::VIDEO_TYPE_YINYUETAI:
                return "yinyuetai";
            case self::VIDEO_TYPE_LETV:
                return "letv";
            case self::VIDEO_TYPE_56:
                return "w56";
            case self::VIDEO_TYPE_SINA:
                return "sina";
            case self::VIDEO_TYPE_SOHU:
                return "sohu";
            case self::VIDEO_TYPE_KU6:
                return "ku6";
            default :
                return "";
        }
    }

    private function youku_content() {
        if (preg_match("/id_(.*?)\.html/", $this->url, $matches)) {
            $id = $matches[1];
        } else return self::iframePlayer();

        $data['pc']= '<embed src="/public/player/loader.swf?showAd=0&VideoIDS='.$id.'&isAutoPlay=true" allowFullScreen="true" quality="high" align="middle" allowScriptAccess="always" wmode="opaque" mode="transparent" type="application/x-shockwave-flash"></embed>';
		$data['mobile']= '<iframe src="http://player.youku.com/embed/'.$id.'" allowtransparency="true" scrolling="no" border="0" frameborder="0"></iframe>';

        return $data;
    }

    private function tudou_content() {
		if ( preg_match('#/view/([^\/]+)#', $this->url, $matches) ){
			$id = $matches[1];
		} elseif ( preg_match('#/albumplay/(\S+)\.html#', $this->url, $matches) ){
			$id = $matches[1];
		} else return self::iframePlayer();

        $data['pc']= '<embed src="http://www.tudou.com/v/'.$id.'/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque"></embed>';
		$data['mobile']= '<iframe src="http://www.tudou.com/programs/view/html5embed.action?code='.$id.'" allowtransparency="true" scrolling="no" border="0" frameborder="0""></iframe>';

        return $data;
    }

    private function yinyuetai_content() {
        if (preg_match("#/video/(\d+)#", $this->url, $matches)) {
            $id = $matches[1];
        } else return self::iframePlayer();

		$data['pc']= '<embed src="http://player.yinyuetai.com/video/player/'.$id.'/a_0.swf" quality="high" allowScriptAccess="always" allowfullscreen="true" type="application/x-shockwave-flash"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }

    private function letv_content() {
        if (preg_match("#(vplay|pplay)/(\d+)#", $this->url, $matches)) {
            $id = $matches[2];
        } else return self::iframePlayer();

		$data['pc']= '<embed src="/public/player/letv.swf?id='.$id.'&autoplay=1"  type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" wmode="opaque" mode="transparent"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }

    private function _56_content() {
        if (preg_match("/v_(.*?)\.html/", $this->url, $matches)) {
            $id = $matches[1];
        } else return self::iframePlayer();

		$data['pc']= '<embed src="http://player.56.com/renrenshare_'.$id.'.swf" type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" wmode="opaque" mode="transparent"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }


    private function sohu_content() {
        if ($this->playId) {
            $id = $this->playId;
        } else return self::iframePlayer();

		$data['pc']= '<embed src="http://share.vrs.sohu.com/'.$id.'/v.swf&autoplay=true" type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" wmode="opaque" mode="transparent"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }

    private function sina_content() {
        if ($this->playId) {
            $id = $this->playId;
        } else return self::iframePlayer();

		$data['pc']= '<embed src="http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid='.$id.'/s.swf" type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" wmode="opaque" mode="transparent"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }

    private function ku6_content() {
        if(preg_match("/show/", $this->url)){
            preg_match("#/([\w\.]*?)\...html#", $this->url, $matches);
            $id = $matches[1];
        } else return self::iframePlayer();

		$data['pc']= '<embed src="/public/player/ku6.swf?vid='.$id.'&isAutoPlay=true" type="application/x-shockwave-flash" allowFullScreen="true" allowNetworking="all" allowScriptAccess="always" wmode="opaque" mode="transparent"></embed>';
		$data['mobile']= self::iframePlayer();

        return $data;
    }


    private function iframePlayer() {
		$url = $this->url;
		return <<<CONTENT
<iframe src="{$url}" scrolling="no" border="0" frameborder="0" style="height:600px; overflow:hidden"></iframe>
CONTENT;

    }

}




?>