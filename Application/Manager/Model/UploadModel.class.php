<?php 
namespace Manager\Model;
use Think\Model;
use Think\page;
class UploadModel extends Model{
	protected $tableName = 'upload';
	public function addData($data){
		if(empty($data))return false;
		$data['ctime'] =time();
		return $this->add($data);
	}
	public function loadExcel(){
		$count      = $this->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,25);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $this->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		return ['list'=>$list,'page'=>$show];
	}
	public function loadById($id){
		if(empty($id))return false;
		return $this->where(['id'=>$id])->find();
	}
}