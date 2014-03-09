	$(function(){
		//上传头像(uploadify插件)
		$("#user-pic").uploadify({
			'queueSizeLimit' : 1,
			'removeTimeout' : 0.5,
			'preventCaching' : true,
			'multi'    : false,
			'swf' 			: '/public/static/addons/uploadify-v3.21/uploadify.swf',
			'uploader' 		: '/index/ajax/uploadImg/',
			'buttonText' 	: '<span class="glyphicon glyphicon-plus-sign"></span> 上传缩略图',
			'width' 		: '210',
			'height' 		: '160',
			'fileTypeExts'	: '*.jpg; *.png; *.gif;',
			'onUploadSuccess' : function(file, data, response){
				var data = $.parseJSON(data);
				if(data['status'] == 0){
					alert(data['info']);
					return;
				}
				var preview = $('.upload-area').children('#preview-hidden');
				preview.show().removeClass('hidden');
				//两个预览窗口赋值
				$('.crop').children('img').attr('src',data['data']+'?random='+Math.random());
				//隐藏表单赋值
				$('#img_src').val(data['data']);
				//绑定需要裁剪的图片
				var img = $('<img />');
				preview.append(img);
				preview.children('img').attr('src',data['data']+'?random='+Math.random());
				var crop_img = preview.children('img');
				crop_img.attr('id',"cropbox").show();
				var img = new Image();
				img.src = data['data']+'?random='+Math.random();
				//根据图片大小在画布里居中
				img.onload = function(){
					var img_height = 0;
					var img_width = 0;
					var real_height = img.height;
					var real_width = img.width;
					if(real_height > real_width && real_height > 160){
						var persent = real_height / 160;
						real_height = 160;
						real_width = real_width / persent;
					}else if(real_width > real_height && real_width > 210){
						var persent = real_width / 210;
						real_width = 210;
						real_height = real_height / persent;
					}
					if(real_height < 160){
						img_height = (160 - real_height)/2;	
					}
					if(real_width < 210){
						img_width = (210 - real_width)/2;
					}
					preview.css({width:(210-img_width)+'px',height:(160-img_height)+'px'});
					preview.css({paddingTop:img_height+'px',paddingLeft:img_width+'px'});			
				}
				//裁剪插件
				$('#cropbox').Jcrop({
		            bgColor:'#333',   //选区背景色
		            bgFade:true,      //选区背景渐显
		            fadeTime:1000,    //背景渐显时间
		            allowSelect:false, //是否可以选区，
		            allowResize:true, //是否可以调整选区大小
		            aspectRatio: 1,     //约束比例
		            aspectRatio: 210 / 160,
		            minSize : [420,320],//可选最小大小
		            boxWidth : 210,		//画布宽度
		            boxHeight : 160,	//画布高度
		            onChange: showPreview,//改变时重置预览图
		            onSelect: showPreview,//选择时重置预览图
		            setSelect:[ 0, 0, 420, 320],//初始化时位置
		            onSelect: function (c){	//选择时动态赋值，该值是最终传给程序的参数！
			            $('#x').val(c.x);//需裁剪的左上角X轴坐标
			            $('#y').val(c.y);//需裁剪的左上角Y轴坐标
			            $('#w').val(c.w);//需裁剪的宽度
			            $('#h').val(c.h);//需裁剪的高度
		          }
		        });
				
				//重新上传,清空裁剪参数
				var i = 0;
				$('.reupload-img').click(function(){
					$('#preview-hidden').find('*').remove();
					$('#preview-hidden').hide().addClass('hidden').css({'padding-top':0,'padding-left':0});
				});
		     }
			 
		});
	
		//提交裁剪好的图片
		$('.save-pic').click(function(){
			if($('#preview-hidden').html() == ''){
				alert('请先上传图片！');
			}else{
				$(".save-pic").button('loading');
				//由于GD库裁剪gif图片很慢，所以长时间显示弹出框
				//$('#pic').submit();
				link = '/index/ajax/cropImg/';
				$.post(link, $("#pic").serialize(), function(data){
					if(data.status) {
						$('#UploadThumb').modal('hide');
						$.globalMessenger().post({ message: '上传成功',type: 'success',showCloseButton: true });
						$(".post-thumb").css("background","");
						$(".post-thumb").css("background","url('/upload/thumb/"+data.pic+"') no-repeat center center");
						$(".post-thumb").css("background-size","102%");
					} else {
						$('#UploadThumb').modal('hide');
						$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
					}
				}, 'json');
				$(".save-pic").button('reset');
			}
		});
		
		$('.unset-pic').click(function(){
			link = '/index/ajax/unsetImg/';
			var vid = $('#pic #vid').val();
			$.post(link, {vid:vid }, function(data){
				if(data.status) {
					$('#UploadThumb').modal('hide');
					$.globalMessenger().post({ message: '取消成功',type: 'success',showCloseButton: true });
					$(".post-thumb").css("background","");
					$(".post-thumb").css("background","url('"+data.pic+"') no-repeat center center");
					$(".post-thumb").css("background-size","150%");
				} else {
					$('#UploadThumb').modal('hide');
					$.globalMessenger().post({ message: '服务器开小差了~ 请刷新后重试~',type: 'error',showCloseButton: true });
				}
			}, 'json');

		});
		//预览图
		function showPreview(coords){
			var img_width = $('#cropbox').width();
			var img_height = $('#cropbox').height();
			  //根据包裹的容器宽高,设置被除数
			  var rx = 210 / coords.w;
			  var ry = 160 / coords.h; 
			  $('#crop-preview-210').css({
			    width: Math.round(rx * img_width) + 'px',
			    height: Math.round(ry * img_height) + 'px',
			    marginLeft: '-' + Math.round(rx * coords.x) + 'px',
			    marginTop: '-' + Math.round(ry * coords.y) + 'px'
			  });
		}
	})