<?php 
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{
    public function __construct(){
        parent::__construct();
        $uid = session('id');       
        if(empty($uid))
            $this->redirect('Home/login/index');
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