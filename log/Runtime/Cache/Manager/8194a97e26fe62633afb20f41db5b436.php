<?php if (!defined('THINK_PATH')) exit();?><form id="pagerForm" method="post" action="<?php echo U('IntoHelp/index');?>">
    <input type="hidden" name="status" value="">
    <input type="hidden" name="keywords" value="<?php echo ($keywords); ?>"/>
    <input type="hidden" name="pageNum" value="<?php echo ((isset($p) && ($p !== ""))?($p):'1'); ?>"/>
    <input type="hidden" name="numPerPage" value="<?php echo ($row); ?>"/>
    <input type="hidden" name="orderField" value=""/>
</form>


<div class="pageContent" id="hq2017">
    <?php if(!isset($_GET['way'])): ?><div class="panelBar">
            <ul class="toolBar">
                <li><a class="add" href="<?php echo U('IntoHelp/add',array('way'=>1));?>" target="navTab" title="新增"><span>新增</span></a></li>
                <li><a class="delete" target="selectedTodo" rel="ids" postType="string" href="<?php echo U('IntoHelp/delAll');?>"
                       title="删除"><span>删除</span></a></li>
                <li class="line">line</li>
            </ul>
        </div><?php endif; ?>
    <table class="table" width="100%" layoutH="110">
        <thead>
        <tr>
            <?php if(!isset($_GET['way'])): ?><th width="20">全选<input type="checkbox" group="ids" class="checkboxCtrl"></th><?php endif; ?>

            <th>名称</th>
            <th>介绍</th>
            
            
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): foreach($lists as $key=>$v): ?><!-- data list  -->
            <tr target="sid_user" rel="1">
                <?php if(!isset($_GET['way'])): ?><td><input name="ids" value="<?php echo ($v["id"]); ?>" type="checkbox"></td><?php endif; ?>
                <td><a title="查看<?php echo ($v["name"]); ?>系列" target="navTab" rel="IH_list_1" href="<?php echo U('IntoHelp/series',array('id'=>$v['id'],'name'=>$v['name']));?>" ><?php echo ($v["name"]); ?></a></td>
                <td><?php echo ($v["desc"]); ?></td>
                <td>
                    <?php if($v["status"] == 1): ?><a title="确定隐藏吗？" target="ajaxTodo" href="<?php echo U('IntoHelp/isShow',array('ids'=>$v['id'],'status'=>'0'));?>"
                       >隐藏</a>
                    <?php else: ?>
                        <a title="确定显示吗？" target="ajaxTodo" href="<?php echo U('IntoHelp/isShow',array('ids'=>$v['id'],'status'=>'1'));?>"
                           >显示</a><?php endif; ?>
                </td>
                <td>
                    <a title="查看<?php echo ($v["name"]); ?>" target="navTab" rel="IH_list_1" href="<?php echo U('IntoHelp/series',array('id'=>$v['id'],'name'=>$v['name']));?>" >查看</a>
                    <a class="add" href="<?php echo U('IntoHelp/add_series',array('series_id'=>$v['id'],'name'=>$v['name']));?>" target="navTab" title="新增"><span>添加图片</span></a>
                    <a title="编辑<?php echo ($v["name"]); ?>" target="navTab" href="<?php echo U('IntoHelp/add',array('id'=>$v['id'],'way'=>1));?>"
                       class="btnEdit">编辑</a>
                    <a title="刪除" target="ajaxTodo" href="<?php echo U('IntoHelp/delAll',array('ids'=>$v['id']));?>"
                       class="btnDel">删除</a>
                </td>
            </tr>
            <!-- data list --><?php endforeach; endif; ?>
        </tbody>
    </table>
    <div class="panelBar">
        <div class="pages">
            <span>显示</span>
            <select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
                <option value="20"
                <?php if($row == 20): ?>selected="selected"<?php endif; ?>
                >20</option>
                <option value="50"
                <?php if($row == 50): ?>selected="selected"<?php endif; ?>
                >50</option>
                <option value="100"
                <?php if($row == 100): ?>selected="selected"<?php endif; ?>
                >100</option>
                <option value="200"
                <?php if($row == 200): ?>selected="selected"<?php endif; ?>
                >200</option>
            </select>
            <span>条，总共 <?php echo ($count); ?> 条</span>
        </div>
        <div class="pagination" targetType="navTab" totalCount="<?php echo ($count); ?>" numPerPage="<?php echo ($row); ?>" pageNumShown="10"
             currentPage="<?php echo ((isset($p) && ($p !== ""))?($p):'1'); ?>"></div>
    </div>
</div>