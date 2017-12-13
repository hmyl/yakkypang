<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>collection</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/amazeui.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/collection.css">
</head>
<body>
	<div class="wrap clearfixed">

		<div class="wrap_right">
			<img src="" alt="" >
		</div>
		
		<div class="am-slider am-slider-default wrap_left" data-am-flexslider="{slideshow: false,animationLoop: false,prevText: 'Previous',nextText:'map',directionNav:true}" id='slider' style="background: black;">
		    <ul class="am-slides" id="am-slides-0">
			    <li style="display: none;"><img src="/Public/img/sor2.png" alt=""></li>
		    </ul>

		  	<div class="slid f20">
		 	 	<span class='leftBtn' ><</span>LOOK <span class="order">1</span> <span class='rightBtn'>></span>	
		  	</div>
		</div>
		<div id="bottom" >
			<div class="am-slider am-slider-default am-slider-carousel bottom" data-am-flexslider="{itemWidth: 71, itemMargin: 0, slideshow: false,  }" id="slider1" >
				<ul class="am-slides">
				    <li><img src="/Public/img/sor2.png"  class="bottom_img" /></li>
				</ul>
			</div>
		</div>
	</div>
	<input type="hidden" id="json-data" data="">
</body>
<script type="text/javascript" src="/Public/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript" src='/Public/js/amazeui.js'></script>
<!-- <script type="text/javascript" src='./data.js'></script> -->
<script type="text/javascript">
	var data =  <?php echo ($data); ?>;
	data = jQuery.parseJSON(data);
	console.log(data);
	$(function(){

		var $slider = $('#slider');
		
		$('#slider .am-next').addClass('am-icon-munis');
		function updata_slider(data){
			$slider.flexslider(0);
			// delete
			var count = $slider.flexslider('count');
			for (var i = 0; i < count; i++) {
				$('#slider').flexslider('removeSlide',0);
			}
			$('#slider').flexslider();
			// console.log(document.body.clientHeight);
			// var imgHeight = document.body.clientHeight;
			$('.wrap_right img').attr('src',data.photo);
			// $('.wrap_right img').attr('src',data.photo).height(imgHeight);
			if(data.images.length>0){
				$.each(data.images,function(index, el) {
					var li = '<li><img src="'+el+'"/></li>';
					$slider.flexslider('addSlide', li);
				});
			}
			$slider.flexslider(0);
	
		}

		$("#bottom").hover(function() {
			$(this).show();
		}, function() {
			$(this).hide();
		});

		// setTimeout(function() {$("#bottom").hide();}, 100);
		 
		$('body').mousemove(function(e) {
           e = e || window.event;
           var __yy = e.pageY || e.clientY + document.body.scrollTop;
           var h = $(window).height();
           // var ih = $("#bottom div").height();
           if((h-__yy)<65){
           		$("#bottom").show();
           }
        });

		$('#bottom .am-direction-nav .am-next').css({'right':'-'+(($('.bottom').width()/1)-40) +'px','top':'-70px',})
		$('#bottom .am-direction-nav .am-prev').css({'top':'-70px',});

		var currentUrl = this.location.href
		var s=currentUrl.indexOf("=");
		var t=currentUrl.substring(s+1);


		$('#json-data').val(JSON.stringify(data));
		
		var count1 = $('#slider1').flexslider('count');
		var $slider1 = $('#slider1');
		for (var i = 0; i < count1; i++) {
			$slider1.flexslider('removeSlide',0);
		}
		$slider1.flexslider();
		for (var i = 0; i < data.data[0].images.length; i++) {
			// 底部轮播图片
			var li = '<li><img src="'+data.data[0].images[i].photo+'"/></li>';
			$slider1.flexslider('addSlide', li);
			console.log(data.data[0].images[i].photo)
		}
		updata_slider(data.data[0].images[0]);


		// 蒙版
		$('#bottom').find('.am-slides').find('li').hover(function(e) {
			$(this).find('img').css('opacity','0.5');

		}, function() {
			$(this).find('div').remove();
			$(this).find('img').css('opacity','1');

		});

		//底部点击图片
		$('#bottom').on('click','.am-viewport li',function(){
			var index = $(this).index();
			var data = jQuery.parseJSON( $('#json-data').val() ) ;
			updata_slider(data.data[0].images[index]);
			$('.order').html(index/1+1);
			// $('#bottom .am-viewport li').eq($(this).index()).click();
		})

		// 点击左按钮
		$('.leftBtn').on('click',function(){

			var num = $('.order').html()/1;
			if(num == 1){
				index = 0;
				$('.order').html(1)
			}else{
				$('.order').html(num - 1)
				index = num - 2
			}
			var data = jQuery.parseJSON($('#json-data').val()) ;
			updata_slider(data.data[0].images[index]);
		})

		// 点击右侧按钮
		$('.rightBtn').on('click',function(){
			
			var num = $('.order').html()/1;
			var data = jQuery.parseJSON($('#json-data').val());
			if(num == data.data[0].images.length ){
				index = data.data[0].images.length - 1 ;
				$('.order').html(data.data[0].images.length)
			}else{
				index = num;
				$('.order').html(num/1+1)
			}
			console.log(index);
			updata_slider(data.data[0].images[index]);
			
		})
	})

</script>
</html>