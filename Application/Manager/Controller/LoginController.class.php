<?php
namespace Manager\Controller;
use Think\Controller;
use Org\Util\Rbac;
class LoginController extends Controller {
    public function index(){
        $uid = session('uid');
        $username = session('username');
        if(!empty($uid)) {
            $this->redirect('manager/index/index');
        }

        $this->display();
    }
    //登录
    public function LoginHandle(){
    	$username = I('post.username','','htmlspecialchars');
    	$pwd = I('post.password','','htmlspecialchars');
      //   echo " hello    debug !";
        // echo get_pwd('admin');die;
       //  $this->error(get_pwd('admin',true));
       // die;
       // 
       //dump('adbc');
 
    	if(empty($username))$this->error('用户名不能为空','',true); 
    	if(empty($pwd))$this->error('密码不能为空','',true); 
    	$model = D('Login');


        // 登录日志
        $model->add_log();
    	$userData = $model->loadByName($username);
    	if(empty($userData))$this->error('账户或密码错误','',true); 
    	// 登录次数验证
    	if($userData['login_num']>=6){
    		// 验证隔上一次的登录时候有两个小时
    		$differTime = time()-$userData['last_login_time'];
    		if($differTime>2*60*60){
                // 用户密码验证
                $re = $model->checkUser($username,$pwd);
                if(!$re){
                    // 记录错误
                    $model->addNum($username);
                    $this->error('账户或密码错误.','',true);
                }else{
                    //清除之前的错误
                    $model->addNum($username,true);
                    Rbac::saveAccessList();
                    if(session('username')<>'admin'){
                        $this->vUser($username,$pwd);
                    }

                    $this->success('success','',true);
                }
    		}else{
    			$this->error('还没两个小时，一会再来吧','',true);
    		}
    	}else{
    		// 用户密码验证
    		$re = $model->checkUser($username,$pwd);
    		if(!$re){
    			// 记录错误
                $model->addNum($username);
    			$this->error('账户或密码错误.','',true);
    		}else{
    			//清除之前的错误
    			$model->addNum($username,true);
                Rbac::saveAccessList(); 
                if(session('username')<>'admin'){
                    $this->vUser($username,$pwd);
                }
    			$this->success('success',U('manager/index/index'),true);
    		}
    	}
    }

    private function vUser(){
        if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
            if (!RBAC::AccessDecision()) {
                //检查认证识别号
                if (!$_SESSION [C('USER_AUTH_KEY')]) {
                    //跳转到认证网关
                    redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
                }
                // 没有权限 抛出错误
                if (C('RBAC_ERROR_PAGE')) {
                    // 定义权限错误页面
                    redirect(C('RBAC_ERROR_PAGE'));
                } else {
                    if (C('GUEST_AUTH_ON')) {
                        $this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
                    }
                    // 提示错误信息
                    $this->error(L('_VALID_ACCESS_'));
                }
            }
        }
    }

    // 退出
    function loginout(){
        session('uid',null);
        session('username',null);
        $this->redirect('manager/Login/index');
    }

    function inser(){
        $data['user_name'] = I('get.account');
        $data['pwd'] = get_pwd(I('get.password'));
        $re = M('user')->add($data);
        if(!$re){
            eixt('访问地址：'.U("manager/login/inser/account/jos/password/admin"));
        }else{
            $this->success('用户名：'.$data['user_name'].';密码：'.I('get.password'),'index');
        }
    }
}