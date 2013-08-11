<?php if (!defined('THINK_PATH')) exit(); $visitor = CommonAction::$user; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html xmlns:wb=“http://open.weibo.com/wb”>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

<head>
<meta charset="utf-8">
<title>艾墨镇，分享视频，创造梦想</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="AIMOZHEN 艾墨镇 分享动画 分享精彩">
<meta name="author" content="艾墨镇,aimozhen">
<meta name="keywords" content="aimozhen,艾墨镇,动画,animetaste,独立动画,视频,微电影,V电影,短片,原创,animation,动漫"/>
<meta property="wb:webmaster" content="dbd6a845d21f945c"/>
<link rel="shortcut icon" href="__PUBLIC__/favicon.ico">
<!-- CSS -->
<link href="__PUBLIC__/media/css/bootstrap.min.css?t=20130724" rel="stylesheet">
<link href="__PUBLIC__/media/css/bootstrap-responsive.min.css?t=20130724" rel="stylesheet">
<link href="http://amzstatic.b0.upaiyun.com/media/css/bootstrap-editable.css" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<link href="__PUBLIC__/media/css/bootstrap-ie.css" rel="stylesheet">
<![endif]-->

<script src="http://libs.baidu.com/jquery/1.8.3/jquery.min.js"></script>
<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=2517727821" type="text/javascript" charset="utf-8"></script>

