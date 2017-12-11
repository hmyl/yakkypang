
/*
* author : xiangjun@daxiangclass.com
*
*/
/*
* default usual time
*/
// var timeRangeJson = {
// 	start:{hh:'09',mm:'30'},
// 	end  :{hh:'21',mm:'00'}
// }
function grabSelectSDD(con_box_id,timeRangeJson){

	if(timeRangeJson==undefined){
		/*
		* default usual time
		*/
		timeRangeJson = {
			start:{hh:'09',mm:'30'},
			end  :{hh:'21',mm:'00'}
		}
	}
	$(con_box_id).find('.selectTimeRange').click(function(){
		$('#timeRange_div').remove();
		
		var hourOpts = '';
		for (i=0;i<24;i++){
			if(i<10){
				hourOpts += '<option>0'+i+'</option>'
			}else{
				hourOpts += '<option>'+i+'</option>'
			}
		};
		var minuteOpts = '<option>00</option><option>10</option><option>20</option><option>30</option><option>40</option><option>50</option>';
		
		var html = $('<div id="timeRange_div"><select id="timeRange_a">'+hourOpts+
			'</select><em class="time-flag one">:</em><select id="timeRange_b">'+minuteOpts+
			'</select><em class="time-flag two">-</em><select id="timeRange_c">'+hourOpts+
			'</select><em class="time-flag three">:</em><select id="timeRange_d">'+minuteOpts+
			'</select><input type="button" value="ok" id="timeRange_btn" /></div>')
			.css({
				"position": "absolute",
				"z-index": "999",
				"left":"131px",
				"padding": "5px",
				"border": "1px solid #AAA",
				"background-color": "#FFF",
				"box-shadow": "1px 1px 3px rgba(0,0,0,.4)"
			})
			.click(function(){return false});
		// 如果文本框有值
		var v = $(this).siblings('input').val();
		if (v) {
			v = v.split(/:|-/);
			html.find('#timeRange_a').val(v[0]);
			html.find('#timeRange_b').val(v[1]);
			html.find('#timeRange_c').val(v[2]);
			html.find('#timeRange_d').val(v[3]);
		}else{
			html.find('#timeRange_a').val(timeRangeJson.start.hh);
			html.find('#timeRange_b').val(timeRangeJson.start.mm);
			html.find('#timeRange_c').val(timeRangeJson.end.hh);
			html.find('#timeRange_d').val(timeRangeJson.end.mm);
		}
		// 点击确定的时候
		var pObj = $(this).siblings('input');
		html.find('#timeRange_btn').click(function(){
			var str = html.find('#timeRange_a').val()+':'
				+html.find('#timeRange_b').val()+'-'
				+html.find('#timeRange_c').val()+':'
				+html.find('#timeRange_d').val();
			pObj.val(str);

			//把值保存到隐藏域中
			$('#timeRange_div').remove();
		});
		
		$(this).siblings('input').after(html);
		return false;
	});
}
