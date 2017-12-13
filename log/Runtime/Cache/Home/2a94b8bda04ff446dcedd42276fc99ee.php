<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>YAKKY PANG</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/animate.css">
	<style type="text/css" media="screen">
	.am-direction-nav {
	     display: none; 
	}
		#enter{
			width:100%;
			height: 100%;
			background: #000;
			position: relative;
			display: flex;
			align-items:center;
		}
		.logo{
			width: 100%;
			position: absolute;
			transition:1s;
			display:flex;
			justify-content:center;
		}
		
	</style>
</head>

<body>
	<div id="enter">
		<div class="logo">
			<p><!-- <img src="../img/images/beginlogo1_01.png" height="127" width="112" alt=""> --></p>
			<p><a href="<?php echo u('index/home');?>" title=""><img src="/Public/img/images/beginlogo2_02.png" ></a></p>
		</div>
	</div>
</body>
<script type="text/javascript" src='../js/jquery-3.2.1.min.js'></script>
<script type="text/javascript">
	$('.logo p:eq(1)').click(() => {
		
		$(".logo p:eq(0)").addClass('animated rotateIn');
		
		setTimeout('jumpurl()',1000); 
	})
	
	jumpurl = () => {
		location='home.html'; 
	} 
</script>
</html>