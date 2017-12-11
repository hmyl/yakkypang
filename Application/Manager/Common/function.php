<?php
// 公共函数
/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
 function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
 function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}
function tree(&$list,$pid=0,$level=0,$html='━'){
    static $tree = array();
    foreach($list as $v){
        if($v['pid'] == $pid){
            $v['sort'] = $level;
            if($level>1)
                $v['html'] = '┗'.str_repeat($html,$level-1);
            elseif($level==1)
                $v['html'] = '┗';
            else
                $v['html'] = '';
            $tree[] = $v;
            tree($list,$v['id'],$level+1);
        }
    }
    return $tree;
}
function dwz_error($msg='',$code=400){
    dwz_return($msg='',$forwardUrl='',$callbackType='',$navTabId='',$confirmMsg='',$rel='',$code);
}
/**
 * [dwz_return dwz  返回值]
 * @param  string $msg          [提示信息]
 * @param  string $forwardUrl   [跳转地址]
 * @param  string $callbackType [回调处理方式 如：closeCurrent  关闭页面]
 * @param  string $navTabId     [刷新的列表 u_list]
 * @param  string $confirmMsg   [description]
 * @param  string $rel          [description]
 * @return [type]               [description]
 */
function dwz_return($msg='',$forwardUrl='',$callbackType='',$navTabId='',$confirmMsg='',$rel='',$code=200){
    $code = $code;
    $message = '';
    if(is_array($msg)){
        if(isset($msg['msg'])){
            $message = $msg['msg'];
        }
        if(isset($msg['code'])){
            if(in_array($msg['code'], ['200','300','301']))
                $code = $msg['code'];
        }
    }else{
        $message = $msg;
    }
    $re_arr = [
                "statusCode"=>$code,
                "message"=>$message,
                "navTabId"=>$navTabId,
                "rel"=>$rel,
                "callbackType"=>$callbackType,
                "forwardUrl"=>$forwardUrl,
                "confirmMsg"=>$confirmMsg
            ];
    exit(json_encode($re_arr));
}

function is_mobile($mobile){
    return preg_match('/^1\d{10}$/', $mobile);
}