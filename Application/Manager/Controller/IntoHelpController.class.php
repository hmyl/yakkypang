<?php
//帮扶活动管理
namespace Manager\Controller;
use Think\Upload;
use Manager\Controller\CommonController;
class IntoHelpController extends CommonController {
    public function index(){
        $p = I('post.pageNum',1);
        $row = I('post.numPerPage',20);
        $model = D('IntoHelp');
        $re = $model->lists($p,$keywords,$row);
        $count =  $model->count();

        $assign = array(
                'p'=>$p,
                'count'=>$count,
                'lists'=>$re,
                'row'=>$row
            );
        $assign = array_merge($assign,I('post.'));
        
        $this->assign($assign);
        $this->display();
    }

    function series(){
        $p = I('post.pageNum',1);
        $row = I('post.numPerPage',200);
        $series_id = I('get.id');
        $re = M('into_images')->where(['series_id' => $series_id])->select();

        foreach ($re as &$v) {
            $v['images'] = json_decode($v['images'],true);
        }
        
        $assign = array(
                'p'=>$p,
                'count'=>$count,
                'lists'=>$re,
                'row'=>$row
            );
        $this->assign($assign);

        $this->display('index_1');

    }

    public function add(){
       
        $id = I('get.id','0','intval');
        if($id){
            $oldData = D('IntoHelp')->loadById($id);
            if($oldData['status']==1){
                $this->assign($oldData);
            }else{
                exit('数据错误');
            }
        }
        $this->display();
    }

    public function add_series(){
    
        $id = I('get.id','0','intval');
        if($id){
            $oldData = D('into_images')->find($id);
            if($oldData['images'])
                $oldData['images'] = json_decode($oldData['images'],true);
            
            $this->assign($oldData);

        }
        $this->display();
    }

    /**
     * [saveImage description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function addImages(){
        $data = I('post.');
        if(isset($data['images'])){
            if(empty($data['images'])){
                $images[] = $data['photo'];
            }else{
                $images = $data['images'];
            }
        }else{
            $images[] = $data['photo'];
        }
        $data['images'] = json_encode($images);

        $id = I('post.id',0);
        if($id){
            $u = [
                'photo' => $data['photo'],
                'images' => $data['images'],
                'series_id' => $data['series_id']
            ];
            $re = M('into_images')->where(['id'=>$id])->save($u);
            $msg = '修改成功';
        }else{
            $u = [
                'photo' => $data['photo'],
                'images' => $data['images'],
                'series_id' => $data['series_id'],
            ];
            $re = M('into_images')->add($u);
            $msg = '添加成功';
        }
        
        if($re)
            dwz_return($msg,"",'closeCurrent','IH_list_1');
        else
           dwz_error('添加失败'); 
    }

    // 添加帮扶计划
    public function addPlan(){
        if(!IS_POST){
            $msg = ['code'=>300,'msg'=>'非法访问'];
            dwz_return($msg);
        }
        $re = D('IntoHelp')->createData();
        // $list = 'IH_list';
        dwz_return($re,"{U('intohelp/index')}",'closeCurrent',$list);
    }



    /**
     * [delimage 删除图片]
     * @return [type] [description]
     */
    public function delimage(){
        $id = I('get.id');
        $src = I('get.src');
        if(!$id||!$src){
            dwz_return('删除失败');
        }else{
            $image = M('into_images')->where(['id'=>$id])->find();
           
            if($image){
                $image = json_decode($image['images'],true);
                $new = [];
                if(is_array($image)){
                    foreach ($image as &$v) {
                        if(strpos($v,$src)!==false){
                            if(is_file($v)){
                                unlink($v);
                               
                            }
                            unset($v);
                        }else{
                            $new[] = $v ;
                        }
                    }
                }

                if($new){
                    $new = json_encode($new,JSON_UNESCAPED_UNICODE);
                    M('into_images')->where(['id'=>$id])->save(['images'=>$new]);
                }

            }
            dwz_return('删除成功','','','_blank');
        }

    }

    /**
     * [isShow 显示隐藏]
     * @return boolean [description]
     */
    public function isShow(){
        $ids = I('ids',I('get.ids'));
        $status = I('get.status',0);
        if(empty($ids))
            dwz_error('修改失败');
        $series = I('get.ser',0);
        if($series){
            $model = M("into_images");
            $re = $model->where(['id'=>$ids])->save(['status' => $status]);
        }else{
            $model = M("into_help");
            $re = $model->where(['id'=>$ids])->save(['update_time'=>date('Y-m-d H:i:s'),'status' => $status]);
        }
        if($re)
            dwz_return('修改成功','','','IH_list');
        else
            dwz_error('修改失败');
    }




    public function delAll(){
        $ids = I('ids',I('get.ids'));
        if(empty($ids))
            dwz_return('删除失败');
        if(is_string($ids))
            $ids = explode(',', $ids);
        if(is_array($ids)){
            foreach ($ids as &$v)
                $v = (int)$v;
        }else{
            dwz_return('删除失败');
        }
        if(!is_array($ids))
            dwz_return('参数错误');
        $series = I('get.ser',0);
        if($series){
            $model = D("into_images");
            M('into_images')->where(['id'=>I('get.ids')])->delete();
            $re['msg'] = '删除成功';
            dwz_return($re['msg'],'','','IH_list_1');
        }else{
            $model = D("IntoHelp");
            $re = $model->del($ids);
            dwz_return($re['msg'],'','','IH_list');
        }
    }

    public function oneUpload($way=0){
        $upload = new Upload();
        $upload->maxSize   =     3145728 ;// 设置附件上传大小   
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型 
        $upload->rootPath  = "./Public/";
        //$upload->subName = time();
        $upload->savePath  =      'Upload/images/'; // 设置附件上传目录  
           // 上传文件   
        $info   =   $upload->upload();
        $fix = $_SERVER['SERVER_PORT']==443?'https://':'http://';
        $host = $fix.$_SERVER['HTTP_HOST'];

        $script_name = $_SERVER['SCRIPT_NAME'];
        $script_name = str_replace(["index.php"], "", $script_name);
        $script_name = rtrim($script_name,'/');
        $host .= $script_name;
        if($info) {
            //如果上传成功
            // $imaUrl = trim($host,'/').'/Public/'.$info['file']["savepath"].$info['file']['savename'];
            $imaUrl = '/Public/'.$info['file']["savepath"].$info['file']['savename'];
            $msg = 'success';
        }else{
            $msg = $upload->getError();
        }

        exit(json_encode(['code'=>0,'massage'=>$msg,'url'=>$imaUrl?$imaUrl:'']));
    }

    public function up()
    {
        $data = M('into_images')->select();
        foreach ($data as $k => &$v) {
            $v['images'] = json_decode($v['images'],true);
            foreach ($v['images'] as &$v1) {
                $v1 = str_replace('://xxx.dongcaicai.com', '', $v1);
            }
            $v['images'] = json_encode($v['images'],JSON_UNESCAPED_SLASHES);
            
            $re = M('into_images')->save($v);
        }
    }
}
