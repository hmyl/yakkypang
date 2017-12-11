<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YAKKY PANG</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/amazeui.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/content.css">
</head>
<body style="overflow: auto;">
	<div class="content clearfixed">
		<div class="content_right">
			<div class="content_logo">
				<a href="<?php echo U('index/home');?>" style="display: block;line-height: 140px;height: 100%;color: white;font-size: 25px;font-weight: 700;">
					<img src="/Public/img/images/logo11.png" alt="">
				</a>
			</div>
			<div class="content_list">
				<ul class="content_list_1">
					<li class="content_list_1_wrap lang one">
						<a target="iframe" href="javascript:;" title="" target="yakky">	COLLECTION</a>
					</li>
					<ul class="list_1_wrap content_wrap f15">
						<?php if(is_array($mu)): foreach($mu as $key=>$v): ?><a href="<?php echo U('index/collection',['zh'=>I('get.zh'),'id'=>$v['id']]);?>" target="yakky" data = '1'><li class="desc"><?php echo ($v["desc"]); ?></li></a><?php endforeach; endif; ?>
					</ul>
					<li class="content_list_1_wrap "><a name="yakky" href="<?php echo U('index/about',['zh'=>I('get.zh','en')]);?>"  target="yakky" class="lang" >ABOUT US</a></li>
					<li class="content_list_1_wrap"><a href="mailto:administrator@yakkypang.com"  class="lang">CONTACT</a></li>
					<li class="content_list_1_wrap lang" onclick='fun(event)' >LANGUAGE</li>
						<ul class="list_2_wrap">
							<li class="f15" onclick='en()'>ENGLISH</li>
							<li class="f15" onclick='cn()'>中文</li>
						</ul>
					<li class="content_list_1_wrap"><a name="yakky" href="<?php echo U('index/link');?>"  target="yakky" class="lang">LINK</a></li>
				</ul>
			</div>
		</div>
		<div class="content_left">
			<iframe _src="" src="<?php echo U('index/collection',['id'=>I('get.id')]);?>" name='yakky' style="width: 100%;height:100%;overflow-x: hidden;"></iframe>
		</div>
	</div>
</body>
<script type="text/javascript" src="/Public/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src='/Public/js/amazeui.js'></script>
<script type="text/javascript" src='/Public/js/language.js'></script>
<!-- <script type="text/javascript" src='./data.js'></script> -->
<script type="text/javascript">
// var data = <?php echo ($data); ?>;
	
$(function(){
	$('.content_logo a').attr('href','<?php echo U("index/home");?>?zh='+zh);
})
var currentUrl = this.location.href;
var s=currentUrl.indexOf("=");
var t=currentUrl.substring(s+1);// t就是?后面的东西了
// $('.desc').html(data.data[0].desc)
t = getUrlParam('list');
// var t = ;

var lang = "<?php echo I('get.zh',0);?>";
if(lang == "cn"){
	chinese();
	
}



function en(){
	var f = $('.list_1_wrap').css('display');
	if(f == 'block'){
		t = 1;
	}
	var src = $('iframe').attr('_src');
	if(src == ""){
	src = "<?php echo I('get.url','');?>";	
}
	location.href="<?php echo U('index/content');?>?zh=en&url="+src;
}
function cn(){
	var f = $('.list_1_wrap').css('display');
	if(f == 'block'){
		t = 1;
	}
	var src = $('iframe').attr('_src');
        if(src == ""){
        src = "<?php echo I('get.url','');?>";     
}

	location.href="<?php echo U('index/content');?>?zh=cn&url="+src;
}
$('a').click(function(){

var _src = $(this).attr('href');console.log(_src);
        $('iframe').attr('_src',_src);
})
$('.content_list_1 li').click(function(event) {
	/* Act on the event */
	var ul = $(this).siblings('li');
	$.each(ul,function(index, el) {
		$(this).next('ul').hide();
	});
});
if(t == 1){
	$('.content_list_1_wrap').css('background','#030000');
	$('.content_list_1_wrap').eq(0).css('background','#383737');
	$('.list_1_wrap').show();
	$('.a').eq(0).find('li').append('<i class="am-icon-play am-icon-fw" ></i>');
//	$('iframe').attr('src',$('.list_1_wrap a').eq(0).attr('href'))
}else if(t == 3){
	$('.content_list_1_wrap').css('background','#030000');
	$('.content_list_1_wrap').eq(1).css('background','#383737');
	$('iframe').attr('src',	$('.content_list_1_wrap').eq(1).find('a').attr('href'))
}else if(t == 4){
	$('iframe').attr('src','mailto:administrator@yakkypang.com')
	$('.content_list_1_wrap').css('background','#030000');
	$('.content_list_1_wrap').eq(2).css('background','#383737');
}else{
	//$('.content_list_1_wrap').css('background','#030000');
	//$('.content_list_1_wrap').eq(4).css('background','#383737');
	var src = "<?php echo I('get.url','0');?>";
	if(src==0){
	   src = $('.content_list_1_wrap').eq(4).find('a').attr('href');
	}
	$('iframe').attr('src',	src).css('padding','20px')
}

$('.one').click(function(){
	$(this).parent().find('.list_1_wrap').toggle();
	$('iframe').attr('src',	collection.html);
	$('.list_2_wrap').hide();
})
$('.content_list_1_wrap').click(function(){
	$('.content_list_1_wrap').css('background','#030000');
	$(this).css('background','#383737');
})
	var width = document.body.clientWidth;
	// width = width>1200?1200:width;
	var widthRigth =  width - 190;
	console.log(widthRigth);
	$('.content_left').width(widthRigth)
	$('.content_list_1_wrap').on('click',function(){
		var a = $(this).find('a').attr('href');
		$('iframe').attr('src',a)
	})
	$('.list_1_wrap a').click(function(){
		var data = $(this).attr('data');
		$('i').remove();
		$(this).find('li').append('<i class="am-icon-play am-icon-fw" ></i>');
	})

	
</script>
</html>