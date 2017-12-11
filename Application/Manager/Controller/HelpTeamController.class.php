<?php
/**
* 帮扶队伍
*/
namespace  Manager\Controller;
use Manager\Controller\CommonController;
class HelpTeamController extends CommonController
{
    /**
     * 帮扶队伍人员列表
     * @return [type] [description]
     */
    function getHelpTemList(){
        $team_id = I('team_id',0);
        $page = I('page',1);
        $limit  = I('limit',20);
        $name = I('name','');
        $tel = I('tel','');
        $result = D('HelpTeam')->lists($page,$name,$limit,$team_id,$tel);
        if($result){
            $data['list'] = $result['data'];
            $data['total'] = $result['count'];
            $this->returnAjax(0,$data);
        }else{
            $this->returnAjax(1);
        }
    }
    /**
     * 添加／修改 队员
     */
    function saveTeamMember(){
        $data = I('post.*');
        $check = $this->checkInput($data);
        if($check['code'] != 0){
            $this->returnAjax($check['code']);
        }
        $result = D('HelpTeam')->createData($data);
        if($result['code'] == 200){
            $this->returnAjax(0);
        }else{
            $this->returnAjax($result['code'],'',$result['msg']);
        }
    }

    function delTeamMember(){
        $ids = I('post.ids');
        $result = D('HelpTeam')->delTeamMember($ids);
        $this->returnAjax($return_data['code']);
    }
    /**
     * 检验输入数据
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    function checkInput(&$data){
        $return_data = array('code'=>-1,'info'=>'','data'=>'');
        if(empty($data['name'])){
            $return_data['code'] = 1005;
            retutn $return_data;
        }
        if(empty($data['login_name'])){
            $return_data['code'] = 1006;
            retutn $return_data;
        }
        if(empty($data['role'])){
            $return_data['code'] = 1007;
            retutn $return_data;
        }
        if(!empty($data['tel']) && !iis_mobile($data['tel'])){
            $return_data['code'] = 1008;
            retutn $return_data;
        }
    }

}