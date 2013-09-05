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
 * 发送邮件控制器
 */
class MailAction extends CommonAction {

	private $toUser;
	private $title;
	private $content;
	private $fromName;
	private $html;

	/**
	 * 内测申请
	 * 系统邮件
	 */
	public function register() {
		ignore_user_abort(true);
       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       if (!I('reason')) $this->error('没有内容');

       $uid = I('uid') ; $email = I('email') ; $name = I('name') ; $sex = I('sex') ; $reason = I('reason') ;


		$this->toUser = "admin@aimozhen.com";
		$this->title = "【内测申请】艾墨镇内测用户申请";
		$this->fromName = "艾墨镇";

		$this->content = <<<EOF
<p>【UID】 $uid</p>
<p>【Email】 $email</p>
<p>【真实姓名】 $name</p>
<p>【性别】 $sex</p>
<p>【注册原因】 $reason</p>
<p> </p>
<p>【一键转正】 <a href="http://aimozhen.com/admin/ajax/guest/email/$email/uid/$uid/" target="_blank">同意点这里</a></p>
<p><span style="color: #F00">【一键认证】</span> <a href="http://aimozhen.com/admin/ajax/verify/email/$email/uid/$uid/" target="_blank">同意点这里</a></p>
EOF;

		self::sendSystEmmail();
		$this->redirect('/');

	}

	/**
	 * 转正申请邮件
	 * 用户邮件
	 */
	public function guestConfirm($email) {
		ignore_user_abort(true);
		if ($email) {
			$this->toUser = $email;
			$this->title = "艾墨镇 欢迎你！";
			$this->fromName = "艾墨镇";
			$this->content = '	<p>亲爱的镇民 :</p>
				<p>你的转正申请已经通过我们的审核，快点击下面的链接开启你的奇幻之旅吧！</p>
				<p>艾墨镇 分享视频 创造梦想 <a href="http://aimozhen.com/" target="_blank">http://aimozhen.com/</a></p>';
			self::temp();
			self::sendMail();

		}
	}

	/**
	 * 认证申请邮件
	 * 用户邮件
	 */
	public function verifyConfirm($email) {
		ignore_user_abort(true);
		if ($email) {
			$this->toUser = $email;
			$this->title = "艾墨镇 欢迎你！";
			$this->fromName = "艾墨镇";
			$this->content = '	<p>亲爱的镇民 :</p>
				<p>你的转正申请已经通过我们的审核，与此同时，我们还将你添加到了我们的认证作者组中，即刻起你便可以在发布作品时标注“原创”属性，原创类作品还可以在“创作人”版块中出现！</p><br />
				<p>艾墨镇 分享视频 创造梦想 <a href="http://aimozhen.com/" target="_blank">http://aimozhen.com/</a></p>';
			self::temp();
			self::sendMail();

		}
	}

