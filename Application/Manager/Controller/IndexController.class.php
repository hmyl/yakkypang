<?php
namespace Manager\Controller;
// use Think\Controller;
use Manager\Controller\CommonController;
class IndexController extends CommonController {
    public function index(){
        /*$wk = I('get.wd','','htmlspecialchars');
    	$re = D('DanWei')->laodList($wk);
        if($re['list']){
            foreach ($re['list'] as &$v) {
                $v['mingcheng'] = str_replace($wk, '<span style="color:red;">'.$wk.'</span>', $v['mingcheng']);
            }
        }
    	$this->assign($re);*/
        // p(session());
        $this->display();
    }
    public function uplaod(){
    	$this->display();
    }
    //上传文件
    public function uploadFile(){
    	$config = array(
    	    'maxSize'    =>    3145728,
    	    'rootPath'   =>    C('uploadPath'),
    	    'savePath'   =>    '',
    	    'saveName'   =>    array('uniqid',''),
    	    'exts'       =>    array('jpg', 'gif', 'png', 'jpeg','xls','xlsx'),
    	    'autoSub'    =>    true,
    	    'subName'    =>    array('date','Ymd'),
    	);
    	$upload = new \Think\Upload($config);// 实例化上传类
	    // 上传文件 
	    $info   =   $upload->upload();
	    // p($info);
	    if(!$info) {// 上传错误提示错误信息
	        $this->error($upload->getError());
	    }else{// 上传成功
	        // $re = $this->success('上传成功！');
	        $model = D('Upload');//保存到库
	        $data['file_size'] = formart_size($_FILES['excel']['size']);
	        $data['file_name'] = $_FILES['excel']['name'];
	        $data['file_path'] = $config['rootPath'].$info['excel']['savepath'].$info['excel']['savename'];
	        $model->addData($data);
	    }
    }
    // 导入数据
    public function importData(){
    	$id = I('id','intval');
    	if(empty($id))exit('缺失参数');
    	$re = D('Upload')->loadById($id);
    	if(file_exists($re['file_path'])){
    		$excelData = read_excel($re['file_path'],['Sheet1','Sheet3']);
    		p($excelData);
    	}else{
    		p('文件不存在');
    	}
    }
    // 添加扶贫单位
    public function add(){
        $this->display();
    }
    // 添加扶贫单位数据处理
    public function addHandle(){
        if(!IS_POST) exit('非法请求');
        $data['mingcheng']  = I('post.mingcheng','');
        $data['lianxiren']  = I('post.lianxiren','');
        $data['lianxi_dianhua']  = I('post.lianxi_dianhua','');
        $data['memo'] = I('post.memo','');
        if($pid = I('post.pid',0,'intval'))
            $data['pid'] = $pid;
        if(!$data['mingcheng'])
            $this->error('单位名称不能为空','',true);
        if(!$data['lianxiren'])
            $this->error('联系人姓名不能为空','',true);
        if(!$data['lianxi_dianhua'])
            $this->error('联系人电话不能为空','',true);
        $model = D('DanWei');
        if($pid){//修改数据
            $re = $model->addData($data);
            if($re) $this->success('修改成功',U('index'),true);
            else $this->error('修改失败','',true);
        }else{//添加新数据
            if($model->loadByNameAndTel($data)){
                $this->error('该数据已经存在，无需重复添加','',true);
            }else{
                $re = $model->addData($data);
                if($re) $this->success('添加成功',U('index'),true);
                else $this->error('添加失败','',true);
            }
        }
    }
    /**
     * [del 删除帮扶单位]
     * @return [type] [description]
     */
    public function del(){
        $pid = I('get.pid',0,'intval');
        if($pid){
            $re = M('danwei')->where(array('pid'=>$pid))->delete();
            if($re)
                $this->success('删除成功',U('index'));
            else
                $this->error('删除失败','',1);
        }else{
            $this->error('缺少参数','',1);
        }
    }
    function villageTeamList(){
        $page  = I('page');
        $limit = I('limit',10);
        $keyword = I('keyword');
        $list = D('Gongzuodui')->getTeamList($keyword,$page,$limit);
        $this->assign('list',$list);
        $this->display('village_team_list');
    }

