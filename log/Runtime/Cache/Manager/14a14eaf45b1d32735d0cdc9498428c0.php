<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>后台管理</title>
<script>
	// swf文件路径
	 // 文件接收服务端, 注意：相关参数配置，请到js/imgUploadClass.js配置
	var BASE_URL = '/Public/admin/dwz';
	// var SERVER_URL = 'http://10.6.0.225:8001/api/upload/image';
	// var SERVER_URL = '/Public/admin/server/fileuploadDemo.php';
	var SERVER_URL = "<?php echo U('PovertyAllevationActivity/oneUpload');?>";
	//批量上传
	var BATCH_SERVER_URL = "<?php echo U('User/MoreUpload');?>"; 
</script>
<link href="/Public/admin/dwz/themes/default/style.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Public/admin/dwz/themes/css/core.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Public/admin/dwz/css/grab.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="/Public/admin/dwz/themes/css/print.css" rel="stylesheet" type="text/css" media="print"/>
<link href="/Public/admin/dwz/css/upload-img.css" rel="stylesheet" type="text/css" media="screen"/>
<!--引入CSS-->
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/webuploader-0.1.5/webuploader.css">
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/themes/css/grabBtn.css">
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/css/dxclass.css">
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/css/batchUpload.css">

<link rel="stylesheet" type="text/css" href="/Public/qh/css/common.css">
<link rel="stylesheet" type="text/css" href="/Public/qh/css/style.css">
<link rel="stylesheet" href="/Public/admin/dwz/css/viewer.min.css">
<!--[if IE]>
<link href="/Public/admin/dwz/themes/css/ieHack.css" rel="stylesheet" type="text/css" media="screen"/>
<![endif]-->

<!--[if lt IE 9]><script src="js/speedup.js" type="text/javascript"></script><script src="/Public/admin/dwz/js/jquery-1.11.3.min.js" type="text/javascript"></script><![endif]-->
<!--[if gte IE 9]><!--><script src="/Public/admin/dwz/js/jquery-2.1.4.min.js" type="text/javascript"></script><!--<![endif]-->
<script src="/Public/admin/dwz/js/jquery.validate.js" type="text/javascript"></script>
<script src="/Public/admin/dwz/js/jquery.bgiframe.js" type="text/javascript"></script>
<script src="/Public/admin/dwz/xheditor/xheditor-1.2.2.min.js" type="text/javascript"></script>
<script src="/Public/admin/dwz/uploadify/scripts/jquery.uploadify.js" type="text/javascript"></script>
<script src="/Public/admin/dwz/js/dwz.min.js" type="text/javascript"></script>
<script type="text/javascript" src="/Public/admin/dwz/webuploader-0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/Public/admin/dwz/js/imgUploadClass.js"></script>
<script type="text/javascript" src="/Public/admin/dwz/js/grab.select.time.sdd.js"></script>
<script type="text/javascript" src="/Public/admin/dwz/js/jQuery.timeRange.js"></script>
<script type="text/javascript" src="/Public/admin/dwz/js/grab.timeRange.js"></script>
<script type="text/javascript" src="/Public/admin/dwz/js/daxiang.js"></script>
<!-- 可以用dwz.min.js替换前面全部dwz.*.js (注意：替换时下面dwz.regional.zh.js还需要引入)
<script src="bin/dwz.min.js" type="text/javascript"></script>
-->
<!-- <script src="/Public/admin/scroll/js/jQuery-jcLightBox.js" language="javascript" type="text/javascript"></script> --><!--图片点击放大-->

<script src="/Public/admin/dwz/js/dwz.regional.zh.js" type="text/javascript"></script>

<!-- 图片查看 -->
<script type="text/javascript">
$(function(){
	DWZ.init("/Public/admin/dwz.frag.xml", {
		loginUrl:"login_dialog.html", loginTitle:"Login",	// 弹出登录对话框
//		loginUrl:"login.html",	// 跳到登录页面
		statusCode:{ok:200, error:300, timeout:301}, //【可选】
		pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
		keys: {statusCode:"statusCode", message:"message"}, //【可选】
		ui:{hideMode:'offsets'}, //【可选】hideMode:navTab组件切换的隐藏方式，支持的值有’display’，’offsets’负数偏移位置的值，默认值为’display’
		debug:false,	// 调试模式 【true|false】
		callback:function(){
			initEnv();
			$("#themeList").theme({themeBase:"/Public/admin/dwz/themes"}); // themeBase 相对于index页面的主题base路径
		}
	});
});
</script>





<script src="/Public/qh/layer/layer/layer.js" rel="script" ></script>
<script src="/Public/admin/dwz/js/viewer-jquery.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.staticfile.org/webuploader/0.1.5/webuploader.min.js"></script> -->
</head>
<body>
	<div id="layout">
		<div id="header">
			<div class="headerNav">
			</div>
			<!-- navMenu -->
			<ul class="nav">
				<li><a href="javascript:;"><?php echo (session('username')); ?></a></li>
				<li><a href="<?php echo U('Login/loginout');?>">退出</a></li>
			</ul>
			<ul class="themeList" id="themeList">
				<li theme="default"><div class="selected">默认</div></li>
				<li theme="green"><div>蓝色</div></li>
				<li theme="purple"><div>粉色</div></li>
				<li theme="silver"><div>银色</div></li>
				<li theme="azure"><div>天蓝</div></li>
			</ul>
		</div>

		<div id="leftside">
			<div id="sidebar_s">
				<div class="collapse">
					<div class="toggleCollapse"><div></div></div>
				</div>
			</div>
			<div id="sidebar">
				<div class="toggleCollapse"><h2>信息平台</h2><div>收缩</div></div>

				<div class="accordion" fillSpace="sidebar">
					<div class="accordionHeader">
						<h2><span>Folder</span>后台管理</h2>
					</div>
					<div class="accordionContent">
						<ul class="tree treeFolder">
							<li><a href="#">系列管理</a>
								<ul>
									<li><a href="<?php echo U('IntoHelp/index');?>" target="navTab" rel="IH_list" title="系列列表">系列列表</a></li>
									<li><a href="<?php echo U('indexImages/index');?>" target="navTab" rel="index_list" title="首页图片">首页图片</a></li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div id="container">
			<div id="navTab" class="tabsPage">
				<div class="tabsPageHeader">
					<div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
						<ul class="navTab-tab">
							<li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">平台主页</span></span></a></li>
						</ul>
					</div>
					<div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
					<div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
					<div class="tabsMore">more</div>
				</div>
				<ul class="tabsMoreList">
					<li><a href="javascript:;">平台主页</a></li>
				</ul>
				<div class="navTab-panel tabsPageContent layoutBox">
					<div class="page unitBox">
						<style>
							.grab-welcome{
								font-size: 48px;
								text-align: center;
								margin-top: 200px;
							}
						</style>
						<h1 class="grab-welcome">欢迎使用后台管理平台</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="footer"> wellcome to you<a href="/Public/admin/html/test/grap_mgr_res.html" target="dialog"></a></div>
</body>
</html>