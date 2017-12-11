<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent" id="hq2017">
    <?php if(is_array($lists)): foreach($lists as $k=>$v): endforeach; endif; ?>
    <?php if(!isset($_GET['way'])): ?><div class="panelBar">
        <ul class="toolBar">
            <li><a class="add" href="<?php echo U('IntoHelp/add_series',array('series_id'=>I('get.id'),'name'=>I('get.name')));?>" target="navTab" title="新增"><span>新增</span></a></li>
        </ul>
    </div><?php endif; ?>
    <table class="table" width="100%" layoutH="110">
        <thead>
        <tr>
            <th>序号</th>
            <th>系列名称</th>
            <th>左侧图</th>
            <th>右侧图</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($lists)): foreach($lists as $k=>$v): ?><!-- data list  -->
            <tr target="sid_user" rel="1">
                <td><?php echo ($k+1); ?></td>
                <td><?php echo ($_GET['name']); ?></td>
                <td>
                    <img data-original="<?php echo ($v["photo"]); ?>" width="40" height="40" src="<?php echo (crop($v["photo"],40,40)); ?>" alt="图">
                </td>
                <td>
                    <?php if(is_array($v["images"])): foreach($v["images"] as $k=>$v1): ?><img data-original="<?php echo ($v1); ?>" width="40" height="40" src="<?php echo (crop($v1,40,40)); ?>" alt="图"><?php endforeach; endif; ?>
                </td>
                <td>
                    <?php if($v["status"] == 1): ?><a title="确定隐藏吗？" target="ajaxTodo" href="<?php echo U('IntoHelp/isShow',array('ids'=>$v['id'],'status'=>'0','ser'=>1));?>"
                       >是</a>
                    <?php else: ?>
                        <a title="确定显示吗？" target="ajaxTodo" href="<?php echo U('IntoHelp/isShow',array('ids'=>$v['id'],'status'=>'1','ser'=>1));?>"
                           >否</a><?php endif; ?>
                </td>
                <td>
                    <a title="编辑<?php echo ($v["name"]); ?>" target="navTab" href="<?php echo U('IntoHelp/add_series',array('series_id'=>I('get.id'),id=>$v['id'],'name'=>I('get.name')));?>""
                       class="btnEdit">编辑</a>
                    <a title="刪除" target="ajaxTodo" href="<?php echo U('IntoHelp/delAll',array('ids'=>$v['id'],'ser'=>1));?>"
                       class="btnDel">删除</a>
                </td>
            </tr>
            <!-- data list --><?php endforeach; endif; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">
    $(function() {
        $('#hq2017').viewer({
            url: 'data-original'
        });
    });
</script>