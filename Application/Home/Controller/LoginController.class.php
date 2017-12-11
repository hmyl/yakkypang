<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function index(){
        $uid = session('id');
        if(!empty($uid)){
            $house_number = I('post.house_number','');
            $house = session('house_number');
            if($house!=$house_number){
                session('id',null);
            }else{
                $this->redirect('home/index/index');
            }
        }
        $this->display();
    }
    //登录
    public function LoginHandle(){
        $username = I('post.username','','htmlspecialchars');
        $pwd = I('post.password','','htmlspecialchars');
        $house_number = I('post.house_number','');
        $result = M('poor_user')->where(['house_number'=>$house_number])->find();
        if(!$house_number||!$result){
            $this->error('该贫困户不存在','',true); 
        }
        if(empty($username))$this->error('用户名不能为空','',true); 
        if(empty($pwd))$this->error('密码不能为空','',true); 
        $model = D('HelpTeam');
        // 用户密码验证
        $re = $model->checkUser($username,$pwd);
        if(!$re){

            $this->error('账户或密码错误.','',true);
        }else{
            session('house_number',$house_number);
            $this->success('success',U('home/index/index'),true);
        }
        
    }
    // 退出
    function loginout(){
        session('id',null);
        $this->redirect('home/Login/index');
    }

}