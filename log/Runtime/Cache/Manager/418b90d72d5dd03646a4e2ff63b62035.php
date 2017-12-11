<?php if (!defined('THINK_PATH')) exit();?><h2 class="contentTitle"><?php if($id): ?>编辑<esle />新增<?php endif; ?></h2>
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/uploadify/css/uploadify.css">
<div id="topic_add_box" class="pageContent">
    <form method="post" action="<?php echo U('IntoHelp/addPlan');?>"  class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <div class="pageFormContent" layoutH="96">
            <div class="unit">
                <label>系列名称 :</label>
                <input type="text" name="name" value="<?php echo ($name); ?>" placeholder="活动名称"/>
            </div>
            

            <!--  <div class="unit">
               <label>入户时间:</label>
               <input type="text" value="<?php echo (substr($help_time,0,10)); ?>" dateFmt="yyyy-MM-dd" minDate="2000" name="help_time"  class="date" readonly="true"/>
               <a class="inputDateButton" href="javascript:;">选择</a>
                        </div> -->
            <div class="unit">
                <label style="">描述:</label><textarea name="desc" id="" cols="30" rows="5"><?php echo ($desc); ?></textarea>
            </div>
            <div class="unit">
                <label>操&nbsp;&nbsp;作：</label>
                <div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div>
                <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div>
            </div>
        </div>  
        <?php if($id): ?><input type="hidden" name="id" value="<?php echo ($id); ?>"><?php endif; ?>
    </form>
</div>
<script type="text/javascript">
    $(function(){
        // 初始化时间选择
        initSellerTimePick("#topic_add_box");
        //初始化并绑定图片上传
        bindImgPicker("#topic_add_box");

          $('#hq2017').viewer({
            url: 'data-original',
          });
    });
</script>