	/**
	 * 认领申请邮件
	 * 用户邮件
	 */
	public function copyright() {
		ignore_user_abort(true);

       if (!CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       if (!I('reason')) $this->error('没有内容');

        $uid = I('uid') ; $vid = I('vid') ; $reason = I('reason'); $name = I('name');

		$video = M('video')->field('id,title,userid')->where("id=$vid")->find();
		$old_user = M('user')->field('id,username,email')->where("id=$video[userid]")->find();
		$user = M('user')->field('id,username,email')->where("id=$uid")->find();

		$this->toUser = "admin@aimozhen.com";
		$this->title = "【作品认领】艾墨镇作品认领申请";
		$this->fromName = "艾墨镇";

		$this->content = <<<EOF
<p>【作品认领】艾墨镇视频认领</p>
<p>【申请人】 $name </p>
<p>【视频】 <a href="http://aimozhen.com/video/$vid/" target="_blank">$vid、$video[title]</a> </p>
<p>【原发布者】 $old_user[id]、$old_user[username]  |  $old_user[email]</p>
<p>【新发布者】 $user[id]、$user[username]  |  $user[email]</p>
<p>【申请说明】 $reason</p>
<p> </p>
<p>【一键同意】 <a href="http://aimozhen.com/admin/ajax/copyright/vid/$vid/newuid/$uid/" target="_blank">同意点这里</a></p>
EOF;

		self::sendSystEmmail();
		$this->redirect('/');

	}


	/**
	 * 作品认领邮件
	 * 用户邮件
	 */
	public function copyrightConfirm($oldemail, $newemail, $vid) {
		ignore_user_abort(true);
		if ($oldemail) {
			$this->toUser = $oldemail;
			$this->title = "艾墨镇 作品认领通知！";
			$this->fromName = "艾墨镇";
			$this->content = '<p>亲爱的镇民 :</p>
							<p>你发布的一部作品被原作者认领，系统已经将这部作品的发布者修正，如果你有疑义可以发送邮件到 admin@aimozhen.com 与我们取得联系。</p>
							<p>被认领作品的地址是：<a href="http://aimozhen.com/video/'.$vid.'/">http://aimozhen.com/video/'.$vid.'/</a></p>
							<p>艾墨镇 分享视频 创造梦想 <a href="http://aimozhen.com/" target="_blank">http://aimozhen.com/</a></p>';
			self::temp();
			self::sendMail();

		}
		if ($newemail) {
			$this->toUser = $newemail;
			$this->title = "艾墨镇 作品认领通知！";
			$this->fromName = "艾墨镇";
			$this->content = '<p>亲爱的镇民 :</p>
							<p>你的认领请求已经被接受，系统已经将这部作品分配到你的账户，你可以登录系统后，再次编辑作品信息(比如重新设置为原创作品)，如果你有疑义可以发送邮件到 admin@aimozhen.com 与我们取得联系。</p>
							<p>被认领作品的地址是：<a href="http://aimozhen.com/video/'.$vid.'/">http://aimozhen.com/video/'.$vid.'/</a></p>
							<p>艾墨镇 分享视频 创造梦想 <a href="http://aimozhen.com/" target="_blank">http://aimozhen.com/</a></p>';
			self::temp();
			self::sendMail();

		}

		$this->redirect('http://aimozhen.com/video/'.$vid);
	}

	/**
	 * 找回密码邮件
	 * 用户邮件
	 */
	public function lostPassword() {

		ignore_user_abort(true);
		$email = I('email');
		$user = M('user')->where(array('email' => $email))->field("id,email,username")->find();
		if ($user[id]) {
			$validate = md5(rand(10,100));
			M('user')->where(array('email' => $email))->setField("validate", $validate);

			$this->toUser = $email;
			$this->title = "艾墨镇 找回密码";
			$this->fromName = "艾墨镇";
			$this->content = '	<p>亲爱的镇民 :</p>
				<p>您的密码重设要求已经得到验证。请点击以下链接输入您新的密码：</p>
				<p><a href="http://aimozhen.com/User/Member/forget/id/' .$user[id]. '/v/' .$validate. '/" target="_blank">http://aimozhen.com/User/Member/forget/id/' .$user[id]. '/v/' .$validate. '/</a></p>
				<p>艾墨镇 分享视频 创造梦想 <a href="http://aimozhen.com/" target="_blank">http://aimozhen.com/</a></p>';
			self::temp();
			self::sendMail();
			$this->success("请查收邮件");
		} else {
			$this->error("未找到用户请重试");
		}
	}



	public function sendSystEmmail() {
		ignore_user_abort(true);
		import('Class.Mail', APP_PATH);
		SendMail($this->toUser,$this->title,$this->content,$this->fromName);
	}

	public function sendMail() {
		ignore_user_abort(true);
		import('Class.Mail', APP_PATH);
		SendMail($this->toUser,$this->title,$this->html,$this->fromName);
	}




	public function temp() {
		ignore_user_abort(true);
$this->html = <<<EOF

<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html><head><title></title><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta name="viewport" content="width=320, target-densitydpi=device-dpi" />
<style type="text/css">
@media only screen and (max-width: 660px) {
table[class=w0], td[class=w0] { width: 0 !important; }
table[class=w10], td[class=w10], img[class=w10] { width:10px !important; }
table[class=w15], td[class=w15], img[class=w15] { width:5px !important; }
table[class=w30], td[class=w30], img[class=w30] { width:10px !important; }
table[class=w60], td[class=w60], img[class=w60] { width:10px !important; }
table[class=w125], td[class=w125], img[class=w125] { width:80px !important; }
table[class=w130], td[class=w130], img[class=w130] { width:55px !important; }
table[class=w140], td[class=w140], img[class=w140] { width:90px !important; }
table[class=w160], td[class=w160], img[class=w160] { width:180px !important; }
table[class=w170], td[class=w170], img[class=w170] { width:100px !important; }
table[class=w180], td[class=w180], img[class=w180] { width:80px !important; }
table[class=w195], td[class=w195], img[class=w195] { width:80px !important; }
table[class=w220], td[class=w220], img[class=w220] { width:80px !important; }
table[class=w240], td[class=w240], img[class=w240] { width:180px !important; }
table[class=w255], td[class=w255], img[class=w255] { width:185px !important; }
table[class=w275], td[class=w275], img[class=w275] { width:135px !important; }
table[class=w280], td[class=w280], img[class=w280] { width:135px !important; }
table[class=w300], td[class=w300], img[class=w300] { width:140px !important; }
table[class=w325], td[class=w325], img[class=w325] { width:95px !important; }
table[class=w360], td[class=w360], img[class=w360] { width:140px !important; }
table[class=w410], td[class=w410], img[class=w410] { width:180px !important; }
table[class=w470], td[class=w470], img[class=w470] { width:200px !important; }
table[class=w580], td[class=w580], img[class=w580] { width:280px !important; }
table[class=w640], td[class=w640], img[class=w640] { width:300px !important; }
table[class*=hide], td[class*=hide], img[class*=hide], p[class*=hide], span[class*=hide] { display:none !important; }
table[class=h0], td[class=h0] { height: 0 !important; }
p[class=footer-content-left] { text-align: center !important; }
#headline p { font-size: 30px !important; }
.article-content, #left-sidebar{ -webkit-text-size-adjust: 90% !important; -ms-text-size-adjust: 90% !important; }
.header-content, .footer-content-left {-webkit-text-size-adjust: 80% !important; -ms-text-size-adjust: 80% !important;}
img { height: auto; line-height: 100%;}
 }
#outlook a { padding: 0; }
body { width: 100% !important; }
.ReadMsgBody { width: 100%; }
.ExternalClass { width: 100%; display:block !important; }
body { background-color: #c7c7c7; margin: 0; padding: 0; }
img { outline: none; text-decoration: none; display: block;}
br, strong br, b br, em br, i br { line-height:100%; }
h1, h2, h3, h4, h5, h6 { line-height: 100% !important; -webkit-font-smoothing: antialiased; }
h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: blue !important; }
h1 a:active, h2 a:active,  h3 a:active, h4 a:active, h5 a:active, h6 a:active {	color: red !important; }
h1 a:visited, h2 a:visited,  h3 a:visited, h4 a:visited, h5 a:visited, h6 a:visited { color: purple !important; }

table td, table tr { border-collapse: collapse; }
.yshortcuts, .yshortcuts a, .yshortcuts a:link,.yshortcuts a:visited, .yshortcuts a:hover, .yshortcuts a span {
color: black; text-decoration: none !important; border-bottom: none !important; background: none !important;
}
code {
  white-space: normal;
  word-break: break-all;
}
#background-table { background-color: #c7c7c7; }
#top-bar { border-radius:6px 6px 0px 0px; -moz-border-radius: 6px 6px 0px 0px; -webkit-border-radius:6px 6px 0px 0px; -webkit-font-smoothing: antialiased; background-color: #2e2e2e; color: #d1d1d1; }
#top-bar a { font-weight: bold; color: #eeeeee; text-decoration: none;}
#footer { border-radius:0px 0px 6px 6px; -moz-border-radius: 0px 0px 6px 6px; -webkit-border-radius:0px 0px 6px 6px; -webkit-font-smoothing: antialiased; }
body, td {  }
.header-content, .footer-content-left, .footer-content-right { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; }
.header-content { font-size: 12px; color: #d1d1d1; }
.header-content a { font-weight: bold; color: #eeeeee; text-decoration: none; }
#headline p {color: #f2f2f2;font-size: 36px;text-align: center;margin-top: 0px;margin-bottom: 30px;}
#headline p a { color: #f2f2f2; text-decoration: none; }
.article-title { font-size: 18px; line-height:24px; color: #b0b0b0; font-weight:bold; margin-top:0px; margin-bottom:18px;  }
.article-title a { color: #b0b0b0; text-decoration: none; }
.article-title.with-meta {margin-bottom: 0;}
.article-meta { font-size: 13px; line-height: 20px; color: #ccc; font-weight: bold; margin-top: 0;}
.article-content { font-size: 13px; line-height: 18px; color: #444444; margin-top: 0px; margin-bottom: 18px;  }
.article-content a { color: #2f82de; font-weight:bold; text-decoration:none; }
.article-content img { max-width: 100% }
.article-content ol, .article-content ul { margin-top:0px; margin-bottom:18px; margin-left:19px; padding:0; }
.article-content li { font-size: 13px; line-height: 18px; color: #444444; }
.article-content li a { color: #2f82de; text-decoration:underline; }
.article-content p {margin-bottom: 15px;}
.footer-content-left { font-size: 12px; line-height: 15px; color: #888888; margin-top: 0px; margin-bottom: 15px; }
.footer-content-left a { color: #eeeeee; font-weight: bold; text-decoration: none; }
.footer-content-right { font-size: 11px; line-height: 16px; color: #888888; margin-top: 0px; margin-bottom: 15px; }
.footer-content-right a { color: #eeeeee; font-weight: bold; text-decoration: none; }
#footer { background-color: #2b2b2b; color: #888888; }
#footer a { color: #eeeeee; text-decoration: none; font-weight: bold; }
#permission-reminder { white-space: normal; }
#street-address { color: #ffffff; white-space: normal; }
body,td,th {
	font-family: "微软雅黑", "黑体", sans-serif;
}
</style>
<!--[if gte mso 9]>
<style _tmplitem="4903" >
.article-content ol, .article-content ul {
   margin: 0 0 0 24px !important;
   padding: 0 !important;
   list-style-position: inside !important;
}
</style>
<![endif]--><meta name="robots" content="noindex,nofollow"></meta>
<meta property="og:title" content="Aimozhen"></meta>
</head><body style="width:100% !important;background-color:#c7c7c7;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" ><table width="100%" cellpadding="0" cellspacing="0" border="0" id="background-table" style="background-color:#c7c7c7;" >
	<tbody><tr style="border-collapse:collapse;" >
		<td align="center" bgcolor="#c7c7c7" style="border-collapse:collapse;" >
        	<table class="w640"  width="640" cellpadding="0" cellspacing="0" border="0" style="margin-top:0;margin-bottom:0;margin-right:10px;margin-left:10px;" >
            	<tbody><tr style="border-collapse:collapse;" ><td class="w640" width="640" height="20" style="border-collapse:collapse;" ></td></tr>

            	<tr style="border-collapse:collapse;" >
                	<td class="w640" width="640" style="border-collapse:collapse;" >
                        <table id="top-bar" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#404040" style="border-radius:6px 6px 0px 0px;-moz-border-radius:6px 6px 0px 0px;-webkit-border-radius:6px 6px 0px 0px;-webkit-font-smoothing:antialiased;background-color:#2e2e2e;color:#d1d1d1;" >
    <tbody><tr style="border-collapse:collapse;" >
        <td class="w15" width="15" style="border-collapse:collapse;" ></td>
        <td class="w325" width="350" valign="middle" align="left" style="border-collapse:collapse;" >
            <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr style="border-collapse:collapse;" ><td class="w325" width="350" height="8" style="border-collapse:collapse;" ></td></tr>
            </tbody></table>
            <div class="header-content" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-size:12px;color:#d1d1d1;" ><a href="http://aimozhen.com/" target="_blank" style="font-weight:bold;color:#eeeeee;text-decoration:none;" >艾墨镇</a>&nbsp;&nbsp;|&nbsp; <a href="http://e.weibo.com/aimozhen" target="_blank" style="font-weight:bold;color:#eeeeee;text-decoration:none;" lang="zh-CHS" >新浪微博</a>&nbsp;&nbsp;|&nbsp; <a href="http://animetaste.org/" target="_blank" style="font-weight:bold;color:#eeeeee;text-decoration:none;" >AT.org</a></div>
            <table class="w325" width="350" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr style="border-collapse:collapse;" ><td class="w325" width="350" height="8" style="border-collapse:collapse;" ></td></tr>
            </tbody></table>
        </td>
        <td class="w30" width="30" style="border-collapse:collapse;" ></td>
        <td class="w255" width="255" valign="middle" align="right" style="border-collapse:collapse;" >
            <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr style="border-collapse:collapse;" ><td class="w255" width="255" height="8" style="border-collapse:collapse;" ></td></tr>
            </tbody></table>
            <table cellpadding="0" cellspacing="0" border="0">
    <tbody><tr style="border-collapse:collapse;" >



    </tr>
</tbody></table>
            <table class="w255" width="255" cellpadding="0" cellspacing="0" border="0">
                <tbody><tr style="border-collapse:collapse;" ><td class="w255" width="255" height="8" style="border-collapse:collapse;" ></td></tr>
            </tbody></table>
        </td>
        <td class="w15" width="15" style="border-collapse:collapse;" ></td>
    </tr>
</tbody></table>

                    </td>
                </tr>
                <tr style="border-collapse:collapse;" >
                <td id="header" class="w640" width="640" align="center" bgcolor="#404040" style="border-collapse:collapse;" >

    <div align="center" style="text-align:center;" >
        <a href="http://aimozhen.com/"><img id="customHeaderImage" label="Header Image" width="640" src="http://www.aimozhen.com/Public/images/email_header.jpg" class="w640" border="0" align="top" style="display:inline;outline-style:none;text-decoration:none;" /></a>
    </div>


</td>
                </tr>

                <tr style="border-collapse:collapse;" ><td class="w640" width="640" height="30" bgcolor="#ffffff" style="border-collapse:collapse;" ></td></tr>
                <tr id="simple-content-row" style="border-collapse:collapse;" ><td class="w640" width="640" bgcolor="#ffffff" style="border-collapse:collapse;" >
    <table class="w640" width="640" cellpadding="0" cellspacing="0" border="0">
        <tbody><tr style="border-collapse:collapse;" >
            <td class="w30" width="30" style="border-collapse:collapse;" ></td>
            <td class="w580" width="580" style="border-collapse:collapse;" >

                        <table class="w580" width="580" cellpadding="0" cellspacing="0" border="0">
                            <tbody><tr style="border-collapse:collapse;" >
                                <td class="w580" width="580" style="border-collapse:collapse;" >
                                    <p align="left" class="article-title" style="font-size:18px;line-height:24px;color:#b0b0b0;font-weight:bold;margin-top:0px;margin-bottom:18px;" >$this->title</p>
                                    <div align="left" class="article-content" style="font-size:13px;line-height:18px;color:#444444;margin-top:0px;margin-bottom:18px;" >
                                        <p style="margin-bottom:15px;" >
	$this->content</p>
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-collapse:collapse;" ><td class="w580" width="580" height="10" style="border-collapse:collapse;" ></td></tr>
                        </tbody></table>

            </td>
            <td class="w30" width="30" style="border-collapse:collapse;" ></td>
        </tr>
    </tbody></table>
</td></tr>
                <tr style="border-collapse:collapse;" ><td class="w640" width="640" height="15" bgcolor="#ffffff" style="border-collapse:collapse;" ></td></tr>

                <tr style="border-collapse:collapse;" >
                <td class="w640" width="640" style="border-collapse:collapse;" >
    <table id="footer" class="w640" width="640" cellpadding="0" cellspacing="0" border="0" bgcolor="#2b2b2b" style="border-radius:0px 0px 6px 6px;-moz-border-radius:0px 0px 6px 6px;-webkit-border-radius:0px 0px 6px 6px;-webkit-font-smoothing:antialiased;background-color:#2b2b2b;color:#888888;" >
        <tbody><tr style="border-collapse:collapse;" ><td class="w30" width="30" style="border-collapse:collapse;" ></td><td class="w580 h0" width="360" height="30" style="border-collapse:collapse;" ></td><td class="w0" width="60" style="border-collapse:collapse;" ></td><td class="w0" width="160" style="border-collapse:collapse;" ></td><td class="w30" width="30" style="border-collapse:collapse;" ></td></tr>
        <tr style="border-collapse:collapse;" >
            <td class="w30" width="30" style="border-collapse:collapse;" ></td>
            <td class="w580" width="360" valign="top" style="border-collapse:collapse;" >
            <span class="hide"><p id="permission-reminder" align="left" class="footer-content-left" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-size:12px;line-height:15px;color:#888888;margin-top:0px;margin-bottom:15px;white-space:normal;" ><span>艾墨镇 分享动画 分享精彩</span></p></span>
            <p align="left" class="footer-content-left" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-size:12px;line-height:15px;color:#888888;margin-top:0px;margin-bottom:15px;" ><a href="http://aimozhen.com/" target="_blank" style="color:#eeeeee;text-decoration:none;font-weight:bold;" lang="zh-CHS" >艾墨镇</a> |<a href="http://e.weibo.com/aimozhen" target="_blank" style="font-weight:bold;color:#eeeeee;text-decoration:none;" lang="zh-CHS" xml:lang="zh-CHS" > 新浪微博 </a>| <a href="http://animetaste.org/" target="_blank" style="font-weight:bold;color:#eeeeee;text-decoration:none;" >AT.org</a></p>
            </td>
            <td class="hide w0" width="60" style="border-collapse:collapse;" ></td>
            <td class="hide w0" width="160" valign="top" style="border-collapse:collapse;" >
            <p id="street-address" align="right" class="footer-content-right" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;font-size:11px;line-height:16px;margin-top:0px;margin-bottom:15px;color:#ffffff;white-space:normal;" ><span>AIMOZHEN.COM</span></p>
            </td>
            <td class="w30" width="30" style="border-collapse:collapse;" ></td>
        </tr>
        <tr style="border-collapse:collapse;" ><td class="w30" width="30" style="border-collapse:collapse;" ></td><td class="w580 h0" width="360" height="15" style="border-collapse:collapse;" ></td><td class="w0" width="60" style="border-collapse:collapse;" ></td><td class="w0" width="160" style="border-collapse:collapse;" ></td><td class="w30" width="30" style="border-collapse:collapse;" ></td></tr>
    </tbody></table>
</td>
                </tr>
                <tr style="border-collapse:collapse;" >
                  <td class="w640" width="640" height="60" style="border-collapse: collapse; font-size: 9px; color: #808080;" >* 上方焦点图版权归作者所有，如果你是版权所有者请与我们联系</td></tr>
            </tbody></table>
        </td>
	</tr>
</tbody></table></body></html>


EOF;
	}


}
?>