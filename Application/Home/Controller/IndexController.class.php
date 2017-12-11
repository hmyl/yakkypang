<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function home(){
        $re = M("index_images") -> select();
        $this->assign('re',$re);
        $this->assign("data",$this->getData());

        $this->display();
    }

    public function content()
    {
        $mu = M('into_help')->field('id,name,desc')->where('status=1')->select();   
        $this->assign('mu',$mu);
        $id = I('get.id');
        $detail = $this->getDetail($id);
        $this->assign("data",json_encode($detail));
        $this->display();   
        # code...
    }

    public function collection()
    {
        $id = I('get.id',0,'intval');
        $re = $this->getDetail($id);

        $this->assign("data",json_encode($re));
        $this->display();   
        # code...
    }

    function about(){
        $this->display();
    }

    function link(){
        $this->display();
    }

    public function index(){
        $this->display();
    }
    public function index1($id = 0){
       
        // $this->display();die;
        if($id)
            $re = M('into_help')->field('id,name,desc')->where(['id'=>$id,'status'=>1])->select();
        else
            $re = M('into_help')->field('id,name,desc')->where('status=1')->select();

        if($re){
            $imgModel = M('into_images');
            foreach ($re as &$v) {
                $res = $imgModel->field('images,photo')->where(' status=1 and series_id='.$v['id'])->select();
                if($res){
                    foreach ($res as &$v1) {
                        $v1['images'] = json_decode($v1['images'],true);
                    }
                    $v['images'] = $res;
                }else{
                    $v['images'] = [];
                }
            }
        }
        if($re){
            $r = [
                'code' => 1,
                'msg' =>'success',
                'data' => $re
            ];
        }else{
            $r = [
                'code' => -1,
                'msg' =>'没有数据',
                'data' => ''
            ];
        }
        // file_put_contents('list.json',json_encode($r));
        return json_encode($r);
    }

    function getData(){
        $re = M('into_help')->field('id,name,desc')->where('status=1')->select();
        if($re){
            $imgModel = M('into_images');
            foreach ($re as &$v) {
                $res = $imgModel->field('images,photo')->where(' status=1 and series_id='.$v['id'])->select();
                if($res){
                    foreach ($res as &$v1) {
                        $v1['images'] = json_decode($v1['images'],true);
                    }
                    $v['images'] = $res;
                }else{
                    $v['images'] = [];
                }
            }
        }
        return $re;
    }
    

    function getDetail($id){
        if(empty($id))
            return '';
        return $this->index1($id);
       /* $imgModel = M('into_images');
        $res = $imgModel->field('images,photo')->where(' status=1 and series_id='.$id)->select();
        if($res){
            foreach ($res as &$v1) {
                $v1['images'] = json_decode($v1['images'],true);
            }
        }else{
            return '';
        }
        return $res;*/
    }

    
    public function fRename(){
        header("Content-type: text/html; charset=utf-8");
        $dirname = './img';
        if(!is_dir($dirname)){
            echo "{$dirname}不是一个有效的目录！";
            exit();
        }
        $handle = opendir($dirname);
        $i = 1;
        echo '<pre>';
        $this->success();
        $images = [];
        while(($fn = readdir($handle))!==false){
            $fn = iconv('GB2312', 'UTF-8', $fn);

            $a = explode(' ', $fn);
            if(is_array($a)){
                if(isset($a[1])){
                    $a[1] = str_replace('右', '_r_', $a[1]);
                    $a[1] = str_replace('左', '_l', $a[1]);
                }

            }
            $new = $a[0].'_'.$a[1];
            // $images
            if($fn!='.'&&$fn!='..'){
                // echo "<br>将名为：".$fn."\n\r";
                $curDir = $dirname.'/'.$fn;
                if(is_dir($curDir)){
                    fRename($curDir);
                }else{
                    $path = pathinfo($curDir);
                    //改成你自己想要的新名字
                    $newname = $path['dirname'].'/'.$new;
                    $fn = iconv('GB2312', 'UTF-8', $newname);
                    echo $newname.PHP_EOL;
                    echo $curDir.PHP_EOL;
                    // echo "替换成:".$i.'.'.$path['extension']."\r\n";
                    $res = rename($curDir,$newname);
                    var_dump($res);
                    $i++;
                }
            }
        }
    }


}
