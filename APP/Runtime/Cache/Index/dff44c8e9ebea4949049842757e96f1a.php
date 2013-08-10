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

        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2162/" target="_blank" title="Free Wheel" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g4.ykimg.com/1100401F46520505EBAFA601DFD2F0C92A50D8-8AF2-6EC9-24FB-9C3E0932C60D') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2162/" target="_blank" title="Free Wheel" >Free Wheel</a></div>
    			<div class="post-explain">《自由轮滑》再卑微的人也有值得骄傲的一刻！</div>
				<div class="post-infor">观看39次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-10 10:47</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2161/" target="_blank" title="世界经典动画短片合集【Allegretto】1936" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g1.ykimg.com/1100641F464C801BB8BB8D0082B4ADF4DF59DA-6E23-8731-607C-151B757866DF') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2161/" target="_blank" title="世界经典动画短片合集【Allegretto】1936" >世界经典动画短片合集【Allegretto】1936</a></div>
    			<div class="post-explain">费钦格的抽象动画《快板》，创作于1936年，在那个年代做出如此精彩的作品，佩服。</div>
				<div class="post-infor">观看23次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/5/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1731582343/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/5/" title="tea86">tea86</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 20:53</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 		<!-- 新用户-->
        ﻿<div class="span3 shadow amzvideo" style="height:318px; padding:10px; margin-bottom:20px; margin-right:3px">
          <span style="font-size: 14px; color: #2A2A2A; font-weight: bold;">新入创作者:</span>
			<div style="margin:10px -10px 15px -10px;" class="hr1"></div>	
            
                      <div class="post-author"  style=" height:50px; margin:0 0 20px 5px">
                <div class="avatar"  style="height:50px; width:50px;"><a href="/user/977/" ><img width="50" height="50" src="http://tp1.sinaimg.cn/2055246811/180/0/1" /></a></div>
                <div id="post-detailed" class="float-left" style="margin-left:15px;">
                    <div id="post-author" class="ellipsis" style="margin-top:5px;width:120px;font-size:14px;line-height:16px;"><a href="/user/977/" title="CGE-Rais" style="color: #2d8fcc">CGE-Rais</a> </div>
                                        <div style="color: # 333;font-size:11px;">已入住2天</div> 
            	</div>
            </div>
	            <div class="post-author"  style=" height:50px; margin:0 0 20px 5px">
                <div class="avatar"  style="height:50px; width:50px;"><a href="/user/965/" ><img width="50" height="50" src="http://tp1.sinaimg.cn/2307344154/180/0/1" /></a></div>
                <div id="post-detailed" class="float-left" style="margin-left:15px;">
                    <div id="post-author" class="ellipsis" style="margin-top:5px;width:120px;font-size:14px;line-height:16px;"><a href="/user/965/" title="F_Seven" style="color: #2d8fcc">F_Seven</a> </div>
                                        <div style="color: # 333;font-size:11px;">已入住3天</div> 
            	</div>
            </div>
	            <div class="post-author"  style=" height:50px; margin:0 0 20px 5px">
                <div class="avatar"  style="height:50px; width:50px;"><a href="/user/928/" ><img width="50" height="50" src="http://tp1.sinaimg.cn/1768421081/180/0/1" /></a></div>
                <div id="post-detailed" class="float-left" style="margin-left:15px;">
                    <div id="post-author" class="ellipsis" style="margin-top:5px;width:120px;font-size:14px;line-height:16px;"><a href="/user/928/" title="Tong" style="color: #2d8fcc">Tong</a> </div>
                                        <div style="color: # 333;font-size:11px;">已入住8天</div> 
            	</div>
            </div>
	            <div class="post-author"  style=" height:50px; margin:0 0 20px 5px">
                <div class="avatar"  style="height:50px; width:50px;"><a href="/user/917/" ><img width="50" height="50" src="http://tp1.sinaimg.cn/2434990545/180/0/1" /></a></div>
                <div id="post-detailed" class="float-left" style="margin-left:15px;">
                    <div id="post-author" class="ellipsis" style="margin-top:5px;width:120px;font-size:14px;line-height:16px;"><a href="/user/917/" title="jiansfantasy" style="color: #2d8fcc">jiansfantasy</a> </div>
                                        <div style="color: # 333;font-size:11px;">已入住9天</div> 
            	</div>
            </div>
	            

        </div>
        <!-- /新用户-->
        
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2160/" target="_blank" title="hamburg hotel" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g4.ykimg.com/1100641F465204759F203004E1ADB8B3C24362-FFEF-0402-40F1-6C6EFE8CEF83') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2160/" target="_blank" title="hamburg hotel" >hamburg hotel</a></div>
    			<div class="post-explain">导演Dylan Kendle & Joost Korngold为汉堡酒店制作的短片。风格灰常抽象，构</div>
				<div class="post-infor">观看72次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/52/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1904157703/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/52/" title="樟_脳魭">樟_脳魭</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 13:46</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2159/" target="_blank" title="The Fisherman and Fly" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g1.ykimg.com/1100401F4652046B8443E401DFD2F0D37BC64E-3B33-6C32-E59E-DD3C7E5C44C7') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2159/" target="_blank" title="The Fisherman and Fly" >The Fisherman and Fly</a></div>
    			<div class="post-explain">一部轻动画，讲了一个渔夫、一只苍蝇和一个软木塞子的故事。但结果似乎是非常出人意料的。</div>
				<div class="post-infor">观看86次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 12:14</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2158/" target="_blank" title="5分钟看尽64部恐怖片" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://v157.56img.com/images/8/24/iccidd12i56olo56i56.com_133722194413hd_b.jpg') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2158/" target="_blank" title="5分钟看尽64部恐怖片" >5分钟看尽64部恐怖片</a></div>
    			<div class="post-explain">恐怖来袭！5分钟看尽64部恐怖片！看看你能数出多少部来！！！ 人生不找个伴侣陪自己看几场恐怖片实在是</div>
				<div class="post-infor">观看48次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/855/" ><img width="32" height="32" src="http://www.gravatar.com/avatar/e18094f1a0883f607abef77ebf767866?d=http%3A%2F%2Fwww.aimozhen.com%2Fimages%2Famzlogo.jpg&s=32" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/855/" title="Daweies">Daweies</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 10:18</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2157/" target="_blank" title="雅虎将推出新LOGO" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g4.ykimg.com/1100641F465203584B64800664C626AC8DF6AB-35FD-6D6C-7425-724D597B3DC5') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2157/" target="_blank" title="雅虎将推出新LOGO" >雅虎将推出新LOGO</a></div>
    			<div class="post-explain">雅虎将于9月5日推出新LOGO，将继续保留感叹号和紫色系</div>
				<div class="post-infor">观看65次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/5/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1731582343/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/5/" title="tea86">tea86</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 10:02</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2156/" target="_blank" title="Cornelis" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g2.ykimg.com/1100641F4651FE3545C72401DFD2F00D574C09-7CC7-1EE0-02EF-A7C1C2BA6ADB') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2156/" target="_blank" title="Cornelis" >Cornelis</a></div>
    			<div class="post-explain">日本动画中对于动作的夸张的描绘有时候会让人匪夷所思。中田彩郁的这部动画中就着力表现了这一点。在虚幻的</div>
				<div class="post-infor">观看57次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/3/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1644839342/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/3/" title="Plidezus">Plidezus</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 8:37</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2155/" target="_blank" title="ESPERO？(HOPE？)" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g3.ykimg.com/1100641F4652026C36514301DFD2F02A6BDE2F-2F20-CA47-076F-1B1F85CC82D5') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2155/" target="_blank" title="ESPERO？(HOPE？)" >ESPERO？(HOPE？)</a></div>
    			<div class="post-explain">以环保为题材的动画作品已经不计其数了，但这部作品却以它独特的叙述方式让我们眼前一亮。</div>
				<div class="post-infor">观看40次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-09 2:08</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2154/" target="_blank" title="小S 三星Samsung GALAXY S4  Sorry Potter篇" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g4.ykimg.com/1100641F4651FF16FB1E0C020866FB9074E635-4ACA-3266-809A-209CC474E942') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2154/" target="_blank" title="小S 三星Samsung GALAXY S4  Sorry Potter篇" >小S 三星Samsung GALAXY S4  Sorry Potter篇</a></div>
    			<div class="post-explain">三星日前针对旗舰级新机Galaxy S4拍摄了几则十分搞笑的商业广告片。这一次，三星并没有通过惯用的</div>
				<div class="post-infor">观看42次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-08 21:56</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2153/" target="_blank" title="阮经天 三星Samsung GALAXY S4  Life of Tien篇" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g2.ykimg.com/1100641F4651FF1A99037B020866FB86383A3E-E7A4-F3AA-ED72-265CA0FC1A0A') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2153/" target="_blank" title="阮经天 三星Samsung GALAXY S4  Life of Tien篇" >阮经天 三星Samsung GALAXY S4  Life of Tien篇</a></div>
    			<div class="post-explain">三星日前针对旗舰级新机Galaxy S4拍摄了几则十分搞笑的商业广告片。这一次，三星并没有通过惯用的</div>
				<div class="post-infor">观看52次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-08 21:55</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2152/" target="_blank" title="Nokia Lumia 1020发布会宣传视频" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g3.ykimg.com/1100641F4652036E0E176C03735390F3D927AD-2D2B-10C4-1B0D-1035E45208F0') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2152/" target="_blank" title="Nokia Lumia 1020发布会宣传视频" >Nokia Lumia 1020发布会宣传视频</a></div>
    			<div class="post-explain">虽然不知撸妹儿1020的成像质量到底有多好，但已经跪倒在这牛逼的宣传片下了！</div>
				<div class="post-infor">观看67次 0评论 2收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-08 20:54</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2151/" target="_blank" title="Madagascar: Carnet de Voyage" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://v165.56img.com/images/14/6/mjia56i56olo56i56.com_129839832785hd_b.jpg') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2151/" target="_blank" title="Madagascar: Carnet de Voyage" >Madagascar: Carnet de Voyage</a></div>
    			<div class="post-explain">马达加斯加:旅行日记 Madagascar: Carnet de Voyage 奥斯卡动画短片提名</div>
				<div class="post-infor">观看89次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/5/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1731582343/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/5/" title="tea86">tea86</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-08 19:55</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2150/" target="_blank" title="SpyFox" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g3.ykimg.com/1100401F4652025BC23EB001DFD2F0EA42C838-8D6D-DB6A-3886-E1C256859EE3') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2150/" target="_blank" title="SpyFox" >SpyFox</a></div>
    			<div class="post-explain">邪恶头目锤头鲨准备破坏世界，到了间谍狐出动的时间了！一部向早期谍战片致敬的动画，短短的几分钟内让你重</div>
				<div class="post-infor">观看73次 0评论 0收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/3/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1644839342/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/3/" title="Plidezus">Plidezus</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-08 8:25</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2149/" target="_blank" title="CUT 2013高清无码《驯服》预告片 性感 秒杀好莱坞" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g3.ykimg.com/1100641F4651FA70365E0F017C5F911B5C378A-072E-54A3-7CD1-AA92B9B2B685') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2149/" target="_blank" title="CUT 2013高清无码《驯服》预告片 性感 秒杀好莱坞" >CUT 2013高清无码《驯服》预告片 性感 秒杀好莱坞</a></div>
    			<div class="post-explain">虽然预告片只有短短的几十秒，但是整部短片画面工程浩大,以及超强的末世风格，已经足以让人感受到强烈的震</div>
				<div class="post-infor">观看84次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/965/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/2307344154/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/965/" title="F_Seven">F_Seven</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-07 16:03</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2148/" target="_blank" title="Zweizwei Guangzhou2012" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://v19.56img.com/images/6/11/r285492509i56olo56i56.com_135287779537hd_b.jpg') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2148/" target="_blank" title="Zweizwei Guangzhou2012" >Zweizwei Guangzhou2012</a></div>
    			<div class="post-explain">俄罗斯摄影大师Zweizwei拍广州</div>
				<div class="post-infor">观看72次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/855/" ><img width="32" height="32" src="http://www.gravatar.com/avatar/e18094f1a0883f607abef77ebf767866?d=http%3A%2F%2Fwww.aimozhen.com%2Fimages%2Famzlogo.jpg&s=32" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/855/" title="Daweies">Daweies</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-07 14:40</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2147/" target="_blank" title="Missing U" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g1.ykimg.com/1100401F465201161C4CFA01DFD2F092E34F18-15C1-013F-7A5E-A539D2E5D899') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2147/" target="_blank" title="Missing U" >Missing U</a></div>
    			<div class="post-explain">当我没了你，世界不再完整。</div>
				<div class="post-infor">观看61次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-07 10:07</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2145/" target="_blank" title="Hennessy VSOP 海阔天空" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g1.ykimg.com/1100641F4651A13E3C20490529BE694B823756-8C00-0D00-D9A3-C85F7D1C821C') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2145/" target="_blank" title="Hennessy VSOP 海阔天空" >Hennessy VSOP 海阔天空</a></div>
    			<div class="post-explain">作品之美 胜于言表</div>
				<div class="post-infor">观看96次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-07 6:29</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2144/" target="_blank" title="vimeo首页推荐动画短片《Contre temps》" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g2.ykimg.com/1100401F46520120DDC37508937AD7C74BF511-61F1-35DD-ED9C-E74ED19C1EEA') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2144/" target="_blank" title="vimeo首页推荐动画短片《Contre temps》" >vimeo首页推荐动画短片《Contre temps》</a></div>
    			<div class="post-explain">《Contre Temps》是一部精美的动画，由一个小团队制作，片中亮点是色彩对比鲜明，有一种梦幻的</div>
				<div class="post-infor">观看663次 2评论 3收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/32/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/2217214190/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/32/" title="Motionvdo">Motionvdo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-07 0:31</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2143/" target="_blank" title="THE BASIC of GOOD POSTURE" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g2.ykimg.com/1100401F4651FFDDFD9D2101DFD2F072936AF9-99EB-F484-71ED-7566ACDB11EC') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2143/" target="_blank" title="THE BASIC of GOOD POSTURE" >THE BASIC of GOOD POSTURE</a></div>
    			<div class="post-explain">《你会坐椅子吗？》作为现代人我们每天要做在椅子上办公做事很久，但你真的会做椅子么？你知道怎么坐椅子才</div>
				<div class="post-infor">观看80次 0评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/26/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/3015951233/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/26/" title="eZioPan">eZioPan</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-06 21:03</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2142/" target="_blank" title="Windows 1到Windows 8的广告" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g4.ykimg.com/1100641F4651AD6A836CB7059E49FEF777BA8C-5652-5236-1AD9-BC48DAD968E1') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2142/" target="_blank" title="Windows 1到Windows 8的广告" >Windows 1到Windows 8的广告</a></div>
    			<div class="post-explain">Window 1 真是998的开山鼻祖啊！XP的是所有里面制作最精良，最经典的！大爱！</div>
				<div class="post-infor">观看108次 1评论 1收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-06 20:59</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2141/" target="_blank" title="Apple WWDC2013开场视频 中文版" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g3.ykimg.com/1100641F4651FFADA6ABBD01DFD2F0ED42DA6A-BCED-785C-6347-EF8EF708BC87') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2141/" target="_blank" title="Apple WWDC2013开场视频 中文版" >Apple WWDC2013开场视频 中文版</a></div>
    			<div class="post-explain">非常的Jony lve设计元素。乔布斯的苹果令人尊敬，因为乔布斯从来都是无视其他的，专注自己想要做的</div>
				<div class="post-infor">观看225次 0评论 2收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-06 18:17</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
		
        ﻿<!-- 作品-->
