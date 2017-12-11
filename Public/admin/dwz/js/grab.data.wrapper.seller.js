function jsonpCallback(res){
	console.log(res)
}
// var __seller_url= 'http://10.6.0.225:8001/api/sellers?jsonp=jsonpCallback&page=1&pageSize=2&callback=back';
var __seller_url= 'http://127.0.0.1/grab/server/jsonp.php';
$.ajax({
     type: "POST",
     url: __seller_url,
     dataType:'JSONP',
     data:{jsonp:'jsonpCallback'},
     success:function(data){
     	alert(111)
     }
  });
