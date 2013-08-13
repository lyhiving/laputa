function setCookie(c_name,value,expiredays) {
	var exdate=new Date()
	exdate.setDate(exdate.getDate()+expiredays)
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
}

function getCookie(c_name) {
	if (document.cookie.length>0) {
		c_start = document.cookie.indexOf(c_name + "=")
		if (c_start != -1) { 
			c_start = c_start + c_name.length+1 
			c_end = document.cookie.indexOf(";",c_start)
			if (c_end == -1) c_end = document.cookie.length
			return unescape(document.cookie.substring(c_start,c_end))
		} 
	}
	return ""
}

$(function(){
	if (!getCookie('tips')) {
		$('#tips').show()
	}

	$('#tips .close').on('click', function(e){
		e.preventDefault()
		$('#tips').hide()
		setCookie('tips', 1, 2)
		
	})

});

$(function(){
    $("a.ajax").click(function(){
        $.get($(this).attr('href'), function(data){
            alert(data);
        })
        return false;
    });
});

// 验证码切换
function change_code(obj){
	$("#code").attr("src",verifyURL + '/' + Math.random());
	return false;
}

function gotopbutton(){
	jQuery(window).scroll(function(){  //只要窗口滚动,就触发下面代码 
		var scrollt = document.documentElement.scrollTop + document.body.scrollTop; //获取滚动后的高度 
		if( scrollt >200 ){  //判断滚动后高度超过200px,就显示  
			jQuery("#gotop").fadeIn(400); //淡出     
		}else{      
			jQuery("#gotop").stop().fadeOut(400); //如果返回或者没有超过,就淡入.必须加上stop()停止之前动画,否则会出现闪动   
		}
	});
	jQuery("#gotop").click(function(){ //当点击标签的时候,使用animate在200毫秒的时间内,滚到顶部
			jQuery("html,body").animate({scrollTop:"0px"},200);
	});
};


function playbutton(){
    jQuery(".playbutton").hover(function(){
        jQuery(this).find("span").fadeIn(200);
    },function(){
        jQuery(this).find("span").fadeOut(200);
    });
};

// 验证视频
function vShareVideoFront(){
	var form = $("#shareVideoFront");var url = $("#url");var urlgroup = $("#urlgroup");var urlInfo = $("#urlInfo");
	url.blur(validateUrl);url.keyup(validateUrl);
	form.submit(function(){
		if(validateUrl())
			return true
		else
			return false;
	});
	function validateUrl(){
		if(url.val().indexOf('youku')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自优酷视频 验证通过 请继续点击发布");
			return true;
		}
		if(url.val().indexOf('tudou')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自土豆视频 验证通过 请继续点击发布");
			return true;
		}

		if(url.val().indexOf('56.com')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自56视频 验证通过 请继续点击发布");
			return true;
		}

		if(url.val().indexOf('video.sina.com.cn')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自新浪博客 验证通过 请继续点击发布");
			return true;
		}
		if(url.val().indexOf('v.ku6.com/show')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自酷6视频 验证通过 请继续点击发布");
			return true;
		}
		if(url.val().indexOf('www.letv.com/ptv')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自乐视网站 验证通过 请继续点击发布");
			return true;
		}
		if(url.val().indexOf('www.yinyuetai.com/video/')>-1){
			urlgroup.removeClass("error");
			urlgroup.addClass("info");
			urlInfo.text("来自音悦台 验证通过 请继续点击发布");
			return true;
		}
		else{
			urlgroup.removeClass("info");
			urlgroup.addClass("error");
			urlInfo.text("不好意思 暂时不支持该网站的视频~");
			return false;

		}

	}
};

// 验证注册邮箱地址
function vRegFormFront(){
	var form = $("#regFormFront");var content = $("#regemail");var group = $("#emailgroup");var Info = $("#emailInfo");
	content.blur(validateContent);content.keyup(validateContent);
	form.submit(function(){
		if(validateContent())
			return true
		else
			return false;
	});
	function validateContent(){
		if(content.val().indexOf('@')>-1 && content.val().indexOf('.')>-1) {
			group.removeClass("error");
			group.addClass("info");
			Info.text("邮箱通过初步验证 请点击下一步继续");
			return true;
		}
		else{
			group.removeClass("info");
			group.addClass("error");
			Info.text("请输入标准的邮箱地址");
			return false;
		}

	}
};



