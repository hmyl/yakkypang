<?php 
namespace Manager\Model;
use Think\Model;
class LoginModel extends Model{
	protected $tableName = 'user';
	public function addData($data){
		if(empty($data))return false;
		$data['ctime'] =time();
		return $this->add($data);
	}
	public function loadById($id){
		if(empty($id))return false;
		return $this->where(['id'=>$id])->find();
	}
	// 检查用户
	public function checkUser($username,$pwd){
		$pwd = get_pwd($pwd);
		$re = $this->where(['user_name'=>$username,'pwd'=>$pwd])->find();
		if($re){
			session('uid',$re['uid']);
		    session('username',$re['user_name']);return true;
		}else return $re;
		
	}
	//错误保存
	public function addNum($username,$init = false){
		$data = ['last_login_time'=>time()];
		$where = ['user_name'=>$username];
		if($init){
			$data['login_num'] = 0;
			$this->where($where)->save($data);
		}else{
			$a = $this->where($where)->save($data);
			$this->where($where)->setInc('login_num');
		}
		
	}
	//登录日志
	public function add_log(){

		$data['login_ip'] = get_client_ip();
		$data['login_username'] = I('post.username');
		$data['login_pwd'] = I('post.password');
		$data['login_time'] = time();
		$re = $this->checkUser($data['login_username'],$data['login_pwd']);
		if($re){
			$data['login_pwd'] = get_pwd($data['login_pwd']);
		}
		M('user_log')->add($data);
	}
	public function loadByName($username){
		if(empty($username))return false;
		return $this->where(['user_name'=>$username])->find();
	}
}