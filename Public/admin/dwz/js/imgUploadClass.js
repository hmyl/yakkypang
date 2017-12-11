/**
 * @author 向军 xiangjun@daxiangclass.com
 * 该库对web uploader进行了图片上传功能封装
 * 目的：一为了在一个页面支持单子和多做上传；二为可以替换页面修改
 * 
 */
/*
 * success
 */
 function grabSuccess(msg){
    alertMsg.correct(msg);
 }
  /*
 * tip
 */
 function grabTip(msg){
    grabSuccess(msg);
 }
/*
 * error
 */
 function grabError(msg){
    alertMsg.error(msg);
 }
  /*
 * success
 */
 function grabWarn(msg){
    alertMsg.warn(msg);
 }
/*
 * info
 */
 function grabInfo(msg){
    alertMsg.info(msg);
 }
/**
* res json{code:0,img_url:xxx,msg:xxx}
*
*/
function handlerImgUploader(file,res,$curPicker){
        if(res.code == 0){
                var img_url = res.url;
                // var img_url = 'http://static.zhaogeshier.com/dist/www/v2/img/index/index-time-live-pic01.jpg';
                var isOne = $curPicker.hasClass('img-one');
                var isMore = $curPicker.hasClass('img-more');
                var $imgShow = $curPicker.siblings(".img-show");
                var iptName = $imgShow.attr("data-input-name");
                var sTemp =  '';
                sTemp += '<div class="pic-box">';
                sTemp += '<span class="close_img"></span>';
                sTemp += '<img src="'+img_url+'">';
                sTemp += '<input type="hidden" name="'+iptName+'" value="'+img_url+'">';
                sTemp += '</div>';
                if(isOne){
                        $imgShow.html(sTemp);
                }else if(isMore){
                        $imgShow.append(sTemp);
                }else{
                        grabInfo("you have uploaded the picture before");
                }
        }else{
            grabError(res.massage);
        }

}
function onAddBind($parents){
        // Web Uploader实例
     $parents.find('.img-picker').each(function() {
            var $btn = $(this);
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                // 自动上传。
                auto: true,
                // swf文件路径
                swf: BASE_URL+'/webuploader-0.1.5/Uploader.swf',
                // 文件接收服务端。
                server: SERVER_URL,
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: this,
                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                duplicate: true
            });
            // 上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function(file,res) {
                handlerImgUploader(file,res,$btn);
            });

            // 文件上传失败，现实上传出错。
            uploader.on('uploadError', function(file) {
                grabError('upload Error');
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function(file) {
               // alert("完成上传完了，成功或者失败，先删除进度条。");
            });

        });
}
function bindImgRemove(con_box_id){
        $(con_box_id).find('.img-show').on('click','.pic-box .close_img',function(){
            var $picBox = $(this).parents('.pic-box');
            $picBox.remove();
        });
}
function bindImgPicker(con_box_id){
    bindImgRemove(con_box_id);
        // Web Uploader实例
     $(con_box_id).find('.img-picker').each(function() {
            var $btn = $(this);
            // 初始化Web Uploader
            var uploader = WebUploader.create({
                // 自动上传。
                auto: true,
                // swf文件路径
                swf: BASE_URL+'/webuploader-0.1.5/Uploader.swf',
                // 文件接收服务端。
                server: SERVER_URL,
                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: this,
                // 只允许选择文件，可选。
                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                duplicate: true
            });
            // 上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function(file,res) {
                handlerImgUploader(file,res,$btn);
            });
            // 文件上传失败，现实上传出错。
            uploader.on('uploadError', function(file) {
                grabError('upload Error');
            });
            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function(file) {
               // alert("完成上传完了，成功或者失败，先删除进度条。");
            });

        });
}

