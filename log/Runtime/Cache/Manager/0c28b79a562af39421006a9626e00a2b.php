<?php if (!defined('THINK_PATH')) exit();?><div class="pageContent" style="padding-left:20px" id="hq2017">
    <?php if(!isset($_GET['way'])): ?><div class="panelBar">
            <ul class="toolBar">
                <li><a class="add" href="<?php echo U('IndexImages/add_series',array('way'=>1));?>" target="navTab" title="新增"><span>新增</span></a></li>
                <li><a class="delete" target="selectedTodo" rel="ids" postType="string" href="<?php echo U('IndexImages/delAll');?>"
                       title="删除"><span>删除</span></a></li>
                <li class="line">line</li>
            </ul>
        </div><?php endif; ?>
    <table width="100%" >
        <thead>
            <tr>
                <th>ID</th>
                <th>缩略图</th>
                <!-- <th>是否显示</th> -->
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($lists)): foreach($lists as $key=>$v): ?><!-- data list  -->
                <tr target="" rel="1">
                    <td><?php echo ($v["id"]); ?></td>
                    <td style="height: 40px;"><img data-original="<?php echo ($v["photo"]); ?>" src="<?php echo (crop($v["photo"],40,40)); ?>" alt=""></td>
                    <td style="display: none;">
                        <?php if($v["status"] == 1): ?><a title="确定隐藏吗？" target="ajaxTodo" href="<?php echo U('IndexImages/isShow',array('ids'=>$v['id'],'status'=>'0'));?>"
                           >隐藏</a>
                        <?php else: ?>
                            <a title="确定显示吗？" target="ajaxTodo" href="<?php echo U('IndexImages/isShow',array('ids'=>$v['id'],'status'=>'1'));?>"
                               >显示</a><?php endif; ?>
                    </td>
                    <td>
                        <a title="编辑<?php echo ($v["name"]); ?>" target="navTab" href="<?php echo U('IndexImages/add_series',array('id'=>$v['id'],'way'=>1));?>"
                           class="btnEdit">编辑</a>
                        <a title="刪除" target="ajaxTodo" href="<?php echo U('IndexImages/delAll',array('ids'=>$v['id']));?>"
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
        url: 'data-original',
      });
    });

</script>