    public function edit(){
        $pid = I('get.pid',0,'intval');
        if(!IS_GET)exit('非法请求');
        $model = D('DanWei');
        $re = $model->loadById($pid);
        $this->assign($re);
        $this->display('add');
    }
    /**
     * 添加/编辑工作队信息
     * @author cxt
     * @date   2016-11-20
     * @return [type]     [description]
     */
    function villageTeamAdd(){
        $team_id = I('id');
        $team = array();
        if(!empty($team_id)){
            $team = D('Gongzuodui')->loadById($team_id);
        }
        if(!empty($team)){
            $this->assign('team',$team);
        }
//        dump($team);exit;
        //查找所有用户
        $user = D('User')->userList();
        $this->assign('user',$user);
        // var_dump($team['duizhang']);
        // dump($user);exit;
        $this->display('village_team_add');
    }
    //保存驻村工作队信息
    function saveVillageTeam(){
        if(!IS_POST){
            $this->error("非法请求");
        }
        $returnData = array('code'=>0,'info'=>'操作成功','data'=>'');
        $data = array(
            'pid' => I('post.pid'),
            'mingcheng' => I('post.mingcheng'),
            'duizhang'  => I('post.duizhang'),
            'duizhang_name'=>I('post.duizhang_name'),
            'memo'  => I('post.memo'),
            'ptime' => time()
            );
        $teammember = I('post.duiyuan_id');
        $team = D('Gongzuodui');
        $result = false;
        $team_id = 0;
        if(!empty($data['pid'])){
            $result = $team->updateTeam($data);
            $team_id = $data['pid'];
        }else{
            $result = $team->addTeam($data);
            $team_id = $result;
        }
        
        if($result){
            if(!empty($teammember) && is_array($teammember)){
                foreach ($teammember as $k => $v) {
                    $res = D('TeamMember')->where(['duiyuanid'=>$v,'gongzuoduiid'=>0,'status'=>0])->save(['gongzuoduiid'=>$team_id,'updatetime'=>time()]);
                    if(!$res){
                        \Think\Log::write('添加队员到工作队失败，队员id:'.$v.' 工作队id：'.$team_id,'ERROR');
                    }
                }
            }
            $returnData['data']['team_id'] = $team_id;
            $this->ajaxReturn($returnData);
        }else{
            $error = $team->getError();
            $returnData = array('code'=>-1,'info'=>'操作失败','data'=>$error);
            $this->ajaxReturn($returnData);
        }
    }
    /**
     * [zeRenRen 帮扶责任人列表]
     * @return [type] [description]
     */
    public function zeRenRen(){
        $wk = I('get.wd','','htmlspecialchars');
        $re = D('Zerenren')->laodList($wk);
        if($re['list']){
            foreach ($re['list'] as &$v) {
                $v['mingcheng'] = str_replace($wk, '<span style="color:red;">'.$wk.'</span>', $v['mingcheng']);
            }
        }
        $this->assign($re);
        $this->display();
    }
    /**
     * [addZeRenRen 添加帮扶责任人]
     */
    public function zeRenRenAdd(){
        if(IS_POST){
            $data = I('post.');
            $data['danweiid']  = I('post.danweiid','');
            $data['xingming']  = I('post.xingming','');
            $data['tel']  = I('post.tel','');
            $data['xingbie']  = I('post.xingbie','');
            if($pid = I('post.pid',0,'intval'))
                $data['pid'] = $pid;
            if(!$data['danweiid'])
                $this->error('单位id不能为空','',true);
            if(!$data['xingming'])
                $this->error('帮扶责任人姓名不能为空','',true);
            if(!$data['tel'])
                $this->error('联系人电话不能为空','',true);
            if(!$data['xingbie'])
                $this->error('联系人性别不能为空','',true);
            $model = D('Zerenren');
            if($pid){//修改数据
                $re = $model->addData($data);
                if($re) $this->success('修改成功',U('zerenren'),true);
                else $this->error('修改失败','',true);
            }else{//添加新数据
                if($model->loadByNameAndTel($data)){
                    $this->error('该数据已经存在，无需重复添加','',true);
                }else{
                    $re = $model->addData($data);
                    if($re) $this->success('添加成功',U('zerenren'),true);
                    else $this->error('添加失败','',true);
                }
            }
        }
        $re = D('DanWei')->laodList('',100);
        $this->assign($re);
        $this->display('zerenren_add');
    }
    // 编辑帮扶人
    public function zerenrenedit(){
        $pid = I('get.pid',0,'intval');
        if(!IS_GET)exit('非法请求');
        $model = D('Zerenren');
        $re = $model->loadById($pid);
        $re1 = D('DanWei')->laodList();
        $this->assign($re1);
        $this->assign($re);
        $this->display('zerenren_add');
    }
    /**
     * [zerenrenDel 删除帮扶责任人]
     * @return [type] [description]
     */
    public function zerenrenDel(){
        $pid = I('get.pid',0,'intval');
        if($pid){
            $re = M('zerenren')->where(array('pid'=>$pid))->delete();
            if($re)
                $this->success('删除成功',U('zerenren'));
            else
                $this->error('删除失败','',1);
        }else{
            $this->error('缺少参数','',1);
        }
    }