</head>

  <body background="__PUBLIC__/images/web_bg.jpg" style="background-size:70px ">

    <div class="navbar navbar-inverse navbar-fixed-top" style="box-shadow: 0px 1px 3px #b2b2b2 ;">
      <div class="navbar-inner">
		<div class="container" style="padding-top:2px;">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
     		<!-- 左侧菜单栏 -->
            <div style="float:left; margin:7px 10px 0 0;width:103px;height:23px;}"><a href="/"><img src="__PUBLIC__/images/logo@2x.png"__PUBLIC__/></a></div>
            <div class="nav-collapse collapse">
     		<ul class="nav ">
              <li><a href="/">发现</a></li>
              <li><a href="/collection/">精彩选辑</a></li>
              <li><a href="/page/issue/">反馈</a></li>
              </ul>

            
			<ul class="nav nav-pills pull-right">
            	<!-- 头像模块 -->
                <?php if($visitor): ?><li class="dropdown" >
                    <a style="padding:5px 10px 5px 5px;" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" href="#"><img style="width:24px; height:24px" src="" />
                    <b class="caret"></b> </a>
                      <ul class="dropdown-menu">
                        <li class="nav-header"><?php echo ($visitor["username"]); ?></li>
                        <li><a href="/home/videos/"><i class="icon-film"></i> 我分享的</a></li>
                        <li><a href="/home/likes/"><i class="icon-heart"></i> 我收藏的</a></li>
                        <li><a href="/home/following/"><i class="icon-star"></i> 我关注的</a></li>
                        <li><a data-toggle="modal" href="#invite"><i class="icon-gift"></i> 邀请朋友</a></li>
                        <li><a href="/home/settings/"><i class="icon-cog"></i> 修改资料</a></li>
                        <li><a href="/logout.php"><i class="icon-off"></i> 退出</a></li>
                      </ul>
				</li>
                <?php else: ?>
				<li><a href="#regFront" data-toggle="modal">注册</a></li>
                <li><a href="#loginFront" data-toggle="modal">登录</a></li><?php endif; ?>
                                
                <!-- 搜索 -->
				<li style="margin:0 15px 0 10px;">
					<form class="navbar-search pull-left" action="/ajax/search.php" method="POST">
						<input type="text" class="search-query" id="search" name="search" placeholder="Search...">
                    </form>
				</li>
                
                <!-- 分享 -->
                <li style="margin:-1px 17px 0 0;">
                	<?php if($visitor): ?><button href="#shareFront" class="btn btn-red" type="button" data-toggle="modal">✚ 分享视频</button>
                    <?php else: ?>
                    <button href="#loginFront" class="btn btn-red" type="button" data-toggle="modal">✚ 分享视频</button><?php endif; ?>
				</li>   
                    
			 </ul>
             
             </div>
		 </div><!--/总菜单 -->
      </div>
      <div style="background-image:url(__PUBLIC__/images/bgline.png); background-repeat:repeat-x; height:2px"></div>
    </div>
		<div class="container" style="margin:30px auto 20px auto">
	
		  <div class="row">
		  <div class="span11 shadow" style="width:990px"> 
		  <div id="title" style="padding:20px;">
			<span style="color: #2C2C2C; font-size: 18px; font-weight: bold;">欢迎来到艾墨镇！</span><br />
			<span style="color: #7F7F7F;">填写居住证，永久有效无需暂住^_^</span><br />
			<div class="hr2"></div>
		  </div>
		  <!-- 编辑区域--> 
		  <div class="span6" style="margin-left:0;padding:0 0 0 20px;"> 
		  
	
		  <form class="form-horizontal" id="reg" action="<?php echo U('User/Member/RegisterVerify');?>" method="POST">
		  <input type="hidden" name="hidden" value="<?php echo (md5($regemail)); ?>" />
					<div class="control-group" id="namegroup">
						<label class="control-label2" for="name">昵称 </label>
						<div class="controls2">
							<input type="text" class="input-xlarge" id="name" name="name" placeholder="好名字是好生活的开始~">
							 <span class="help-inline" id="nameInfo"></span>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label2" for="input01">Email </label>
						<div class="controls2">
							<input class="input-xlarge" id="email" name="email" type="text" readonly value="<?php echo ($regemail); ?>" />
						</div>
					</div>
					<div class="control-group" id="pass1group">
						<label class="control-label2" for="pass1">密码 </label>
						<div class="controls2">
							<input class="input-xlarge" type="password" id="pass1" name="pass1" />
							<span class="help-inline" id="pass1Info"></span>
						</div>
					</div>
					<div class="control-group" id="pass2group">
						<label class="control-label2" for="pass2">重复 </label>
						<div class="controls2">
							<input class="input-xlarge" type="password" id="pass2" name='pass2' />
							<span class="help-inline" id="pass2Info"></span>
						</div>
					</div>
				   
		  <div id="title" style=" padding-bottom:20px;">
			<span style="color: #7F7F7F; font-weight: bold;">如果有邀请码请填写在下方（选填）</span>
			<div class="hr2"></div>
		  </div>
					<div class="control-group">
						<label class="control-label2" for="input01">邀请 </label>
						<div class="controls2">
							<input class="input-xlarge" id="invitecode" name="invitecode" type="text" />
						</div>
					</div> 
				  <!-- <div class="control-group">
						<label class="control-label2" for="input01" >微博 </label>
						<div class="controls2">
							<input placeholder="http://weibo.com/你的名字" class="input-xlarge" id="exterweibo" name="exterweibo" type="text" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label2" for="input01">博客 </label>
						<div class="controls2">
							<input class="input-xlarge" id="exterblog" name="exterblog" type="text" />
						</div>
					</div>-->
					
					<div style="margin:10px 0 0 60px;">
						<input id="send" type="submit" class="btn btn-red" value="恩，就这样吧！" />
						
					</div>
			</form>
			</div>
			<!-- /编辑区域-->
		  </div>
		  
		  </div>
		</div> <!-- /上方 -->
		<script type="text/javascript"> $(function(){ vRegForm();}); </script>	

﻿<a id="gotop" href="#">   
  <span>▲<strong>TOP</strong></span> 
</a>
      <div id="footer" class="container" style="text-align: center; font-size: 12px; color:#C0C0C0">
        <p>&copy; <a href="http://animetaste.org/" target="_blank">AnimeTaste.org</a> · <a href="/page/about/" target="_blank">About</a> ·  <a href="mailto:admin@aimozhen.com" class="Email">Contact</a> · Made with ❤ in Shanghai · Thanks <a href="http://twitter.github.com/bootstrap/" class="Bootstrap">Bootstrap</a> · <a href="http://www.miibeian.gov.cn" target="_blank">沪ICP备13003160号</a></p>
        <p>&nbsp;</p>
</div>

     <!-- /下方     <a id="issue" href="/page/issue/">   
  <span>用户<br />反馈</span> 
