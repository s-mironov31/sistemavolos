//чтобы убрать второй ползунок: range:false и values:[ одно значение ]
$(function() {
var min_ = 30.48;
		$( "#one" ).slider({
			range: true,
			min:min_,
			step:2.54,
			max: 66.04,
			values: [ 38.1, 66.04 ],
			slide: function( event, ui ) {
				$('.slider_price .slider-cur-value span').text(ui.values[0]);
				$('.slider_price .slider-cur-value.slider-cur-value2 span').text(ui.values[1]);
				//$('.price').val(ui.values[0]);
				//$('.price2').val(ui.values[1]);
				
				var l_px = parseInt($(".ui-slider-handle").eq(0).css('left'));//alert(l_px);
				$('.slider_price .slider-cur-value').css('left', l_px);
				var l_px2 = parseInt($(".ui-slider-handle").eq(1).css('left'));//alert(l_px);
				$('.slider_price .slider-cur-value.slider-cur-value2').css('left', l_px2);
			}
		});
		
		//начальные значения в инпуты
		//$('.price').val($('.slider_price').slider("values",0));
		//$('.price2').val($('.slider_price').slider("values",1));
		
		$('.slider_price .slider-cur-value span').text($('.slider_price').slider("values",0));
		$('.slider_price .slider-cur-value.slider-cur-value2 span').text($('.slider_price').slider("values",1));
		
		$('.slider_price .slider-lbl span').text($('.slider_price').slider("values",0));
		$('.slider_price .slider-lbl.jslider-label-to span').text($('.slider_price').slider("values",1));

		var l_fst = parseInt($(".ui-slider-handle").eq(0).css('left')); //alert(l_fst);
		$('.slider_price .slider-cur-value').css('left', l_fst);
		var r_fst = parseInt($(".ui-slider-handle").eq(1).css('left')); //alert(r_fst);
		$('.slider_price .slider-cur-value.slider-cur-value2').css('left', r_fst);
		
		//alert($('.slider_price').slider("values"))
		//alert($('.slider_price').slider())
		//alert(min_);

});