    //删除工作队（逻辑删除）
    function deleteVillageTeam(){
        if(!IS_POST){
            $this->error('非法请求');
        }
        $returnData = array('code'=>0,'info'=>'删除成功','data'=>'');
        $data['pid'] = I('post.team_id');
        $data['status'] = 1;
        $model = D('Gongzuodui');
        $result = $model->updateTeam($data);
        if($result){
            $this->ajaxReturn($returnData);
        }else{
            $error = $model->getError();
            $returnData = array('code'=>-1,'info'=>'删除失败','data'=>$error);
            $this->ajaxReturn($returnData);
        }
    }
    /**
     * 根据姓名查找用户 默认为全部
     * @date   2016-11-20
     * @return [type]     [description]
     */
    function getUser(){
        $username = I('username');
        $returnData = array('code'=>0,'info'=>'查找成功','data'=>'');
        $user = D('User')->userList($username);
        if($user != false){
            $returnData['data'] = $user;
        }else{
            $returnData['code'] = -1;
            $returnData['info'] = '未找到数据';
        }
        $this->ajaxReturn($returnData);
    
    }

    function firstSecretaryList(){
        $name = I('secretary_name');
        $list = D('Shuji')->lists($name);
        $this->assign('list',$list);
        $this->display('first_secretary');
    }

    function addFirstSecretary(){
        $pid = I('id');
        if(!empty($pid)){
            $shuji = D('Shuji')->loadById($pid);
        }
        if(isset($shuji) && !empty($shuji)){
            $this->assign('shuji',$shuji);
        }
        $xiang = D('Area')->lists();
        $this->assign('xiang',$xiang);
        var_dump($shuji);
        var_dump($xiang);
        $this->display('first_secretary_add');
    }

    function saveFirstSecretary(){
        if(!IS_POST){
            $this->error("非法请求");
        }
        $returnData = array('code'=>0,'info'=>'操作成功','data'=>'');
        $data = array(
            'pid' => I('post.pid'),
            'xiangid' => I('post.xiangid'),
            'xiangmingcheng'  => I('post.xiangmingcheng'),
            'cunid'=>I('post.cunid'),
            'cunmingcheng'  => I('post.cunmingcheng'),
            'xingming'      => I('post.xingming'),
            'dianhua'       => I('post.dianhua'),
            'ptime' => time()
            );
        // dump($data);exit;
        $secretary = D('Shuji');
        $result = false;
        if(!empty($data['pid'])){
            $result = $secretary->updateFirstSecretary($data);
        }else{
            $result = $secretary->addFirstSecretary($data);
        }
        
        if($result){
            $returnData['data']['secretary_id'] = $result;
            $this->ajaxReturn($returnData);
        }else{
            $error = $secretary->getError();
            $returnData = array('code'=>-1,'info'=>$error);
            $this->ajaxReturn($returnData);
        }
    }

    function deleteSecretary(){
        if(!IS_POST){
            $this->error('非法请求');
        }
        $returnData = array('code'=>0,'info'=>'删除成功','data'=>'');
        $data['pid'] = I('post.shuji_id');
        $data['status'] = 1;
        $model = D('Shuji');
        $result = $model->updateFirstSecretary($data);
        if($result){
            $this->ajaxReturn($returnData);
        }else{
            $error = $model->getError();
            $returnData = array('code'=>-1,'info'=>$error,'data'=>$error);
            $this->ajaxReturn($returnData);
        }
    }

    function addTeamMember(){
        $data = array(
            'gongzuoduiid' => I('post.gongzuoduiid'),
            'duiyuanid'     => I('post.duiyuanid'),
            'duiyuanxingming'   => I('post.duiyuanxingming'),
            'dianhua'       => I('post.dianhua'),
            'danwei'        => I('post.danwei'),
            'guanxi'        => I('post.guanxi')
            );
        $model = D('TeamMember');
        $result = $model->addMember($data);
        if($result && $result != -100){
            $returnData = array('code'=>0,'info'=>'添加成功','data'=>'');
            $this->ajaxReturn($returnData);
        }elseif($result == -100){
            $returnData = array('code'=>-1,'info'=>'队员已在工作队中，请勿重复添加','data'=>'');
            $this->ajaxReturn($returnData);
        }else{
            $error = $model->getError();
            $returnData = array('code'=>-1,'info'=>$error,'data'=>$error);
            $this->ajaxReturn($returnData);
        }
    }

    function removeTeamMember(){
        $team_id = I('post.gongzuoduiid');
        $member_id = I('post.duiyuanid');

        if(empty($team_id) || empty($member_id)){
            $returnData = array('code'=>-1,'info'=>'缺少参数');
            $this->ajaxReturn($returnData);
        }
        $result = D('TeamMember')->removeTeamMember($team_id,$member_id);
        if($result){
            $returnData = array('code'=>0,'info'=>'删除成功');
            $this->ajaxReturn($returnData);
        }else{
            $returnData = array('code'=>-1,'info'=>'删除失败');
            $this->ajaxReturn($returnData);
        }
    }
}




