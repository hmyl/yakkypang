<?php 
/**
 * 扶贫活动模型
 */
namespace Common\Model;
use Think\Model;

class ErrorModel extends Model{

    protected $tableName = 'error_recovery';
    protected $_auto = array (
        array('create_time','time',1,'function'),
        array('update_time','time',2,'function'),

    );
    public function get_time(){
        return date('Y-m-d H:i:s');     
    }
    public function get_ymd(){
        return date('Y-m-d');
    }
    /*protected $_validate = array(
        array('name','require','名称不能为空',3), 
        array('name','','名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
    );*/
    public function lists($page=1,$rows=20){
        $content = I('post.name','');
        $error_type = I('post.error_type','');
        $status = I('post.status','');

        if($content){
            $map['name'] = ['like',"%{$content}%"];
        }
        if($status){
            $map['status'] = $status;
        }
        if($error_type){
            $map['error_type']  = $error_type;
        }

        $re = $this->where($map)->page($page.','.$rows)->select();
        // echo $this->_sql();die;
        return $re;
    }
    //饼数据
    public function loadByGroupName(){
        $map['status'] = 1;
        $start = I('post.start_time','');
        $end = I('post.end_time','');
        $content = I('post.name','');

        if($content){
            $map['name'] = $content;
        }
        if($start&&$end){
            $map['activity_time']  = array('between',array($start,$end));
        }else{
            if($start||$end)
                $map['activity_time'] = $start?$start:$end;
        }
        $sql = 'select name,count(*) num from fp_poverty_allevation_activity group by name';
        $re = $this->where($map)->field(array("count(name)"=>"num", "name"))->group('name')->select();

        return $re;

    }
    public function loadById($id){
        if(empty($id))
            return false;
        return $this->where(['id'=>$id])->find();
    }
    public function listsByStatus($status=1){
        return $this->where(['status'=>$status])->select();
    }
/**
     * [createData 创建数据]
     * @param  [type] $data [array ]
     * @return [type]       [description]
     */
    public function createData(){
        $data = $this->create();
        if(!$data){
            $msg = ['code'=>300,'msg'=>$this->getError()] ;
            return $msg;
        }
        foreach ($data as &$v) {
            $v = trim($v);
        }
        if(empty($data['activity_time'])){
            $data['activity_time'] = substr($data['activity_time'], 0,10);
        }
        if(isset($data['id'])){
            $res_add = $this->save($data);
            $msg = ['code'=>200,'msg'=>'修改成功'] ;
        }else{
            $res_add = $this->add($data);
            $msg = ['code'=>200,'msg'=>'添加成功'] ;
        }
        if(!$msg)
            $msg = ['code'=>300,'msg'=>'操作失败'] ;
        return $msg;
    }
    /**
     * 脱贫人口列表
     * @return [type] [description]
     */
    public function getOutPoorList($name,$town_id,$village_id,$help_id,$help_way_id,$poor_cause_id,$page=1,$limit=20){
        if(!empty($name)){
            $map['name'] = array('like','%{$name}%');
        }
        if(!empty($town_id)){
            $map['town_id'] = $town_id;
        }
        if(!empty($village_id)){
            $map['village_id'] = $village_id;
        }
        if(!empty($town_id)){
            $map['help_id'] = $help_id;
        }
        if(!empty($town_id)){
            $map['help_way_id'] = $help_way_id;
        }
        if(!empty($town_id)){
            $map['poor_cause_id'] = $poor_cause_id;
        }
        if(!empty($map)){
            $res = $this->where($map)->page($page.','.$limit)->select();
            $total = $this->where($map)->count();
        }else{
            $res = $this->page($page.','.$limit)->select();
            $total = $this->count();
        }

        return array(
            'list' => $res,
            'total' => $total
            );

    }
    /**
     * [del description 删除]
     * @param  [type] $ids [ID  array(1,2,3,4)]
     * @return [type]      [description]
     */
    public function del($ids){
        foreach ($ids as $v) {
            $re = $this->save(['status'=>2,'id'=>$v]);
        }
        if($re)
            $re = ['code'=>'ok','msg'=>'处理成功'];
        else
            $re = ['code'=>1,'msg'=>'处理失败'];
        return $re;
    }
    public function loadByName($name){
        return $this->where(['name'=>$name,'status'=>1])->find();
    }
}


 ?>