<div class="span3 shadow amzvideo" style="height:318px;padding:10px; margin-bottom:20px; margin-right:2px">
	<div class="playbutton">
		<span>
			<a href="/video/2140/" target="_blank" title="宜家2014产品手册" >
				<div style=" width:210px; height:160px;background: url('/images/play.png') no-repeat center center;">&nbsp;
				</div>
			</a>
		</span>
	<div class="img-rounded post-image" style=" background: url('http://g2.ykimg.com/1100641F4651FB5BF1EFB5014CEC0E8B8958AE-B009-0DC8-B7FD-A3D55F6F89D9') no-repeat center center;background-size: 290px;background-color:#000000 ">
	</div>     					
</div>
                <div class="post-title"><a href="/video/2140/" target="_blank" title="宜家2014产品手册" >宜家2014产品手册</a></div>
    			<div class="post-explain">宜家2013年产品手册通过与App结合，利用AR技术令人们可以看到橱柜等内部构造。宜家2014产品手</div>
				<div class="post-infor">观看96次 0评论 2收藏</div>
                <div class="hr1"></div>
                <div class="post-author"  style=" margin-top:10px;">
                <div class="avatar"  style="height:32px; width:32px;"><a href="/user/4/" ><img width="32" height="32" src="http://tp1.sinaimg.cn/1573590751/180/0/1" /></a></div>
            <div id="post-detailed" class="float-left" style="margin-left:10px;line-height:12px">
                <div id="post-author" class="ellipsis" style="width:170px;font-size:12px;line-height:18px;"><a href="/user/4/" title="Gavin Foo">Gavin Foo</a> </div>
                <div style="color: #bbb;font-size:11px;">2013-8-06 17:43</div>
                	
            </div></div>
</div>
<!-- 作品 END--> 
				
      </div>
      
      
		<div class="row amznavigation">
            <div class="amznext" style="text-align:center">
                        <a href="/?amzpage=2">下一页</a> 
                        </div>
 		</div>
      
		<div id="realpagination" class="row" style=" margin-top:50px;display:none">
        <div class="pagination pagination-small pagination-centered">
                ﻿
<ul><li class='disabled'><a href='#'>首页</a></li><li class='disabled'><a href='#'>&laquo;</a></li><li class='active'><a href='#'>1</a></li><li><a href='/2'>2</a></li><li><a href='/3'>3</a></li><li><a href='/4'>4</a></li><li><a href='/5'>5</a></li><li><a href='/6'>6</a></li><li><a href='/7'>7</a></li><li><a href='/8'>8</a></li><li><a href='/9'>9</a></li><li><a href='/10'>10</a></li><li> <a href='/2'>&raquo;</a></li><li> <a href='/29'>尾页</a></li> </ul>&nbsp;&nbsp;<ul> <li><span class=disabled>当前1/29页</span></li> </ul>            </div>
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