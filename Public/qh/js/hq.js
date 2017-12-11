$(function() {
	var asider = $("#aside");
	var w_w = $(window).width()-212;
	$("#mainContent").width(w_w);
	setTimeout(function(){
		var mainContent = $("#mainContent");
		var h = mainContent.height();
		if(h>768){
			asider.height(h);
		}
	},500);
	
	// var subTabBox = $("#subTabBox");
	// $("#subTabBtn").click(function(){
		// if(subTabBox.hasClass('on')){
			// subTabBox.removeClass('on');
		// }else{
			// subTabBox.addClass('on');
		// }
		
	// });
	/*$(".list a").on("click",function(){
		$(this).next().toggle();
	});*/
	$('li div.sub-title a').on("click",function(){
		var _this = $(this);
		_this.toggleClass('active');
		_this.parent('.sub-title').next().toggle();
		_this.parents('li').siblings('li').find('.dropdown-menu').removeClass('active');
		_this.parents('li').siblings('li').children('a').removeClass('active');
		_this.parents('li').siblings('li').find('.sub-list-box').hide();

	});
	$('.list li').each(function(index, el) {
		var active = $(this).find('.sub-title > a').hasClass('active')
		if(active){
			$(this).find('.sub-list-box').show();
		}else{
			$(this).find('.sub-list-box').hide();
		}
	});


	 $("#aside .sub-list-box a").each(function(index,el){
        //$(this).attr('href').indexOf(location.pathname)
        if(location.pathname.indexOf("/index/index.html")>=0){

        }else if($(this).attr('href').indexOf(location.pathname)>=0){
          $(this).parents(".sub-item").addClass("selected");
          $(this).parents(".sub-list-box").show();
          $(this).parents(".sub-list-box").siblings(".sub-title").find("a").addClass('active');
        }
    })
})


