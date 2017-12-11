<?php
return array(
	'DB_TYPE'               =>  'mysql',     // 数据库类型
// online
	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'memeda',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '@yakkypang123',         // 密码

	// localhost
/*	'DB_HOST'               =>  'localhost', // 服务器地址
	'DB_NAME'               =>  'hqdb',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
#
	'DB_PWD'                =>  '',          // 密码*/

#	'DB_PWD'                =>  '',          // 密码*/
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'fp_',    // 数据库表前 你本地数据库密码

	'uploadPath' =>'./Public/Uploads/excel/',//文件上传路径
	'qrcode' =>'./Public/qrcode/',//文件上传路径
	'uploadImg' =>'./Public/Uploads/img/',//文件上传路径
	'TMPL_CACHE_ON'			=>false,

	'URL_MODEL'   => 2,
	'URL_CASE_INSENSITIVE' => true, //地址不区分大小写
	'DEFAULT_MODULE'        =>  'Home',  // 默认模块
	'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
	'DEFAULT_ACTION'        =>  'home', // 默认操作名称

	'RBAC_SUPERADMIN' => 'admin', //超级管理员名称  
	'ADMIN_AUTH_KEY' => 'admin', //超级管理员识别 
	'USER_AUTH_ON'              =>  true, 
    'USER_AUTH_TYPE'    =>    2,        // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY'             =>  'uid',    // 用户认证SESSION标记
    'USER_AUTH_GATEWAY'   =>  '/manager/Public/error',// 没有权限进入的页面
    'NOT_AUTH_MODULE'     =>  'Index,Login,Public', // 默认无需认证模块
    'REQUIRE_AUTH_MODULE'       =>  'PoorUser,Team,Rbac,IntoHelp,Map,User,HelpWay',        // 默认需要认证模块
    'NOT_AUTH_ACTION'           =>  '',        // 默认无需认证操作
    'REQUIRE_AUTH_ACTION'       =>  '',        // 默认需要认证操作
    'GUEST_AUTH_ON'             =>  false,    // 是否开启游客授权访问
    'GUEST_AUTH_ID'             =>  0,        // 游客的用户ID
    'RBAC_ROLE_TABLE'           =>  'fp_role',
    'RBAC_USER_TABLE'           =>  'fp_role_user',
    'RBAC_ACCESS_TABLE'       => 'fp_access',
    'RBAC_NODE_TABLE'          =>  'fp_node',
);
/*return array(
	'DB_TYPE'               =>  'mysql',     // 数据库类型
	'DB_HOST'               =>  '127.0.0.1', // 服务器地址
	'DB_NAME'               =>  'hqdb',          // 数据库名
	'DB_USER'               =>  'root',      // 用户名
	'DB_PWD'                =>  '',          // 密码
	'DB_PORT'               =>  '3306',        // 端口
	'DB_PREFIX'             =>  'fp_',    // 数据库表前缀

	'uploadPath' =>'./Data/Uploads/',//文件上传路径
	'TMPL_CACHE_ON'			=>false,
);*/
