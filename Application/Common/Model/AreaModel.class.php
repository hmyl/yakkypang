<?php
/**
* model for table 'fp_shuji'
*/
namespace Common\Model;
use Think\Model;
class AreaModel extends Model
{
	public function lists($xiangid=0){
		return $this->where('xiangid='.$xiangid)->select();
	}
}