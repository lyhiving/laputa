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
                    <a style="padding:5px 10px 5px 5px;" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" href="#"><img style="width:24px; height:24px" src="<?php echo ($visitor["avatar"]); ?>" />
                    <b class="caret"></b> </a>
                      <ul class="dropdown-menu">
                        <li class="nav-header"><?php echo ($visitor["username"]); ?></li>
                        <li><a href="/home/videos/"><i class="icon-film"></i> 我分享的</a></li>
                        <li><a href="/home/likes/"><i class="icon-heart"></i> 我收藏的</a></li>
                        <li><a href="/home/following/"><i class="icon-star"></i> 我关注的</a></li>
                        <li><a data-toggle="modal" href="#invite"><i class="icon-gift"></i> 邀请朋友</a></li>
                        <li><a href="/home/settings/"><i class="icon-cog"></i> 修改资料</a></li>
                        <li><a href="<?php echo U('User/Member/Logout');?>"><i class="icon-off"></i> 退出</a></li>
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
    ﻿	<div class="container" >

		<div id="tips" class="hide alert" style="margin:-20px 30px 40px 0px;font-size:12px;">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		Hi，欢迎来到艾墨镇，这是一个关于独立影像的小镇。期待你一起来分享更多的内容，<strong><a href="#reg" data-toggle="modal">点此入住</a></strong> 。
	</div>
    		<div style="width:100%; height:20px; ">
      
          <div style="color:#AAA; float:left;margin:-10px 0 0 0">
            <ul id="headerbar" style="margin-left:0px">
              <li class="active"><a href="/">最新</a></li>
              <li class="dropdown" > 
                <a class="dropdown-toggle" id="drop4" role="button" data-hover="dropdown" data-toggle="dropdown" href="#">最热 <b class="caret"></b></a>
                <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="/hot/view/">最多观看</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="/hot/comment/">最多评论</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="/hot/fav/">最多收藏</a></li>
                </ul>
              </li>
              <li ><a href="/verify/">创作人</a></li>
              <li ><a href="/discover/">随便看看</a></li>
              <li class="dropdown" > 
                <a class="dropdown-toggle" id="drop5" role="button" data-hover="dropdown" data-toggle="dropdown" href="#">分类 <b class="caret"></b></a>
                <ul id="menu3" class="dropdown-menu" role="menu" aria-labelledby="drop5">
                  				  <li><a href="/tag/2/">剧情短片 <span style="float:right; color:#ABABAB">(833)</span></a></li>
				  				  <li><a href="/tag/3/">MV <span style="float:right; color:#ABABAB">(261)</span></a></li>
				  				  <li><a href="/tag/4/">广告/宣传 <span style="float:right; color:#ABABAB">(465)</span></a></li>
				  				  <li><a href="/tag/5/">游戏CG <span style="float:right; color:#ABABAB">(27)</span></a></li>
				  				  <li><a href="/tag/6/">电视包装 <span style="float:right; color:#ABABAB">(78)</span></a></li>
				  				  <li><a href="/tag/7/">片头片尾 <span style="float:right; color:#ABABAB">(24)</span></a></li>
				  				  <li><a href="/tag/8/">ShowReel <span style="float:right; color:#ABABAB">(82)</span></a></li>
				  				  <li><a href="/tag/9/">预告/花絮 <span style="float:right; color:#ABABAB">(35)</span></a></li>
				  				  <li><a href="/tag/10/">纪录片 <span style="float:right; color:#ABABAB">(51)</span></a></li>
				  				  <li><a href="/tag/1/">归类无能 <span style="float:right; color:#ABABAB">(86)</span></a></li>
				                  </ul>
              </li>
            </ul> <!-- /tabs -->
          </div> 
        
        
		<div style="float:right;margin:-14px 0 0 10px"><wb:follow-button uid="3163946864" type="red_2" width="136" height="24" ></wb:follow-button></div>
				<div style="color:#AAA; float:right;margin:-14px 0 0 0">艾墨镇共有 <strong>1942</strong> 部作品</div>
		        
	</div>
    	<div class="hr2" style="margin:0 30px 15px 0;"></div>
        
		
	<div class="row amzcontent">
         
        <?php if(is_array($post)): foreach($post as $key=>$v): ?>﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/<?php echo ($v["id"]); ?>/" target="_blank" title="<?php echo ($v["title"]); ?>" >
				<div style=" width:210px; height:160px;background: url('__PUBLIC__/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style="background: url('<?php echo ($v["imageUrl"]); ?>') no-repeat center center;background-size: 290px;background-color:#000000">
	</div>     					
</div>
                <div class="post-title"><a href="/video/<?php echo ($v["id"]); ?>/" target="_blank" title="<?php echo ($v["title"]); ?>" ><?php echo ($v["title"]); ?></a></div>
    			<div class="post-explain"><?php echo ($v["description"]); ?></div>
				<div class="post-infor">观看<?php echo (intval($v["viewed"])); ?>次 <?php echo (intval($v["comment"])); ?>评论 <?php echo (intval($v["like"])); ?>收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/<?php echo ($v["id"]); ?>/" ><img width="32" height="32" src="<?php echo ($v["useravatar"]); ?>" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/<?php echo ($v["userid"]); ?>/" title="<?php echo ($v["username"]); ?>"><?php echo ($v["username"]); ?></a> </div>
                <div style="color: #bbb;font-size:11px;"><?php echo (date("Y-n-d G:i",$v["createdTime"])); ?></div>
                	
            </div></div>
</div>
<!-- 作品 END--><?php endforeach; endif; ?>

				
      </div>
      
      
		<div class="row amznavigation">
            <div class="amznext" style="text-align:center">
                        <?php echo ($page_next); ?>
                        </div>
 		</div>
      
		<div id="realpagination" class="row" style=" margin-top:50px;display:none">
        <div class="pagination pagination-small pagination-centered">
             <?php echo ($page_nav); ?>
            </div>
 		</div>

</div> <!-- /上方 -->

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