function vRegForm(){
	var form = $("#reg");var name = $("#name");var namegroup = $("#namegroup");var nameInfo = $("#nameInfo");var pass1 = $("#pass1");var pass1group = $("#pass1group");var pass1Info = $("#pass1Info");var pass2 = $("#pass2");var pass2group = $("#pass2group");var pass2Info = $("#pass2Info");
	name.blur(validateName);pass1.blur(validatePass1);pass2.blur(validatePass2);
	name.keyup(validateName);pass1.keyup(validatePass1);pass2.keyup(validatePass2);
	form.submit(function(){
		if(validateName() & validatePass1() & validatePass2())
			return true
		else
			return false;
	});
	function validateName(){
		if(name.val().length < 4){
			namegroup.removeClass("info");
			namegroup.addClass("error");
			nameInfo.text("请不小少于四个字！");
			return false;
		}
		else{
			namegroup.removeClass("error");
			namegroup.addClass("info");
			nameInfo.text("响亮的名字！");
			return true;
		}
	}
	function validatePass1(){
		var a = $("#password1");
		var b = $("#password2");
		if(pass1.val().length <5){
			pass1group.addClass("error");
			pass1Info.text("请不小少于5个字符！");
			return false;
		}
		else{			
			pass1group.removeClass("error");
			pass1group.addClass("info");
			pass1Info.text("输入正确");
			validatePass2();
			return true;
		}
	}
	function validatePass2(){
		var a = $("#password1");
		var b = $("#password2");
		if( pass1.val() != pass2.val() ){
			pass2group.removeClass("info");
			pass2group.addClass("error");
			pass2Info.text("两个密码不相同！");
			return false;
		}
		else{
			pass2group.removeClass("error");
			pass2group.addClass("info");
			pass2Info.text("输入正确");
			return true;
		}
	}
};





// 加载视频
function iaspost(){
	jQuery.ias({
		container : '.amzcontent',
		item: '.amzvideo',
		pagination: '.amznavigation',
		next: '.amznext a',
		history: false ,
		noneleft: function(trigger) { jQuery("#realpagination").fadeIn(1200); },
		loaderDelay: 1200 ,
		triggerPageThreshold: 3 ,
		customTriggerProc: function(trigger) { jQuery("#realpagination").fadeIn(1200); },
		onRenderComplete: function() { playbutton();},
		loader: '<div class="row"><div style="text-align:center">正在载入 <img style="margin:0 0 2px 5px" src="/Public/images/preloader.gif"/></div></div>',
	});
};


// 收藏视频
function FavPost(vid, faved){
	link = '/ajax/FavPost/';
	$.post(link, {vid:vid, faved:faved}, function(data){
		if(data.status) {
			if(data.content == "收藏"){
				document.getElementById('favpoststatus').innerHTML = '<button onclick="FavPost('+ vid +', 1)" class="btn btn-mini btn-inverse ajax" >取消收藏</button>';
				$.globalMessenger().post({ message: '收藏成功！',type: 'success',showCloseButton: true });
				};
			if(data.content == "取消收藏"){
				document.getElementById('favpoststatus').innerHTML =  '<button onclick="FavPost('+ vid +', 0)" class="btn btn-mini btn-red ajax" >收藏</button>';
				$.globalMessenger().post({ message: '取消收藏成功！',type: 'success',showCloseButton: true });
				};
		} else {
			$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
		}
	}, 'json');
};



// 关注用户
function LikeUser(uid, liked){
	link = '/ajax/like.php?id='+uid ;
	if (liked == 1) { link = link + '&cancel=1'} ;
	$.get(link,function(data,status){
		//alert("选辑数据：" + data + "\n状态：" + status);
		if ( data == '关注成功') {
		document.getElementById('likeuserstatus').innerHTML = '<button onclick="LikeUser('+ uid +', 1)" class="btn btn-inverse btn-block ajax" >取消关注</button>';
		$.globalMessenger().post({ message: '关注成功！',type: 'success',showCloseButton: true });
		} ;
		if ( data == '取消关注成功') {
		document.getElementById('likeuserstatus').innerHTML =  '<button onclick="LikeUser('+ uid +', 0)" class="btn btn-red btn-block ajax" >关注 TA</button>';
		$.globalMessenger().post({ message: '取消关注成功！',type: 'success',showCloseButton: true });
		}
	});
};


