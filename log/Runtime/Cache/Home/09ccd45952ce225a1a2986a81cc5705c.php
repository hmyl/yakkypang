<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>about页面</title>
	<link rel="stylesheet" type="text/css" href="/Public/css/reset.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/about.css">
	<style type="text/css" media="screen">
		.cn{
			word-wrap:break-word;
			margin-top:10%;
			margin-right:8%;
			margin-left:8%;
			line-height: 30px;
			font-weight: normal;
			font-size:24px;
			text-align:center;
		}
		.en{
			word-wrap:break-word;
			line-height: 30px;
			margin-top:10%;
			margin-right:10%;
			margin-left:8%;
			font-family:Helvetica;
			font-weight: normal;
			font-size:20px;
		}
		.cn p{
			font-family: "黑体";
			margin-top:20px;
		}
		.en p{
			margin-top:20px;
		}
	</style>
</head>
<body>
	
		<?php if(I('get.zh') == 'cn'): ?><div class='cn'>
		<p>靈感來自東京里原宿的街頭文化</p>
		<p>時裝元素與功能性巧妙結合</p>
		<p>面料優質、工藝精致、裁剪鋒利，每件單品極具層次和質感</p>
		<p>解構主義手法賦予服裝新的生命和力量</p>
		<p>YAKKY不随波逐流 </p>
		<p>只做靈魂深處另一個自己</p>
		<?php else: ?>
		<div class='en'>
		<p>The inspiration of YAKKY comes from the street culture in Harajuku.It is a state-of-art combination of fashion elements and dressing functions for outdoor activities.</p>
		<p>Created out of high quality fabric, streamlined cutting, and sophisticated tailoring, each item is a masterpiece with full sense of layer and texture. </p>
		<p>Through art of deconstruction, YAKKY renders a whole new lease of life and power the way we dress. </p>
		<p>YAKKY does not floating around or drifting along. YAKKY is the unique one deep in the soul.</p><?php endif; ?>
	</div>
</body>
</html>