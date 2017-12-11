<?php
namespace Common\Model;
use \Think\Model;

/**
* 
*/
class UserModel extends Model
{
	
	function userList($username=''){
		$condition = "status = 1";
		if(!empty($username)){
			$condition .= " and username like `%{$username}%`";
		}
		$userList = $this->where($condition)->order('uid desc')->select();
		if(count($userList) > 0){
			return $userList;
		}
		return false;
	}

	
	//首页列表数据
	public function lists($page=1,$wr='',$rows=20){
		// $map['status']  = 1;
		if($wr){
			$map['user_name'] = array('like',"%{$wr}%");
		}
		$re = $this->where($map)->page($page.','.$rows)->select();
		$count =  $this->where($map)->count();
		// $re['data'] = tree($re);
		$re['data'] =$re;
		$re['count'] = $count;
		return $re;
	}
}