//选辑勾选
function CollectionPost(cid, vid, uid){
	var checkboxval = $("#collection"+ cid).attr("checked");
	link = '/ajax/collect.php';
	if (checkboxval == "checked") {
			$.post(link,
			{
				colletionid: cid,
				videoid: vid,
				cancel: 0
			},
			function(data,status){
				$.globalMessenger().post({ message: '添加选辑'+data+'成功',type: 'success',showCloseButton: true });
			});
		} else {
			$.post(link,
			{
				colletionid: cid,
				videoid: vid,
				cancel: 1
				
			},function(data,status){
				$.globalMessenger().post({ message: '移除选辑'+data+'成功',type: 'success',showCloseButton: true });
			});
		}
}

// 用户页面快速修改
function UserEdit() {
	$.fn.editable.defaults.url = '/ajax/edit_user.php'; 
	$('#enable').click(function() {
       $('.editable').editable('toggleDisabled');
   }); 
   
    $('#username').editable({
		type: 'text',
	 	validate: function(value) {
      	  if($.trim(value) == '') return '请不要留空哟~';
        },
	});
	
    $('#location').editable({
		type: 'text',
	 	validate: function(value) {
      	  if($.trim(value) == '') return '请不要留空哟~';
        },
	});
	
    $('#career').editable({
		type: 'text',
	 	validate: function(value) {
      	  if($.trim(value) == '') return '请不要留空哟~';
        },
	});
	
    $('#aboutme').editable({
		type: 'textarea',
	 	validate: function(value) {
      	  if($.trim(value) == '') return '请不要留空哟~';
		  if($.trim(value).length > 50) return '请不要超过50个字哟';
        },
	});
	
	 $('.editable').editable('toggleDisabled');

};





/*!
 * Infinite Ajax Scroll, a jQuery plugin
 * Version 1.0.2
 * https://github.com/webcreate/infinite-ajax-scroll
 *
 * Copyright (c) 2011-2013 Jeroen Fiege
 * Licensed under MIT:
 * https://raw.github.com/webcreate/infinite-ajax-scroll/master/MIT-LICENSE.txt
 */
