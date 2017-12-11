<?php
//帮扶措施管理
namespace Manager\Controller;
// use Think\Controller;
use Manager\Controller\CommonController;
class HelpWayController extends CommonController {
    public function index(){
        $p = I('post.pageNum',1);
        $row = I('post.numPerPage',20);
        $keywords = I('post.add_name','');
        $model = D('HelpPlan');
        $re = $model->lists($p,$keywords,$row);
        if($keywords){
            $map['name'] = array('like',"%{$keywords}%");
            $count =  $model->where($map)->count();
        }else{
            $count =  $model->count();
        }
        $assign = array(
                'p'=>$p,
                'count'=>$count,
                'lists'=>$re,
                'row'=>$row,
                'keywords'=>$keywords
            );
        $assign = array_merge($assign,I('post.'));
        $this->assign($assign);

        $c = D('City')->listsField();
        $this->assign('c',$c);
        $d = D('Dictionary')->listsField();
        $this->assign('d',$d);
        $this->addData();
        $this->display();

        

    }
    public function addData(){

        $help = M('Help_team')->select();
        $this->assign('help',$help);
        
        //制贫原因
        $z = D('Dictionary')->loadByName('致贫原因');
        $this->assign('poor_cause_data',$z['data']);

        $town = D('City')->listsByLevel();
        $this->assign('town',$town);
    }
    public function add(){
        $this->addData();
        $id = I('get.id','0','intval');
        if($id){
            $oldData = D('HelpPlan')->loadById($id);
            $help_ids = M('plan_user')->where(['plan_id'=>$id])->select();
            if($help_ids){
                $help_id = implode(',', array_column($help_ids,'user_id'));

            }
            $this->assign('help_id',$help_id?$help_id:'');
            if($oldData['status']==1){
                $this->assign($oldData);
            }else{
                exit('数据错误');
            }
        }

        $this->display();
    }

    // 添加帮扶计划
    public function addPlan(){
        if(!IS_POST){
            $msg = ['code'=>300,'msg'=>'非法访问'];
            dwz_return($msg);
        }
        $re = D('HelpPlan')->createData();
        $list = 'h_list';
        if(isset($_POST['way'])){
            $list = 'j_list';
        }
        dwz_return($re,'','closeCurrent',$list);
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
        $model = D("HelpPlan");
        $re = $model->del($ids);
        dwz_return($re['msg'],'','','h_list');
    }
}