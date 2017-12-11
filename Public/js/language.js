var lang_flag = true;
var collection = ['COLLECTION','系列'];
var about = ['ABOUT US','關於我們'];
var contact = ['CONTACT','聯繫我們'];
var lang = ['LANGUAGE','語言'];
var link = ['LINK','鏈接'];
var language = [['COLLECTION','系列'],['ABOUT US','關於我們'],['CONTACT','聯繫我們'],['LANGUAGE','語言'],['LINK','鏈接']];
var langth = $('.lang').length;
function fun(event){
	event.stopPropagation();
	$('.list_2_wrap').toggle();
	$('.list_1_wrap ').hide();
	
}
function english(){
	$(this).css('background','red');
	for (var i = 0; i < language.length; i++) {
		$('.lang').eq(i).text(language[i][0])
		console.log(language[i][0])
	}

	// alert(0)
}
function chinese(){
	$(this).css('background','red');
	
	for (var i = 0; i < language.length; i++) {
			// console.log(language[i][0])
		$('.lang').eq(i).text(language[i][1]);
		console.log(language[i][1])
	}
}

var currentUrl = this.location.href
var s=currentUrl.indexOf("=");
var t=currentUrl.substring(s+1);
function getUrlParam(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
    var r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if (r != null) return unescape(r[2]); return ''; //返回参数值
}
var zh = getUrlParam('zh');
if(zh == 'cn'){
	chinese();
}else{
	english();
}
