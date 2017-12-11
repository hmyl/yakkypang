<?php
/**
* model for 'fp_gongzuodui_duiyuan'
*/
namespace Common\Model;
use Think\Model;
class TeamMemberModel extends Model
{
	
	protected $tableName  = 'gongzuodui_duiyuan';

	protected $_validate = array(
		array('duiyuanid','require','队员id不能为空'),
		array('duiyuanxingming','require','队员姓名不能为空'),
		);

	function addMember($data){
		if(empty($data['duiyuanid'])){
			return false;
		}
		if(!empty($data['gongzuoduiid'])){
			$is_in_team = $this->where(['gongzuoduiid'=>$data['gongzuoduiid'],'duiyuanid'=>$data['duiyuanid'],'status'=>0])->find();
			if($is_in_team){
				return -100;
			}
		}
		$memberInfo = D("User")->where(['uid'=>$data['duiyuanid']])->find();
		$data['duiyuanxingming'] = $memberInfo['user_name'];
		$data['ptime'] = $data['updatetime'] = time();
		if($this->create($data)){
		return $this->add();
		}else{
		return false;
		}
	}


	function removeTeamMember($team_id,$member_id){
		if(empty($team_id) || empty($member_id)){
			return false;
		}
		$where = ['gongzuoduiid'=>$team_id,'duiyuanid'=>$member_id];
		return $this->where($where)->setField('status',1);
	}
}