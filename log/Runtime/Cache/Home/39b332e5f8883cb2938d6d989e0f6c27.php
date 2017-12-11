<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YAKKY PANG</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/amazeui.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/home.css">
</head>
<body>
	<div class="am-slider am-slider-default" data-am-flexslider id="demo-slider-0" >
	  <ul class="am-slides">
	  	<?php if(is_array($re)): foreach($re as $key=>$v): ?><li><img src="<?php echo ($v["photo"]); ?>" /></li><?php endforeach; endif; ?>
	    <!-- <li><img src="/Public/img/index/hunter006.jpg" /></li>
	    <li><img src="/Public/img/index/military001.jpg" /></li>
	    <li><img src="/Public/img/index/military002.jpg" /></li>
	    <li><img src="/Public/img/index/military004.jpg" /></li>
	    <li><img src="/Public/img/index/shirt006.jpg" /></li> -->
	  </ul>
	</div>	
	<div class="nav">
		<ul class="am-avg-sm-5 nav_wrap clearfixed">
			<li class="nav_li_1 nav_one li_one">
				<span class="lang">COLLECTION</span>
				<ul class="nav_li_wrap" >
					<?php if(is_array($data)): foreach($data as $key=>$v): ?><a id="link-0" href="<?php echo U('index/content',array('zh'=>I('get.zh'),'id'=>$v['id']));?>" data='1'><li class="desc"><?php echo ($v["desc"]); ?></li></a><?php endforeach; endif; ?>
				</ul>
			</li>
			<li class="nav_li_1"><a href="<?php echo U('index/content',array('zh'=>I('get.zh')));?>" class="lang" data='3'>ABOUT US</a></li>
			<li class="nav_li_1"><a href="<?php echo U('index/content',array('zh'=>I('get.zh')));?>" class="lang" data='4'>CONTACT</a></li>
			<li class="nav_li_1 language" onclick='fun(event)'>
				<span class="lang">LANGUAGE</span>	
				<ul class="list_2_wrap ">
					<li onclick='location.href="home.html?zh=en"'>ENGLISH</li>
					<li onclick='location.href="home.html?zh=cn"'>中文</li>
				</ul>
			</li>
			<li class="nav_li_1"><a href="<?php echo U('index/content');?>" class="lang" data='5'>LINK</a></li>
		</ul>
	</div>	
</body>
<script type="text/javascript" src="/Public/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src='/Public/js/amazeui.js'></script>
<script type="text/javascript" src='/Public/js/language.js'></script>
<!-- <script type="text/javascript" src='./data.js'></script> -->
<script>
// var data = <?php echo ($data); ?>;
$(function(){
	// $('.desc').html(data.data[0].desc)
	// $('#link-0').attr('href','?zh='+zh)
	var width = document.body.clientWidth;
	$('.am-slider .am-slides img').css({
		width: width
	});
	
	$('.nav_wrap .nav_one').hover(function(e) {
		e.stopPropagation();
		$(this).find('.nav_li_wrap').show();
	}, function(e) {
		e.stopPropagation();
		$(this).find('.nav_li_wrap').hide();
	});

	$('.nav_li_wrap a').click(function(){
		var data = $(this).attr('data');
		console.log(data)
		var href = $(this).attr("href");
		$(this).attr('href', href+'?list='+data + '&zh='+zh)
	})

	$('.nav_li_1 a').click(function(){
		var data = $(this).attr('data');
		var href = $(this).attr("href");

		$(this).attr('href',href+'?list='+data + '&zh='+zh)
	})

	$('.nav li.language').hover(function(e) {
		$(".list_2_wrap").toggle();
	}, function(e) {
		$(".list_2_wrap").toggle();
	});

})

</script>
</html>