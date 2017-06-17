<!DOCTYPE html>
<html lang="en">
	<head>
		<link href="styles.css" rel="stylesheet">
		<script src="../js/jquery-1.7.2.min.js"></script>
		<script src="../js/SlideJS/slides.js"></script>
		<link href="../js/SlideJS/style.css" rel="stylesheet">
		<script src="../js/j.js"></script>

		<link href="../js/slider-range/style.css" rel="stylesheet">
		<script src="../js/jquery-ui.js"></script>

		<title></title>
	<script>
	$(function() {
	var min_ = 70;
	var max_ = 150;
	var measure = '%';
		$( ".slider_price" ).slider({
			range: false,
			min:min_,
			step:10,
			max: max_,
			values:[<?=$_GET['VOLUME'] ? intval($_GET['VOLUME']) : '120'?>],
			slide: function( event, ui ) {
				/*if(ui.values[0]==110 || ui.values[0]==130 || ui.values[0]==140) return false;*/
				$('.slider_price .slider-cur-value').text(ui.values[0]+measure);
				$('.slider_price .slider-cur-value-pink span').text(ui.values[0]+measure);
				last_payment_obj.text(ui.values[0]+measure);
				if(ui.values[0] == 120)
					window.parent.$(".recommended-volume").css("opacity",1);
				else window.parent.$(".recommended-volume").css("opacity",0);
				window.parent.ChangeMultiProgress(change_name);
			}
		});
		
		//начальные значения
		$(".ui-slider-handle").html('<div class="slider-cur-value"></div><div class="slider-cur-value-pink"><div class="triangle"></div><span></span></div>');
		
		$('.slider_price .slider-cur-value').text($('.slider_price').slider("values",0)+measure);
		$('.slider_price .slider-cur-value-pink span').text($('.slider_price').slider("values",0)+measure);
		
		$('.slider_price .slider-lbl span').text(min_+measure);
		$('.slider_price .slider-lbl.jslider-label-to span').text(max_+measure);
		
		var pink_wi = parseInt($('.slider-cur-value-pink').css("width"));
		$('.slider-cur-value-pink').css("min-width",pink_wi);
		$('.slider-cur-value').css("min-width",pink_wi);
		var pink_left = -pink_wi/2;
		$('.slider-cur-value-pink').css("left",pink_left);
		$('.slider-cur-value').css("left",pink_left);
		
		var change_name = $("div").attr("dynamic_change");
		var last_payment_obj = window.parent.$(".dynamic_change_here[dynamic_change_here="+change_name+"]");
		last_payment_obj.text($('.slider_price').slider("values",0)+measure);
		if($('.slider_price').slider("values",0) == 120)
					window.parent.$(".recommended-volume").css("opacity",1);
	});
	</script>	
	</head>
	<body style="background-image:url(/images/volume_scale.png?1); background-position: 103px top; background-repeat: no-repeat;">
		<div class="options calculator" dynamic_change="VOLUME" style="">
			<div class="slider_price" >
				<div class="s-line"><div class="l"></div><div class="r"></div></div>
				<div class="slider-lbl"><span></span></div>
				<div class="slider-lbl jslider-label-to"><span></span></div>
			</div>
		</div>
	</body>
</html>