function showPic(src){
	var html = '<div id="daxiang-showPic"><img src="'+src+'"></div>';
	var showPicObj = $(html);
	showPicObj.css({
		'position':'absolute',
		'top':'0px',
		'cursor':'pointer',
		'z-index':'999999',
		'left':'0'
		
	});
	$('body').append(showPicObj);
	showPicObj.bind('click',function(){
		showPicObj.remove();
	});
}