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
// | Inspired By: Dijia Huang <huangdijia@gmail.com>
// +----------------------------------------------------------------------


class VideoUrlParser
{
    const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko)
        Chrome/8.0.552.224 Safari/534.10";
    const CHECK_URL_VALID = "/(youku\.com|tudou\.com|ku6\.com|56\.com|letv\.com|yinyuetai\.com|video\.sina\.com\.cn|tv\.sohu\.com|v\.qq\.com)/";

    /**
     * parse
     *
     * @param string $url
     * @param mixed $createObject
     * @static
     * @access public
     * @return void
     */
    static public function parse($url='', $createObject=true){
        $lowerurl = strtolower($url);
        preg_match(self::CHECK_URL_VALID, $lowerurl, $matches);
        if(!$matches) return false;

        switch($matches[1]){
        case 'youku.com':
            $data = self::_parseYouku($url);
            break;
        case 'tudou.com':
            $data = self::_parseTudou($url);
            break;
        case 'yinyuetai.com':
            $data = self::_parseYinyuetai($url);
            break;
        case 'letv.com':
            $data = self::_parseLetv($url);
            break;
        case '56.com':
            $data = self::_parse56($url);
            break;
        case 'video.sina.com.cn':
            $data = self::_parseSina($url);
            break;
        case 'tv.sohu.com':
            $data = self::_parseSohu($url);
            break;
        case 'v.qq.com':
            $data = self::_parseQq($url);
            break;
        case 'ku6.com':
            $data = self::_parseKu6($url);
            break;
        default:
            $data = false;
        }

        if($data && $createObject) $data['object'] = "<embed src=\"{$data['swf']}\" wmode=\"opaque\" quality=\"high\" width=\"1002\" height=\"590\" align=\"middle\" allowNetworking=\"all\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>";
        return $data;
    }
    /**
     * 腾讯视频
     * http://v.qq.com/cover/o/o9tab7nuu0q3esh.html?vid=97abu74o4w3_0
     * http://v.qq.com/play/97abu74o4w3.html
     * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o.html
     * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o/9SfqULsrtSb.html
     * http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?_v=20110829&vid=97abu74o4w3&autoplay=1&list=2&showcfg=1&tpid=23&title=%E7%AC%AC%E4%B8%80%E7%8E%B0%E5%9C%BA&adplay=1&cid=o9tab7nuu0q3esh
     */
    private function _parseQq($url){
        if(preg_match("/\/play\//", $url)){
            $html = self::_fget($url);
            preg_match("/url=[^\"]+/", $html, $matches);
            if(!$matches); return false;
            $url = $matches[0];
        }
        preg_match("/vid=([^\_]+)/", $url, $matches);
        $vid = $matches[1];
        $html = self::_fget($url);
        // query
        preg_match("/flashvars\s=\s\"([^;]+)/s", $html, $matches);
        $query = $matches[1];
        if(!$vid){
            preg_match("/vid\s?=\s?vid\s?\|\|\s?\"(\w+)\";/i", $html, $matches);
            $vid = $matches[1];
        }
        $query = str_replace('"+vid+"', $vid, $query);
        parse_str($query, $output);
        $data['img'] = "http://vpic.video.qq.com/{$$output['cid']}/{$vid}_1.jpg";
        $data['url'] = $url;
        $data['title'] = $output['title'];
        $data['swf'] = "http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?".$query;
        return $data;
    }

    /**
     * 优酷网 官方API解析法 2014年03月06日
     * http://v.youku.com/v_show/id_XMjI4MDM4NDc2.html
     * http://player.youku.com/player.php/sid/XMjU0NjI2Njg4/v.swf
     */
    private function _parseYouku($url){
        preg_match("#id\_(\w+)#", $url, $matches);

        if (empty($matches)){
            preg_match("#v_playlist\/#", $url, $mat);
            if(!$mat) return false;

            $html = self::_fget($url);

            preg_match("#videoId2\s*=\s*\'(\w+)\'#", $html, $matches);
            if(!$matches) return false;
        }

		$youkuId = C('YOUKU_ID');
		$link = "https://openapi.youku.com/v2/videos/show.json?client_id=$youkuId&video_id={$matches[1]}";
        //$link = "http://v.youku.com/player/getPlayList/VideoIDS/{$matches[1]}/timezone/+08/version/5/source/out?password=&ran=2513&n=3";
        $retval = get_Curl($link);
        if ($retval) {
            $json = json_decode($retval, true);
            $data['img'] = $json['bigThumbnail'];
            $data['title'] = $json['title'];
			$data['description'] = $json['description'];
			$data['tags'] = $json['tags'];
            $data['url'] = $url;
            $data['swf'] = "http://player.youku.com/player.php/sid/{$matches[1]}/v.swf";

            return $data;
        } else {
            return false;
        }
    }

    /**
     * 土豆网 官方API解析法 2014年03月08日
     * http://www.tudou.com/programs/view/Wtt3FjiDxEE/
     * http://www.tudou.com/v/Wtt3FjiDxEE/v.swf
     */
    private function _parseTudou($url){
		$tudouKey = C('TUDOU_KEY');

		if ( preg_match('#/view/(\S+)#', $url, $matches) ){
			$link = "http://api.tudou.com/v6/video/info?app_key=$tudouKey&format=json&itemCodes={$matches[1]}";

	        $retval = get_Curl($link);
	        if ($retval) {
	            $json = json_decode($retval, true);
	            $item = $json['results'][0];
	            if($item['bigPicUrl']) {
	            	$data['img'] = $item['bigPicUrl'];
	            } else {
	            	$data['img'] = $item['picUrl'];
	            }
	            $data['title'] = $item['title'];
				$data['description'] = $item['description'];
				$data['tags'] = $item['tags'];
	            $data['url'] = $url;
	            return $data;
	        }

		} elseif ( preg_match('#/albumplay/(\S+)\.html#', $url, $matches) ){
			$link = "http://api.tudou.com/v6/tool/repaste?app_key=$tudouKey&format=json&url={$url}";

	        $retval = get_Curl($link);
	        if ($retval) {
	            $json = json_decode($retval, true);

	            $item = $json['albumInfo'];
	            if($item['middlePicurl']) {
	            	$data['img'] = $item['middlePicurl'];
	            } else {
	            	$data['img'] = $item['picUrl'];
	            }
	            $data['title'] = $item['name'];
				$data['description'] = $item['desc'];
				$data['tags'] = $item['area'];
	            $data['url'] = $url;
	            return $data;
	        }

		}

    }

    /**
     * 酷6网
     * http://v.ku6.com/film/show_520/3X93vo4tIS7uotHg.html
     * http://v.ku6.com/special/show_4926690/Klze2mhMeSK6g05X.html
     * http://v.ku6.com/show/7US-kDXjyKyIInDevhpwHg...html
     * http://player.ku6.com/refer/3X93vo4tIS7uotHg/v.swf
     */
    private function _parseKu6($url){
        if(preg_match("/show/", $url)){
            preg_match("#/([\w\.]*?)\...html#", $url, $matches);
			var_dump($matches);
            $url = "http://v.ku6.com/fetchVideo4Player/{$matches[1]}.html";
            $html = self::_fget($url);

            if ($html) {
                $json = json_decode($html, true);
                if(!$json) return false;

                $data['img'] = $json['data']['bigpicpath'] ;
                $data['title'] = $json['data']['t'] ;
                $data['url'] = $url;
                $data['swf'] = "http://player.ku6.com/refer/{$matches[1]}/v.swf";

                return $data;
            } else {
                return false;
            }
        }elseif(preg_match("/show\//", $url, $matches)){
            $html = self::_fget($url);
            preg_match("/ObjectInfo\s?=\s?([^\n]*)};/si", $html, $matches);
            $str = $matches[1];
            // img
            preg_match("/cover\s?:\s?\"([^\"]+)\"/", $str, $matches);
            $data['img'] = $matches[1];
            // title
            preg_match("/title\"?\s?:\s?\"([^\"]+)\"/", $str, $matches);
            $jsstr = "{\"title\":\"{$matches[1]}\"}";
            $json = json_decode($jsstr, true);
            $data['title'] = $json['title'];
            // url
            $data['url'] = $url;
            // query
            preg_match("/\"(vid=[^\"]+)\"\sname=\"flashVars\"/s", $html, $matches);
            $query = str_replace("&amp;", '&', $matches[1]);
            preg_match("/\/\/player\.ku6cdn\.com[^\"\']+/", $html, $matches);
            $data['swf'] = 'http:'.$matches[0].'?'.$query;

            return $data;
        }
    }

    /**
     * 56网 官方API解析法 2014年03月06日
     * http://www.56.com/u73/v_NTkzMDcwNDY.html
     * http://player.56.com/v_NTkzMDcwNDY.swf
     */
    private function _parse56($url){
        preg_match("#/v_(\w+)\.html#", $url, $matches);

        if (empty($matches)) return false;

		$w56_ID = C('56_ID');
		$w56_SECRET = C('56_SECRET');
		$time = time();
        $sign = md5(md5("vid=$matches[1]").'#'.$w56_ID.'#'.$w56_SECRET.'#'.$time);

        $link="http://oapi.56.com/video/getVideoInfo.json?appkey=$w56_ID&vid=$matches[1]&ts=$time&sign=$sign";
        $retval = self::_cget($link);

        if ($retval) {
            $json = json_decode($retval, true);
            $data['img'] = $json['0']['bimg'];
            $data['title'] = $json['0']['title'];
            $data['description'] = $json['0']['desc'];
            $data['tags'] = $json['0']['tag'];
            $data['url'] = $url;
            $data['swf'] = "http://player.56.com/v_{$matches[1]}.swf";

            return $data;
        } else {
            return false;
        }
    }

    /**
     * 音悦台 网页抓取解析法 2014年03月08日
     * http://www.yinyuetai.com/video/713721
     * http://player.yinyuetai.com/video/player/713721/v_0.swf
     */
    private function _parseYinyuetai($url){
		preg_match("#/video/(\d+)#", $url, $vid);
		$retval = get_Curl($url);

        if ($retval) {

			preg_match_all("#content=\"(.*)\"\/>#", $retval, $matches);
			$data['img'] = $matches[1][4];
            $data['title'] = $matches[1][2];
			$data['description'] = $matches[1][1];
			$data['tags'] = $matches[1][0];
            $data['url'] = $url;
            $data['swf'] = "http://player.yinyuetai.com/video/swf/{$vid[1]}/v_0.swf";
            return $data;
        } else {
            return false;
        }

    }

    /**
     * 乐视网 网页抓取解析法 2014年03月08日
     * http://www.letv.com/ptv/vplay/1168109.html
     * http://www.letv.com/player/x1168109.swf
     */
    private function _parseLetv($url){

		preg_match("#/vplay/(\d+)\.html#", $url, $vid);
		$retval = get_Curl($url);

        if ($retval) {
			preg_match("#share:{pic:\"(.*)\"#", $retval, $matches);
			$data['img'] = $matches[1];

			preg_match("#title\:\"(.*)\"#", $retval, $matches);
            $data['title'] = $matches[1];
			$data['description'] = "";
			$data['tags'] = "";
			$data['url'] = $url;
            $data['swf'] = "http://www.letv.com/player/x{$vid[1]}.swf";

            return $data;
        } else {
            return false;
        }
    }

    /**
     * 搜狐TV 网页抓取解析法 2014年03月08日
     * http://tv.sohu.com/20140214/n395013286.shtml
     */
    private function _parseSohu($url){
        $retval = get_Curl($url);
        $retval = iconv("GB2312", "UTF-8", $retval);

        if ($retval) {
			preg_match_all("/(?:property|name)=\"(?:(?:description|album)|og:(?:|title|image|videosrc))\"\scontent=\"([^\"]+)\"/s", $retval, $matches);
			$data['img'] = $matches[1][4];
            $data['title'] = $matches[1][3];
			$data['description'] = $matches[1][0];
			$data['tags'] = $matches[1][1];
			$data['url'] = $url;

			preg_match("/(\d+)/", $matches[1][2], $vid);
			$data['playId'] = $vid[1];

            return $data;
        } else {
            return false;
        }

    }

    /**
     * 新浪播客 网页抓取解析法 2014年03月08日
     * http://video.sina.com.cn/v/b/48717043-1290055681.html
     * http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=48717043_1290055681_PUzkSndrDzXK+l1lHz2stqkP7KQNt6nki2O0u1ehIwZYQ0/XM5GdatoG5ynSA9kEqDhAQJA4dPkm0x4/s.swf
     */
    private function _parseSina($url){
        $retval = get_Curl($url);

        if ($retval) {
			preg_match_all("/(?:vid|pic|title):(?: |)\'([^\']+)\'/s", $retval, $matches);
			$data['img'] = $matches[1][2];
            $data['title'] = $matches[1][3];
            $data['description'] = $matches[1][3];
			$data['playId'] = $matches[1][4];
			$data['url'] = $url;

			preg_match("/name=\"keywords\" content=\"([^\"]+)\"/s", $retval, $matches);
			$data['tags'] = $matches[1];
            return $data;
        } else {
            return false;
        }
    }


}