(function(e){"use strict";Date.now=Date.now||function(){return+(new Date)},e.ias=function(t){function u(){var t;i.onChangePage(function(e,t,r){s&&s.setPage(e,r),n.onPageChange.call(this,e,r,t)});if(n.triggerPageThreshold>0)a();else if(e(n.next).attr("href")){var u=r.getCurrentScrollOffset(n.scrollContainer);E(function(){p(u)})}return s&&s.havePage()&&(l(),t=s.getPage(),r.forceScrollTop(function(){var n;t>1?(v(t),n=h(!0),e("html, body").scrollTop(n)):a()})),o}function a(){c(),n.scrollContainer.scroll(f)}function f(){var e,t;e=r.getCurrentScrollOffset(n.scrollContainer),t=h(),e>=t&&(m()>=n.triggerPageThreshold?(l(),E(function(){p(e)})):p(e))}function l(){n.scrollContainer.unbind("scroll",f)}function c(){e(n.pagination).hide()}function h(t){var r,i;return r=e(n.container).find(n.item).last(),r.size()===0?0:(i=r.offset().top+r.height(),t||(i+=n.thresholdMargin),i)}function p(t,r){var s;s=e(n.next).attr("href");if(!s)return n.noneleft&&e(n.container).find(n.item).last().after(n.noneleft),l();if(n.beforePageChange&&e.isFunction(n.beforePageChange)&&n.beforePageChange(t,s)===!1)return;i.pushPages(t,s),l(),y(),d(s,function(t,i){var o=n.onLoadItems.call(this,i),u;o!==!1&&(e(i).hide(),u=e(n.container).find(n.item).last(),u.after(i),e(i).fadeIn()),s=e(n.next,t).attr("href"),e(n.pagination).replaceWith(e(n.pagination,t)),b(),c(),s?a():l(),n.onRenderComplete.call(this,i),r&&r.call(this)})}function d(t,r,i){var s=[],o,u=Date.now(),a,f;i=i||n.loaderDelay,e.get(t,null,function(t){o=e(n.container,t).eq(0),0===o.length&&(o=e(t).filter(n.container).eq(0)),o&&o.find(n.item).each(function(){s.push(this)}),r&&(f=this,a=Date.now()-u,a<i?setTimeout(function(){r.call(f,t,s)},i-a):r.call(f,t,s))},"html")}function v(t){var n=h(!0);n>0&&p(n,function(){l(),i.getCurPageNum(n)+1<t?(v(t),e("html,body").animate({scrollTop:n},400,"swing")):(e("html,body").animate({scrollTop:n},1e3,"swing"),a())})}function m(){var e=r.getCurrentScrollOffset(n.scrollContainer);return i.getCurPageNum(e)}function g(){var t=e(".ias_loader");return t.size()===0&&(t=e('<div class="ias_loader">'+n.loader+"</div>"),t.hide()),t}function y(){var t=g(),r;n.customLoaderProc!==!1?n.customLoaderProc(t):(r=e(n.container).find(n.item).last(),r.after(t),t.fadeIn())}function b(){var e=g();e.remove()}function w(t){var r=e(".ias_trigger");return r.size()===0&&(r=e('<div class="ias_trigger">'+n.trigger+"</div>"),r.hide()),e("a",r),r}function E(t){var r=w(t),i;n.customTriggerProc!==!1?n.customTriggerProc(r):(i=e(n.container).find(n.item).last(),i.after(r),r.fadeIn())}function S(){var e=w();e.remove()}var n=e.extend({},e.ias.defaults,t),r=new e.ias.util,i=new e.ias.paging(n.scrollContainer),s=n.history?new e.ias.history:!1,o=this;u()},e.ias.defaults={container:"#container",scrollContainer:e(window),item:".item",pagination:"#pagination",next:".next",noneleft:!1,loader:'<img src="images/loader.gif"/>',loaderDelay:600,triggerPageThreshold:3,trigger:"Load more items",thresholdMargin:0,history:!0,onPageChange:function(){},beforePageChange:function(){},onLoadItems:function(){},onRenderComplete:function(){},customLoaderProc:!1,customTriggerProc:!1},e.ias.util=function(){function i(){e(window).load(function(){t=!0})}var t=!1,n=!1,r=this;i(),this.forceScrollTop=function(i){e("html,body").scrollTop(0),n||(t?(i.call(),n=!0):setTimeout(function(){r.forceScrollTop(i)},1))},this.getCurrentScrollOffset=function(e){var t,n;return e.get(0)===window?t=e.scrollTop():t=e.offset().top,n=e.height(),t+n}},e.ias.paging=function(){function s(){e(window).scroll(o)}function o(){var t,s,o,f,l;t=i.getCurrentScrollOffset(e(window)),s=u(t),o=a(t),r!==s&&(f=o[0],l=o[1],n.call({},s,f,l)),r=s}function u(e){for(var n=t.length-1;n>0;n--)if(e>t[n][0])return n+1;return 1}function a(e){for(var n=t.length-1;n>=0;n--)if(e>t[n][0])return t[n];return null}var t=[[0,document.location.toString()]],n=function(){},r=1,i=new e.ias.util;s(),this.getCurPageNum=function(t){return t=t||i.getCurrentScrollOffset(e(window)),u(t)},this.onChangePage=function(e){n=e},this.pushPages=function(e,n){t.push([e,n])}},e.ias.history=function(){function n(){t=!!(window.history&&history.pushState&&history.replaceState),t=!1}var e=!1,t=!1;n(),this.setPage=function(e,t){this.updateState({page:e},"",t)},this.havePage=function(){return this.getState()!==!1},this.getPage=function(){var e;return this.havePage()?(e=this.getState(),e.page):1},this.getState=function(){var e,n,r;if(t){n=history.state;if(n&&n.ias)return n.ias}else{e=window.location.hash.substring(0,7)==="#/page/";if(e)return r=parseInt(window.location.hash.replace("#/page/",""),10),{page:r}}return!1},this.updateState=function(t,n,r){e?this.replaceState(t,n,r):this.pushState(t,n,r)},this.pushState=function(n,r,i){var s;t?history.pushState({ias:n},r,i):(s=n.page>0?"#/page/"+n.page:"",window.location.hash=s),e=!0},this.replaceState=function(e,n,r){t?history.replaceState({ias:e},n,r):this.pushState(e,n,r)}}})(jQuery)



//多说评论

var duoshuoQuery = {short_name:"aimozhen"};
(function Duoshou() {
    var ds = document.createElement('script');
    ds.type = 'text/javascript';ds.async = true;
    ds.src = 'http://static.duoshuo.com/embed.js';
    ds.charset = 'UTF-8';
    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(ds);
})();


$(function(){ 
	playbutton(); 
	iaspost(); 
	gotopbutton();
});