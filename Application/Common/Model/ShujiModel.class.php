<?php
/**
* model for table 'fp_shuji'
*/
namespace Common\Model;
use Think\Model;
class ShujiModel extends Model
{
	protected $_validate = array(
		array('xiangid','require','乡id不能为空'),
		array('xiangmingcheng','require','乡名称不能为空'),
		array('cunid','require','村id不能为空'),
		array('cunmingcheng','require','村名称不能为空'),
		array('xingming','require','书记名称不能为空'),
		array('dianhua','require','电话不能为空')
		);
	
	function loadById($id){
		if(empty($id)){
			return false;
		}
		$condition['pid'] = ':pid';
		$result = $this->where($condition)->bind(':pid',$id)->find();
		if($result){
			$result['ptime_format'] = date("Y-m-d H:is",$result['ptime']);
		}
		return $result;
	}

	function lists($name='',$page_size=10){
		$condition = 'status = 0';
		if(!empty($name)){
			$condition .= ' and xingming like "%'.$name.'%"';
		}

		$total =$this->where($condition)->count();
		$Page = new \Think\Page($total,$page_size);
		$show = $Page->show();
		$list = $this->where($condition)->order('ptime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		return ['list'=>$list,'page'=>$show];
	}
	function addFirstSecretary($data){
		$firstSecretary = $this->create($data);
		if($firstSecretary){
			return $this->add();
		}
		return false;
	}

	function updateFirstSecretary($data){
		if(empty($data['pid'])){
			return false;
		}
		if($this->create($data)){
			return $this->save();
		}else{
			return false;
		}
	}
}