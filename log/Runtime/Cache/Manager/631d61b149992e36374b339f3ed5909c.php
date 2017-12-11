<?php if (!defined('THINK_PATH')) exit();?><style>
    .publish_picture_list{
        float: left;
        padding: 2px;
    }
</style>
<h2 class="contentTitle"><?php if($id): ?>编辑<esle />新增<?php endif; ?>图片</h2>
<link rel="stylesheet" type="text/css" href="/Public/admin/dwz/uploadify/css/uploadify.css">
<div id="topic_add_box" class="pageContent">
    <form method="post" action="<?php echo U('IndexImages/addImages');?>"  class="pageForm required-validate" onsubmit="return validateCallback(this,navTabAjaxDone);">
        <div class="pageFormContent" layoutH="96">
            <div class="unit">
                <div style="float: left;">
                    <label style="">首页图片:</label>
                </div>
                <div style="float: left;"> 
                    <div class="general_style" >
                        <?php if($photo): ?><div  class="publish_picture_list" >
                            <div class="publish_picture_img"><img width="200" height="200" src="<?php echo ($photo); ?>" alt=""> </div>
                            <button type="button" class="publish_picture_delet" >删除</button>
                            <input class="state" type="hidden" name="photo" value="<?php echo ($photo); ?>" />
                        </div><?php endif; ?>
                        <div class="btns" style="float: left;">
                            <div id="photo">选择</div>
                        </div>
                    </div>
                    
                </div>
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
    var server = '<?php echo U("IndexImages/oneUpload");?>';
    $(function(){
        // 初始化时间选择
        initSellerTimePick("#topic_add_box");
        //初始化并绑定图片上传
        bindImgPicker("#topic_add_box");

          $('#hq2017').viewer({
            url: 'data-original',
          });
    });
    $(function(){
        jQuery(function() {
            var $ = jQuery,
                    ratio = window.devicePixelRatio || 1,
                    // 缩略图大小
                    thumbnailWidth = 200 * ratio,
                    thumbnailHeight = 200 * ratio,
                    uploader,
                    uploader1
                    ;
            uploader = WebUploader.create({
                auto: true,
                resize: false,
                swf: 'https://cdn.staticfile.org/webuploader/0.1.5/Uploader.swf',
                server : server,
                pick: '#photo',
                // 只允许选择文件，可选。
                accept: {
                    // title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    // mimeTypes: 'image/*'
                },
                fileSingleSizeLimit:5242880,
                fileNumLimit:8,
                duplicate:true,
                multiple:true,
                thumb:{
                    // 图片质量，只有type为`image/jpeg`的时候才有效。
                    quality: 100,

                    // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
                    allowMagnify: false,

                    // 是否允许裁剪。
                    crop: false,

                    // 为空的话则保留原有图片格式。
                    // 否则强制转换成指定的类型。
                    type: 'image/jpeg'
                }
            });
            uploader.on( 'fileQueued', function( file ) {
                var $list = $('.btns');
                    uploader.makeThumb( file, function( error, src ) {
                        if ( error ) {
                            $img.replaceWith('<span>不能预览</span>');
                            return;
                        }
                        var img = '<img src="'+src+'" />';
                        var $li = $(
                                '<div  class="publish_picture_list" id="' + file.id + '" >'+
                                    '<div class="publish_picture_img">'+ img +'</div>'+
                                    '<button type="button" class="publish_picture_delet" >删除</button>'+
                                    '<input class="state" type="hidden" name="photo" />'+
                                '</div>'
                                );
                        $list.siblings('div.publish_picture_list').remove();
                        $list.before($li);
                        $('.publish_picture_delet').click(function(event) {
                            $(this).parent('.publish_picture_list').remove();
                        });
                    }, thumbnailWidth, thumbnailHeight );
            });
            uploader.on( 'uploadSuccess', function( file,res) {
                if(res.status == '0'){
                    $( '#'+file.id ).remove();
                    layui.layer.msg(res.massage, {time: 1000});return false;
                }
                $( '#'+file.id ).find('input.state').val(res.url);
            });
            uploader.on( 'uploadError', function( file ) {
                $( '#'+file.id ).find('p.state').text('上传出错');
            });
            uploader.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').fadeOut();
            });
            uploader.on('error',function(res){
                if(res=='Q_TYPE_DENIED'){
                  alert('文件类型不支持')
                }
                if(res=='F_EXCEED_SIZE'){
                  alert('文件不能大于5M');
                }
            });

            // 详图
            uploader1 = WebUploader.create({
                auto: true,
                resize: false,
                swf: 'https://cdn.staticfile.org/webuploader/0.1.5/Uploader.swf',
                server : server,
                pick: '#images',
                // 只允许选择文件，可选。
                accept: {
                    // title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    // mimeTypes: 'image/*'
                },
                fileSingleSizeLimit:5242880,
                fileNumLimit:8,
                duplicate:true,
                multiple:true,
                thumb:{
                    // 图片质量，只有type为`image/jpeg`的时候才有效。
                    quality: 100,

                    // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
                    allowMagnify: false,

                    // 是否允许裁剪。
                    crop: false,

                    // 为空的话则保留原有图片格式。
                    // 否则强制转换成指定的类型。
                    type: 'image/jpeg'
                }
            });
            uploader1.on( 'fileQueued', function( file ) {
                var $list = $('.btns1');
                    uploader.makeThumb( file, function( error, src ) {
                        if ( error ) {
                            $img.replaceWith('<span>不能预览</span>');
                            return;
                        }
                        var img = '<img src="'+src+'" />';
                        var $li = $(
                                '<div  class="publish_picture_list" id="' + file.id + '" >'+
                                    '<div class="publish_picture_img">'+ img +'</div>'+
                                    '<button type="button" class="publish_picture_delet" >删除</button>'+
                                    '<input class="state" type="hidden" name="images[]" />'+
                                '</div>'
                                );
                        $list.before($li);
                        $('.publish_picture_delet').click(function(event) {
                            $(this).parent('.publish_picture_list').remove();
                        });
                    }, thumbnailWidth, thumbnailHeight );
            });
            uploader1.on( 'uploadSuccess', function( file,res) {
                if(res.status == '0'){
                    $( '#'+file.id ).remove();
                    layui.layer.msg(res.massage, {time: 1000});return false;
                }
                $( '#'+file.id ).find('input.state').val(res.url);
            });
            uploader1.on( 'uploadError', function( file ) {
                $( '#'+file.id ).find('p.state').text('上传出错');
            });
            uploader1.on( 'uploadComplete', function( file ) {
                $( '#'+file.id ).find('.progress').fadeOut();
            });
            uploader1.on('error',function(res){
                if(res=='Q_TYPE_DENIED'){
                  alert('文件类型不支持')
                }
                if(res=='F_EXCEED_SIZE'){
                  alert('文件不能大于5M');
                }
            });


        });
        $('.publish_picture_delet').click(function(event) {
            $(this).parent('.publish_picture_list').remove();
        });
    })
</script>