<?php 
namespace Manager\Controller;
use Think\Controller;
use Org\Util\Rbac;
class CommonController extends Controller{
	public function __construct(){
		parent::__construct();
		$uid = session('uid');
		$username = session('username');
		if(empty($uid))
			$this->redirect('manager/login/index');
		if(session('username')!=C('ADMIN_AUTH_KEY')){

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
			            // $this->error(L('_VALID_ACCESS_'));
			            // redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
			            dwz_return('没有权限','','closeCurrent','','','',300);
			        }
			    }
			}
		}
	}

	public function img_upload(){
    	$config = array(
    	    'maxSize'    =>    3145728,
    	    'rootPath'   =>    C('uploadImg'),
    	    'savePath'   =>    '',
    	    'saveName'   =>    array('uniqid',''),
    	    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg','xls','xlsx'),
    	    'autoSub'    =>    true,
    	    'subName'    =>    array('date','Ymd'),
    	);
        if(!is_dir($config['rootPath']))
            mkdir($config['rootPath'],0775,true);
    	$upload = new \Think\Upload($config);// 实例化上传类
	    // 上传文件 
	    $info   =   $upload->upload();
	    if(!$info) {// 上传错误提示错误信息
	        $this->error($upload->getError());
	    }else{// 上传成功
	        // $re = $this->success('上传成功！');
	        $model = D('Upload');//保存到库
	        $data['file_size'] = formart_size($_FILES['file']['size']);
	        $data['file_name'] = $_FILES['file']['name'];
	        $data['file_path'] = $config['rootPath'].$info['file']['savepath'].$info['file']['savename'];
	        $savename = $info['file']['savename'];
	        $thembName = substr($savename,0,strrpos($savename, '.'));
	        $image = new \Think\Image(); 
	        
	        foreach (array(40,200,400,600,800) as $v) {
	        	$image->open($data['file_path']);
	        	$image->thumb($v,$v)->save($config['rootPath'].$info['file']['savepath'].$thembName.'_'.$v.'.'.$info['file']['ext']);
	        }
	        
	        //将图片裁剪为400x400并保存为corp.jpg
	        $image->crop(400, 400,100,30)->save('./crop.jpg');
	        return array(
	        		'status'=>201,
	        		'imgURL'=>'http://'.$_SERVER['HTTP_HOST'].trim($data['file_path'],'.'),
	        		'isImg'=>true,
	        		'name'=>$data['file_name'],
	        		'size'=>$data['file_size'],
	        		'responseText'=>'success',
	        		'id'=>'http://'.$_SERVER['HTTP_HOST'].trim($data['file_path'],'.'),
	        	);
	    }
	}
    /**
     *  返回 json 格式数据
     * @param  integer $code [description]
     * @param  string  $info [description]
     * @param  array   $data [description]
     * @return [type]        [description]
     */
    public function returnAjax($code=0,$data=array(),$info='',$statusCode=200,$forwardUrl=''){
        $code_list = C('api_code');
        $this->ajaxReturn(array(
                'code' => $code,
                'info'  => empty($info)? $code_list[$code] : $info,
                'data' => $data,
                'statusCode' => $statusCode,
                'forwardUrl' => $forwardUrl,
            ));
        exit;
    }

    public function dwzReturn($data){
        $code_list = C('api_code');
        $this->ajaxReturn(array(
                'statusCode' => $data['statusCode'],
                'message' => $data['message'],
                'forwardUrl' => $data['forwardUrl'],
                'navTabId' => $data['navTabId'],
                'callbackType' => $data['callbackType']
            ));
    }
}