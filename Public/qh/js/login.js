/*
* author: daxiang
* email: 2890594972@qq.com
* date:2016-10-7
*/

function loginTip(msg){
	var tipBox = $("#loginTip");
	tipBox.find(".suc-box").text(msg);
	tipBox.show();
}
//异步同意处理
var ajaxColletion = {
	ajax:function(obj,sucHandler,errHandler){
		//需要obj对象 ，传入请求地址url和data参数
		//loginTip('begin post');
		//$.ajaxReturn(1,'添加信息失败',1); 
		$.ajax({
		    type: 'POST',
		    url: obj.url ,
		    data: obj.data ,
		    dataType: 'json',
		    success: function(data){
		    	sucHandler(data);
		    },
		    error:function(){
		    	// todo something 
		    	//loginTip('login error');
		    }
		});
		return true;
	},
	login:function(form){
		//1、解析内容，然后发送过去
		//
		//
		//
	
		var jsonObj = {
			data: $(form).serialize(),
			url:$('form').attr('action')
		}

//	loginTip('test1);

		//2、提交异步处理
		this.ajax(jsonObj,function(data){
			//成功处理 todo something
			// alert(JSON.stringify(data));
		
			if(data.status==1){
				loginTip("登录中，请稍等...");
				loginTip("登录成功");
				setTimeout(function(){
					location.href = data.url;
				},2000);
			}else{
				alert(data.info);
			}	
		},function(data){
			//错误处理 todo something
			alert("错误处理");
		});
		
		//3、请求中提示【可忽略】
	},
	register:function(form){
		//1、解析内容，然后发送过去
		var jsonObj = {
			data: $(form).serialize(),
			url:'http://apis.baidu.com/txapi/world/world?num=10&page=1'
		}
		//2、提交异步处理
		this.ajax(jsonObj,function(data){
			//成功处理 todo something
			alert(JSON.stringify(data));
		},function(data){
			//错误处理 todo something
			alert("错误处理");
		});
	}
}
// 错误统一样式处理和自定义对象
var webUICollection = {
	error1:function(errors, evt){
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
			 var iptObj = $('#'+errors[i].id);
       		 iptObj.siblings(".err-tip").text(errors[i].message);
        	 iptObj.parents('.ipt-box').addClass("err");
        }
	},
	error2:function(errors, evt){
		var errorString = '';
        for (var i = 0, errorLength = errors.length; i < errorLength; i++) {
            errorString += errors[i].message;
        }
	}
}

$(function(){

	/*-------------------------------------login-----------------------*/
	//注意params：formNameOrNode, fields, callback, action
	var login_validator = new FormValidator('login_form', [{
	    name: 'username',
	    display: '用户名',
	    rules: 'required|min_length[3]'
	},  {
	    name: 'password',
	    display:'密码',
	    rules: 'required|min_length[5]'
	}], function(errors, evt) {
	   if (errors.length > 0) {
	   		webUICollection.error1(errors, evt);
	    }else if(this.action=="ajax"){
	    	//loginTip("登录中，请稍等...");
	    	ajaxColletion.login(this.form);
	    }
	},"ajax");


	/*-------------------------------------common btn-----------------------*/
	var  loginForm = $("#loginForm");
	//鼠标放入输入框，清除可能存在的提示
	$(".form-box").find(".ipt").focus(function(){
		$(this).parents('.ipt-box').removeClass('err');
	});
})

$(function(){
	var win_h = $(window).height() - 660;
	if(win_h>0){
		var paddingTop = win_h/2;
		$("#header").css('padding-top',paddingTop+'px');
	}else{
		var paddingTop =0;
		$("#header").css('padding-top',paddingTop+'px');
	}
})