<?php
/**
* model for table fp_minzhupingyi
*/
namespace Common\Model;
use Think\Model;
class MinzhupingyiModel extends Model
{
	protected $_validate = array(
		array('biaohao','require',"编号不能为空"),
		array('shijian','require',"时间不能为空"),
		array('renshu','require',"人数不能为空"),
		array('didian','require',"地点不能为空"),
		array('zhuchiren','require',"主持人不能为空"),
		array('neirong','require',"内容不能为空"),
		array('huamingce','require',"花名册不能为空"),
		array('qiandaoce','require',"签到册不能为空"),
		array('tongjibiao','require',"统计表不能为空"),
		);

	public function listHuiyi($bianhao=null,$page=1,$page_size=10){
		$condition = '1=1';
		if(!empty($bianhao)){
			$condition .= ' and bianhao like "%'.$bianhao.'%"';
		}
		$total =$this->where($condition)->count();
		$Page = new \Think\Page($total,$page_size);
		$show = $Page->show();
		$list = $this->where($condition)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		foreach ($list as $k => &$v) {
			$v['shijian'] = date("Y-m-d",$v['shijian']);
			$v['addtime'] = date("Y-m-d H:i:s",$v['addtime']);
		}
		
		return ['list'=>$list,'page'=>$show];
	}

	public function updateHuiyi($data){
		if(empty($data['id'])){
			return false;
		}
		$data['shijian'] = strtotime($data['shijian']);
		$data['updatetime'] =time();
		if($this->create($data)){
			return $this->save($data);
		}else{
			return false;
		}
	}

	public function addHuiyi($data){
		$data['shijian'] = strtotime($data['shijian']);
		$data['addtime'] = time();
		if($this->create($data)){
			return $this->add();
		}else{
			return false;
		}
	}

	function loadById($id){
		if(empty($id)){
			return false;
		}
		$huiyi = $this->where(['id'=>$id])->find();
		$huiyi['shijian'] = date('Y-m-d',$huiyi['shijian']);
		return $huiyi;
	}
}