</a>
-->

    <!-- javascript ================================================== -->
    <script src="__PUBLIC__/media/js/bootstrap.min.js?t=20130729"></script>
    <script src="__PUBLIC__/media/js/amz.js?t=20130724"></script>
    <script src="http://amzstatic.b0.upaiyun.com/media/js/bootstrap-editable.min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/media/messenger/js/underscore-min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/media/messenger/js/backbone-min.js"></script>
	<script type="text/javascript" src="__PUBLIC__/media/messenger/js/messenger.min.js"></script>
    <script type="text/javascript" src="__PUBLIC__/media/messenger/js/messenger-theme-future.js"></script>
    
	<link type="text/css" rel="stylesheet" href="/media/messenger/css/messenger.css"/>
    <link type="text/css" rel="stylesheet" href="/media/messenger/css/messenger-theme-future.css"/>
    <script type="text/javascript"> $(function(){ 


   }); </script>
    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=652974" ></script>
	<script type="text/javascript" id="bdshell_js"></script>
	<script type="text/javascript">
	var bds_config = {'wbUid':3163946864,'snsKey':{'tsina':'2517727821'}};
	document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
	</script>

        
    

<div id="loginFront" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" style="color: #FFFFFF" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>登录</h3>
  </div>
    <div class="modal-body">
    <form action="<?php echo U('User/Member/FrontLoginVerify');?>" method="POST">
        <div class="modal-body">
				邮件&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="email" /> &nbsp;&nbsp; <a href="#reg" data-toggle="modal" style="font-size:80%">没有账号？</a> <br />
				密码&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" name="password" /> &nbsp;&nbsp; <a href="#forget" data-toggle="modal" style="font-size:80%">找回密码</a> <br /></div>
            &nbsp;&nbsp;<input type="submit" value="登录" class="btn btn-red"/>
        </div>
    </form>
    </div>
</div>

<div id="regFront" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" style="color: #FFFFFF" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>注册</h3>
  </div>
    <div class="modal-body">
    <form action="<?php echo U('User/Member/Register');?>" id="regFormFront" method="POST" >
        <div class="modal-body">
            <div class="control-group" id="emailgroup">
            <input type="text" name="email" id="regemail" class="input-block-level share-video" placeholder="电子邮件地址"/>
            <span class="help-inline" id="emailInfo"></span>
			<div style="font-size: 14px; color: #919191; margin: 10px 0 20px 0;"><strong>欢迎来到艾墨镇 请在上方填写你常用的邮箱</strong></div>
        		</div>
             <input id="send" type="submit" value="下一步" data-loading-text="读取中..." role="button"  class="btn btn-red"/>

        </div>
    </form>
    </div>
</div>

<div id="forget" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" style="color: #FFFFFF" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>找回密码</h3>
  </div>
    <div class="modal-body">
    <form action="/ajax/forget/validate.php" method="POST">
        <div class="modal-body">
   		  <p>请填写用来登录的邮件地址 我们将向你发送一份身份确认邮件<br />
			<span style="font-size: 80%">如果提交多次仍没有收到邮件请与我们联系 admin@aimozhen.com</span></p>
			<input type="text" name="email" placeholder="电子邮件地址"/> <br />
            <input type="submit" value="确认" class="btn btn-red"/>
        </div>
    </form>
    </div>
</div>

<div id="shareFront" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" style="color: #FFFFFF" aria-hidden="true" data-dismiss="modal">×</button>
    <h3>分享视频</h3>
  </div>
  <div class="modal-body">
    <form action="/ajax/post.php" id="shareVideoFront" method="POST" >
        <div class="modal-body">
            <div class="control-group" id="urlgroup">
            <input type="text" name="url" id="url" class="input-block-level share-video" placeholder="请输入你想要分享的视频页面地址"/>
            <span class="help-inline" id="urlInfo"></span>
			<div style="font-size: 14px; color: #919191; margin: 10px 0 20px 0;"><strong>支持优酷，土豆，音悦台，新浪博客，乐视，56，酷6等视频网站<br />艾墨镇的氛围和你息息相关，希望你能给我们带来更多精彩的分享</strong></div>
        		</div>
             <input id="send" type="submit" value="发布" data-loading-text="读取中..." role="button"  class="btn btn-red"/>

        </div>
    </form>
    <script type="text/javascript"> $(function(){ vShareVideoFront(); vRegFormFront();}); </script>
    
  </div></div>  
  
  
<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F0123a2f162a7829ef691d1b9702258e3' type='text/javascript'%3E%3C/script%3E"));


var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-11082147-7']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

</body>
</html>