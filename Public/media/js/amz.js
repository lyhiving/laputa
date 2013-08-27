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
    jQuery(".post-short").hover(function(){
        jQuery(this).find(".post-infor").fadeIn(200);
    },function(){
        jQuery(this).find(".post-infor").fadeOut(200);
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

// 验证用户修改页面
function vHomeSettingBasic() {
	var form = $("#basic");var name = $("#username2");var namegroup = $("#namegroup");var nameInfo = $("#nameInfo");
	name.blur(validateName);name.keyup(validateName);
	form.submit(function(){
		if(validateName())
			return true
		else
			return false;
	});
	function validateName(){
		if(name.val().length < 4){
			namegroup.removeClass("info");
			namegroup.addClass("error");
			nameInfo.text("请不小少于三个字！");
			return false;
		}
		else{
			namegroup.removeClass("error");
			namegroup.addClass("info");
			nameInfo.text("输入正确");
			return true;
		}
	}
};
function vHomeSettingPassword() {
	var form = $("#password");var pass1 = $("#pass1");var pass1group = $("#pass1group");var pass1Info = $("#pass1Info");
	var pass2 = $("#pass2");var pass2group = $("#pass2group");var pass2Info = $("#pass2Info");
	pass1.blur(validatePass1);pass2.blur(validatePass2);
	pass1.keyup(validatePass1);pass2.keyup(validatePass2);
	form.submit(function(){
		if(validatePass1() & validatePass2())
			return true
		else
			return false;
	});
	function validatePass1(){
		var a = $("#password1");var b = $("#password2");
		if(pass1.val().length <5){
			pass1group.addClass("error");
			pass1Info.text("请不小少于五个字！");
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
		var a = $("#password1");var b = $("#password2");
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

// 验证注册页面
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
		loader: '<div class="span12"><div style="text-align:center">正在载入 <img style="margin:0 0 2px 5px" src="/Public/images/preloader.gif"/></div></div>',
	});
};


// 信息提示框
function messageinfo(infoid,value){
	if (infoid == 1) { 
			msg = $.globalMessenger().post({ message: "你好，你有"+ value +"封消息未读",
			  actions: { 
			  	retry: {label: '查看',phrase: 'Retrying TIME',delay: 5,action: function (){window.open("/home/message/",'_self') }  },
				cancel:{label: '关闭',action: function() {return msg.cancel(); } }
			  } ,showCloseButton: true
			});
		}
}

// 显示站内信
function ShowMessage(mid){
	link = '/User/Ajax/getmessage/';
	$.post(link, {mid:mid}, function(data){
		if(data.status) {
			document.getElementById('MessageViewContent').innerHTML =  '<p >'+ data.message +'</p>';
			$('#MessageView').modal('show');
			document.getElementById('MessageTitle-'+mid).style.color="333";
			document.getElementById('MessageTitle-'+mid).style.fontWeight="";
		} else {
			$('#MessageView').modal('hide')
			$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
		}
	}, 'json');
}

function UnreadMessage(mid){
	link = '/User/Ajax/unreadmessage/';
	$.post(link, {mid:mid}, function(data){
		if(data.status) {
			$.globalMessenger().post({ message: '标记成功',type: 'success',showCloseButton: true });
		} else {
			$('#MessageView').modal('hide')
			$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
		}
	}, 'json');
}


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
}



// 关注用户
function FollowUser(uid, faved){
	link = '/User/Ajax/followuser/';
	$.post(link, {uid:uid, faved:faved}, function(data){
		if(data.status) {
			if(data.content == "关注"){
				document.getElementById('followuserstatus').innerHTML = '<a class="my-btn my-btn-gray" onclick="FollowUser('+ uid +', 1)" href="#" >已关注</a>';
				$.globalMessenger().post({ message: '关注成功！',type: 'success',showCloseButton: true });
				};
			if(data.content == "取消关注"){
				document.getElementById('followuserstatus').innerHTML =  '<a class="my-btn my-btn-red" onclick="FollowUser('+ uid +', 0)" href="#" >关注</a>';
				$.globalMessenger().post({ message: '取消关注成功！',type: 'success',showCloseButton: true });
				};
		} else {
			$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
		}
	}, 'json');
}


//选辑勾选
function CollectionPost(cid, vid, uid){
	link = '/ajax/CollPost/';
	var checkboxval = $("#collection"+ cid).attr("checked");
	if (checkboxval == "checked") { var colled = 0 } else { var colled = 1};
	$.post(link, {colled:colled, cid:cid, vid:vid, uid:uid}, function(data){
		if(data.status) {
			if(data.content == "取消选辑"){
				$.globalMessenger().post({ message: '取消选辑'+ data.title +'成功',type: 'success',showCloseButton: true });
				};
			if(data.content == "添加选辑"){
				$.globalMessenger().post({ message: '添加选辑'+ data.title +'成功',type: 'success',showCloseButton: true });
				};
		} else {
			$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
		}
	}, 'json');
}


// 用户页面快速修改
function UserEdit() {
	$.fn.editable.defaults.url = '/user/ajax/edituserfield'; 
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