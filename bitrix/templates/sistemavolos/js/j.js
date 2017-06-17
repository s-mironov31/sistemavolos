/*Слайдера*/
function Slider(id, type, timeout)
{
	this.id = id;
	this.slider = $('#'+id); //подвижная часть слайдера
	this.items = $('#'+this.id+' > div.item'); //элементы внутри слайдера
	this.absStep = (type=='horizontal' ? this.items[0].offsetWidth : this.items[0].offsetHeight); //шаг движения
	this.attr = (type=='horizontal' ? 'marginLeft' : 'marginTop'); //изменяемый параметр
	this.showLength = (type=='horizontal' ? this.slider[0].parentNode.offsetWidth : this.slider[0].parentNode.offsetHeight); //отображаемое окно слайдера
	this.moving = false; //признак движения
	this.events = new Array(); //события
	this.settings = new Array(); //настройки для текущего действия (временные параметры)
	this.timeout = timeout; //таймаут для движения по таймеру
	
	/*Движение слайдера*/
	this.move = function(course, btn)
	{
		if(btn)	btn.blur();		
		if(this.moving) return false;
		this.moving = true;
		
		this.setAttributes(course)
		this.mix();
		
		this.executeEvent('onBeforeMove');
		
		eval('var params = {'+this.attr+': '+this.settings['newShift']+'}');
		var object = this;
		this.slider.animate(params, "easein", function(){
															object.executeEvent('onAfterMove');
															object.moving = false;
														});
		return true;
	};
	/*/Движение слайдера*/
	
	/*Показ произвольного слайда*/
	this.moveCustom = function(number)
	{
		if(this.moving) return false;
		
		/*if(this.onMoveCustom && typeof(this.onMoveCustom)=='function')
		{
			this.onMoveCustom(number);
		}*/
		this.executeEvent('onMoveCustom', number);
	
		/*Найдем текущий элемент*/
		var shift = parseInt(this.slider.css(this.attr));
		var current = Math.abs(Math.round(shift/this.absStep));
		var nCurrent = $('form', this.items[current])[0].counter.value;
		/*/Найдем текущий элемент*/
		
		if(number == nCurrent)
		{
			return false;
		}
		
		var nNumber;
		for(var i=0; i<this.items.length; i++)
		{
			if($('form', this.items[i])[0].counter.value==number)
			{
				nNumber = i;
			}
		}
		
		/*Подставим следующий элемент в нужно место*/
		var course;
		if(number > nCurrent)
		{
			$(this.items[nNumber]).insertAfter(this.items[current]);
			course = -1;
		}
		else
		{
			$(this.items[nNumber]).insertBefore(this.items[current]);
			course = 1;
		}
		this.setItems();
		this.move(course);
		/*/Подставим следующий элемент в нужно место*/
		
		this.addEvent('onAfterMove', 'afterMoveCustom');
	};
	/*/Показ произвольного слайда*/
	
	/*Восстановление порядка после показа произвольного слайда*/
	this.afterMoveCustom = function()
	{
		/*Найдем текущий элемент*/
		var shift = parseInt(this.slider.css(this.attr));
		var current = Math.abs(Math.round(shift/this.absStep));
		var nCurrent = $('form', this.items[current])[0].counter.value;
		/*/Найдем текущий элемент*/
		
		var fail = true;
		while(fail)
		{
			fail = false;
			for(var i=0; i<this.items.length-1; i++)
			{
				if($('form', this.items[i])[0].counter.value > $('form', this.items[i+1])[0].counter.value)
				{
					$(this.items[i+1]).insertBefore(this.items[i]);
					this.items = $('#'+id+' > div.item');
					fail = true;
				}
			}
		}
		this.slider.css(this.attr, -this.absStep*(nCurrent-1));
		this.removeEvent('onAfterMove', 'afterMoveCustom');
	}
	/*/Восстановление порядка после показа произвольного слайда*/
	
	/*Задает параметры*/
	this.setAttributes = function(course)
	{
		this.settings['step'] = course*this.absStep;
		this.settings['shift'] = parseInt(this.slider.css(this.attr));
		this.settings['newShift'] = this.settings['shift'] + this.settings['step'];
	}
	/*/Задает параметры*/
	
	/*Обновляет элементы слайдера*/
	this.setItems = function()
	{
		this.items = $('#'+this.id+' > div.item');
	}
	/*/Обновляет элементы слайдера*/
	
	/*Перемещаем из начала в конец или наоборот*/
	this.mix = function(settings)
	{
		if(this.settings['newShift'] > 0)
		{
			$('#'+this.id+' > div.item:last').insertBefore('#'+this.id+' > div.item:first');
			this.settings['newShift'] = this.settings['shift'];
			this.slider.css(this.attr, this.settings['shift'] - this.settings['step']);
		}
		
		if(this.settings['newShift'] < 0 && ((this.items.length*this.absStep+this.settings['newShift']) < this.showLength+this.absStep))
		{
			$('#'+this.id+' > div.item:first').insertAfter('#'+this.id+' > div.item:last');
			this.settings['newShift'] = this.settings['shift'];
			this.slider.css(this.attr, this.settings['shift'] - this.settings['step']);
		}
		
		this.setItems();
	};
	/*/Перемещаем из начала в конец или наоборот*/
	
	/*Добавление событий*/
	this.addEvent = function(type, method)
	{
		if(typeof this.events[type] != 'object')
		{
			this.events[type] = new Array();
		}
		this.events[type][this.events[type].length] = method;
	}
	/*/Добавление событий*/
	
	/*Удаление событий*/
	this.removeEvent = function(type, method)
	{
		if(typeof this.events[type] == 'object')
		{
			for(var i=0; i<this.events[type].length; i++)
			{
				if(this.events[type][i]==method)
				{
					delete this.events[type][i];
					i--;
				}
			}
		}
	}
	/*/Удаление событий*/
	
	/*Выполнение событий*/
	this.executeEvent = function(type)
	{
		if(typeof this.events[type] == 'object')
		{
			for(var i=0; i<this.events[type].length; i++)
			{
				if(this.events[type][i])
				{
					var arg = '';
					if(arguments.length > 1)
					{
						for(var j=1; j<arguments.length; j++)
						{
							arg += '"'+arguments[j]+'",';
						}
						arg = arg.substring(0, arg.length-1);
					}
					eval('this.'+this.events[type][i]+'('+arg+');');
				}
			}
		}
	}
	/*/Выполнение событий*/

	/*Обработка движения по таймеру*/
	if(this.timeout)
	{
		this.clearTimeout = function()
		{
			if(this.timer)
			{
				clearTimeout(this.timer);
				delete this.timer;
			}
		};
		
		this.setTimeout = function()
		{
			if(this.timeout)
			{
				var object = this;
				var timer = setTimeout(function(){object.move(-1);}, this.timeout);
				this.timer = timer;
			}
		};
		
		this.addEvent('onBeforeMove', 'clearTimeout');
		this.addEvent('onAfterMove', 'setTimeout');
		this.setTimeout();
	}
	/*/Обработка движения по таймеру*/
}
/*/Слайдера*/

$(document).ready(function(){	
	Order.InitDelivery();
	OList.Init();
	
	//блок регистрации
	$(".open-reg").click(function(){
		$(".log_in .delete-btn").trigger('click');
		$(".log_in-shadow:not(.full-screen)").show();
		$(".log_in-fix.reg-form").show();
	});
	
	//восстановление пароля
	$(".open-sendpass").click(function(){
		$(".log_in .delete-btn").trigger('click');
		$(".log_in-shadow:not(.full-screen)").show();
		$(".log_in-fix.send-pass").show();
	});
	
	//изменение пароля
	if(window.location.hash=='#chpass')
	{
		$(".log_in .delete-btn").trigger('click');
		$(".log_in-shadow:not(.full-screen)").show();
		$(".log_in-fix.change-pass").show();
	}

	//popup при нажатии на "купить"
	/*$("#buy").click(function(){
		$(".log_in-shadow.full-screen").show();
		$(".log_in-fix.thanksed").show();
	});	*/
	//закрыть
	$(".log_in .delete-btn").click(function(){
		$(".log_in-shadow").hide();
		$(".log_in-fix").hide();
	});
	
	//popup при нажатии на "Уточнить и заказать"
	/*$(".example .more-and-order").click(function(){
		$(".log_in-shadow.full-screen").show();
		$(this).closest(".one-element").find(".example-wrap").show();
	});*/
	//закрыть
	$(".example-wrap .delete-btn").click(function(){
		$(".log_in-shadow").hide();
		$(".example-wrap").hide();
	});

	$(".show-hide-det-arrow").click(function(){
		one_el = $(this).closest(".one-el");
		ShowDetails(one_el);
	});
	
	//калькулятор, пункт 2(параметры измерения головы)
	$("input.calced").change(function(){
		//$(this).closest(".oled-2-l").attr("dynamic_change_flag");
		ChangeMultiProgress($(this).closest(".oled-2-l").attr("dynamic_change_flag"));
	});
	
	//верхнее меню
	$(window).scroll(function()
	{
		if($(window).scrollTop()=="0")
		{ 
			//в начале
			$(".header#compact").fadeOut("slow",function() {
				$(".header#initial").fadeIn("slow");
				$(".h-fixed").css("height",132);
				$("table.top-menu").css("font-size",16);
			});
			$(".log_in-shadow:not(.full-screen)").css('top',132);
			$(".header-height").css('height',132);
			$(".h-fixed").css("border-bottom",0);
			$(".multi-progress").css({"position":"relative","top":0});
		}
		//прокручено
		else{
		//var top_indent = 70;
		var top_indent = 110;
			$(".header#initial").fadeOut("slow",function(){
				$(".header#compact").fadeIn("slow");
				$(".log_in-shadow:not(.full-screen)").css('top',72);
				$(".h-fixed").css("height",70);
				$(".h-fixed").css("border-bottom","2px solid #DFDBD8");
				$("table.top-menu").css("font-size",13);
				
			});
			
			$(".header-height").css('height',top_indent);
			$(".multi-progress").css({"position":"fixed","top":72});
		}
	});
	$(window).trigger('scroll');

	$(".top-arrow").click(function(){
		$("html, body").animate({scrollTop:0},"slow");
	});
	/* при загрузке страницы меняем обычные на стильные radio */
	jQuery(".niceRadio").each(function() {
		 changeRadioStart(jQuery(this));
	});
	$('.radio-wrap .img-wrap').click(function(){
		$(this).closest('.radio-wrap').find('.niceRadio').trigger('mousedown');
	});
	//всплывающие подсказки
	 $(".i-help").hover(
       function(){ $(this).find('.i-helper-text').show(); },
       function(){ $(this).find(".i-helper-text").hide(); 
	 });
	 firstRadioValue();
	  
	/*Валидация форм*/
	InitValidate(document.body);
	
	$('form div.placeholder').bind('click', function(){
		$(this).next().trigger('focus');
	})
	/*/Валидация форм*/
	
	//слайдеры
	var arIds = ['slides', 'slides2'];
	for(var j=0; j<arIds.length; j++)
	{
		var slide = 1;
		var slides = $("#"+arIds[j]+" .radio-wrap");
		for(var i=0; i<slides.length; i++)
		{
			if($(slides[i]).hasClass('techno'))
			{
				slide = Math.floor(i/6) + 1;
			}
		}
		$("#"+arIds[j]).slides({'startAtSlide': slide}); 
	}
	
	
	$('.horiz_slider .dynamic_block').each(function(){
		var id = this.id;
		var slider = new Slider(id, 'horizontal');
		var parent = $(this).closest('.horiz_slider');
		parent.find('.left_btn').bind('click', function(){
			slider.move(1, this);
		});
		parent.find('.right_btn').bind('click', function(){
			slider.move(-1, this);
		});
	});
	
	if(document.getElementById('headsizes'))
	{
		var inputs = $('#headsizes input[type=text]');
		inputs.bind('keypress', function(event){
			if(event.which==13) 
			{
				event.preventDefault();
	
				var num = parseInt($(event.target).attr('num')) + 1;
				if(num > inputs.length)
				{
					event.target.blur();
				}
				else
				{
					$('#headsizes input[num='+num+']')[0].focus();
				}
			}
		});
		for(var i=0; i<inputs.length; i++)
		{
			$(inputs[i]).attr('num', i+1);
		}
	}
});

function ShowBasketForm()
{
	$(".log_in .delete-btn").trigger('click');
	$(".log_in-shadow:not(.full-screen)").show();
	$(".log_in-fix.add2basket").show();
}

function InitValidate(parent)
{
	$('form[validate]', parent).bind('submit', function(){
		if(this.send) this.send.value = 1;
		return init_validate(this);
	}).each(function(){
		form.init(this);
	});
}

//radio
function changeRadio(el)
/* 
	функция смены вида и значения radio при клике на контейнер
*/
{

	var el = el,
		input = el.find("input").eq(0);
	var nm=input.attr("name");
		
	jQuery(".niceRadio input").each(
	
	function() {
     
		if(jQuery(this).attr("name")==nm)
		{
			jQuery(this).parent().removeClass("radioChecked");
				 //  	alert($(this).attr('value'));
		}

	   
	});					  
	
	
	if(el.attr("class").indexOf("niceRadioDisabled")==-1)
	{
		el.addClass("radioChecked");
		input.attr("checked", true);
		//alert(input.attr("value"))
		var change_wrap = el.closest(".radios");
		var change_name = change_wrap.attr("dynamic_change");//alert(change_name)
		if(change_name) 
		{
			var value = (input.attr("data-value") ? input.attr("data-value") : input.attr("value"));
			changeRadioValue(value, change_name);
			var with_bcg = change_wrap.find(".radio-wrap").each(function() { 
				$(this).removeClass("techno");
			});
			el.closest(".radio-wrap").addClass("techno");
		}
		
		var sixth_el = el.closest(".sixth, .iskin").attr("dynamic_change_flag");//alert(sixth_el);
		if(sixth_el)
			ChangeMultiProgress(sixth_el);
	}

    return true;
}

function changeRadioStart(el)
/* 
	новый контрол выглядит так <span class="niceRadio"><input type="radio" name="[name radio]" id="[id radio]" [checked="checked"] /></span>
	новый контрол получает теже name, id и другие атрибуты что и были у обычного
*/
{

try
{
var el = el,
	radioChecked = el.attr("checked"),
	radioDisabled = el.attr("disabled");
	el.after("<span class='niceRadio'></span>");
	$(el).clone().appendTo(el.next());
	
	if(radioChecked) 
		el.next().addClass('radioChecked');
	
	/* если контрол disabled - добавляем соответсвующий класс для нужного вида и добавляем атрибут disabled для вложенного radio */		
	if(radioDisabled)
	{
		el.next().addClass("niceRadioDisabled");
		el.next().find("input").eq(0).attr("disabled","disabled");
	}
	
	/* цепляем обработчики стилизированным radio */		
	var next = el.next();
	next.bind("mousedown", function(e) {next.find("input").eq(0).trigger('change').trigger('click')});
	/*if(jQuery.browser.msie)	next.find("input").eq(0).bind("click", function(e) { changeRadio(next) });	
	else */next.find("input").eq(0).bind("change", function(e) {changeRadio(next) });
	el.remove();
}
catch(e)
{
	// если ошибка, ничего не делаем
}

    return true;
}
//end radio


//замена выбранного значения при изменении radio
function changeRadioValue(new_payment, change_name)
{
	//alert(change_name);
	var last_payment_obj = $(".dynamic_change_here[dynamic_change_here="+change_name+"]");
	if(1 /*new_payment != last_payment_obj.text()*/)
	{
		last_payment_obj.text(new_payment);
		if($(".calculator").length > 0)
			ChangeMultiProgress(change_name);
		//$(".multi-progress .m-p-element[dynamic_change_progress="+change_name+"]").addClass("current");
	}
}
//замена текущего элемента multi-progress
//при выборе какого-либо параметра
function ChangeMultiProgress(new_curr)
{
	var form = document.calcForm;
	$('.dynamic_change_here', form).each(function(){
		var name = this.getAttribute('dynamic_change_here');
		if(!form[name])
		{
			$(form).prepend('<input type="hidden" name="'+name+'" value="'+this.innerHTML+'">');
		}
		else
		{
			form[name].value = this.innerHTML;
		}
	});
	$('#hidden_frame').remove();
	$(document.body).prepend('<iframe name="hidden_frame" id="hidden_frame" style="display: none;"></iframe>');
	form.submit();

	$(".multi-progress .m-p-element.current").removeClass("current");
	$(".multi-progress .m-p-element[dynamic_change_progress="+new_curr+"]").addClass("current");
}
//отображение цены в калькуляторе
function SetCalcPrice(price)
{
	$("#total-price .prc").html(number_format(price, 0, '', ' ') + ' р.');
	$("#total-price").show("slow");
}
//загруженные фото
function SetCalcFiles(arImg)
{
	document.calcForm['EXAMPLE[]'].value = '';

	var divs = $('#upl-photos .for-photo');
	var k = 0;
	for(var i=0; i<arImg.length; i++)
	{
		while(divs[k+i] && divs[k+i].getAttribute('full'))
		{
			k++;
		}
		if(k+i < divs.length)
		{
			divs[k+i].innerHTML = '<input type="hidden" name="IMG[SRC_SMALL][]" value="'+arImg[i]['icon_src']+'">'+
								  '<input type="hidden" name="IMG[SRC][]" value="'+arImg[i]['src']+'">'+
								  '<input type="hidden" name="IMG[NAME][]" value="'+arImg[i]['name']+'">';/*+
								  '<img src="'+arImg[i]['icon_src']+'" alt="'+arImg[i]['name']+'" title="'+arImg[i]['name']+'">';*/
			divs[k+i].style.backgroundImage = 'url('+arImg[i]['icon_src']+')';
			divs[k+i].setAttribute('full', 1);
		}
	}
}
//number_format
function number_format( number, decimals, dec_point, thousands_sep ) {
    var i, j, kw, kd, km;

    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }
    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);

    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd;
}
//при загрузке страницы менять выбранное значение на значение в <input checked>
function firstRadioValue()
{
	//var for_change = $(".radios").attr("dynamic_change");//alert(for_change.length)
	var for_change = $(".radios");//alert(for_change.length)
	for(i=0;i<for_change.length;i++)
	{
		var d_c_name = for_change.eq(i).attr("dynamic_change");
		if(d_c_name)
		{
			var checkedd = for_change.eq(i).find("input:checked"); //alert(checkedd);
			var value = (checkedd.attr("data-value") ? checkedd.attr("data-value") : checkedd.attr("value"));
			$(".dynamic_change_here[dynamic_change_here="+d_c_name+"]").text(value);
			checkedd.closest(".radio-wrap").addClass("techno");
		}
	}
}
//показ-скрытие детальной информации
function ShowDetails(one_el){
			element = one_el.find(".element");
			if(element.hasClass('opened'))
			{
			//закрытие
				element.removeClass('opened');
				one_el.find(".element-description").slideUp();
			}
			else{
			//открытие
				element.addClass('opened');
				one_el.find(".element-description").slideDown();	
					
			}
}

function ShowExample(link){
	$(".log_in-shadow.full-screen").show();
	$(link).closest(".one-element").find(".example-wrap").show();
}

function GoToCallback(){
	var form = document.callbackForm;
	//form.uname.focus();
	var offset = $(form).offset();
	$("html, body").animate({scrollTop:offset.top});
}

var Basket = {
	Minus: function(link){
		var qnt = Math.max(1, this.GetQuantity(link) - 1);
		this.SetQuantity(link, qnt);
	},
	
	Plus: function(link){
		var qnt = this.GetQuantity(link) + 1;
		this.SetQuantity(link, qnt);
	},
	
	GetQuantity: function(link){
		var qnt = parseInt($(link).closest('.quantity').find('.quantity-nmb').html());
		return qnt;
	},
	
	SetQuantity: function(link, qnt){
		var parent = $(link).closest('.quantity');
		parent.find('.quantity-nmb').html(qnt);
		parent.find('input[name^=QUANTITY_]').val(qnt);
		if(link.rel && this[link.rel])
		{
			this[link.rel](link, qnt);
		}
		else
		{
			this.Update();
		}
	},
	
	UpdateLink: function(link, qnt){
		var blink = $(link).closest('.clips-det').find('.more-and-order')[0];
		blink.href = blink.href.replace(/&quantity=\d+/, '');
		blink.href = blink.href + '&quantity='+qnt;
	},
	
	Update: function(){
		var params = $(document.basketForm).serialize()+'&AJAX=Y';
		$.post(window.location.href, params, function(data){
			$('#pcart').html(data);
		});
	},
	
	Delete: function(id){
		var params = $(document.basketForm).serialize()+'&DELETE_'+id+'=Y&AJAX=Y';
		$.post(window.location.href, params, function(data){
			$('#pcart').html(data);
		});
	}
}

var Callback = {
	Show: function(id, html)
	{
		if(!document.getElementById(id))
		{
			$(document.body).append(html);
		}
		else
		{
			$('#'+id).replaceWith(html);
		}
		$(".log_in-shadow.full-screen").show();
		$('#'+id).show();
	},
	
	Hide: function()
	{
		$(".log_in-shadow").hide();
		$(".log_in-fix").hide();
	}
}

var CFilter = {
	Toggle: function(link, id)
	{
		var form = $(link).closest('form');
		if($(link.parentNode).hasClass('bord'))
		{
			$(link.parentNode).removeClass('bord');
			form.find('input[name^=SID][value='+id+']').remove();
		}
		else
		{
			$(link.parentNode).addClass('bord');
			form.find('input[name^=SID]').remove();
			form.prepend('<input type="hidden" name="SID[]" value="'+id+'">');
		}
		this.Update();
	},
	
	Update: function()
	{
		var params = $(document.cfilterForm).serialize()+'&AJAX=Y';
		$.get(window.location.pathname, params, function(data){
			$('#pcatalog').html(data);
		});
	}
}

function ShowLoginForm()
{
	$(".log_in .delete-btn").trigger('click');
	$(".log_in-shadow:not(.full-screen)").show();
	$(".log_in-fix.log-in").show();
}

var Order = {
	SetDelivery: function(btn)
	{
		var form = $(btn).closest('form');
		if(init_validate(form[0]))
		{
			$.post(window.location.href, form.serialize(), function(data){
				if(data.TYPE=='OK')
				{
					window.location.href = "/personal/payment/";
				}
				else
				{
					alert(data.MESSAGE);
				}
			}, 'json');
		}
		return false;
	},
	
	SetPayment: function(btn)
	{
		var form = $(btn).closest('form');
		if(init_validate(form[0]))
		{
			$.post(window.location.href, form.serialize(), function(data){
				if(data.TYPE=='OK')
				{
					var url = '/personal/order-success/?ORDER_ID='+data.ID;
					/*Order.ShowThanks(url);
					setTimeout(function(){
						window.location.href = url;
					}, 5000);*/
					window.location.href = url;
				}
				else
				{
					if(data.MESSAGE)
					{
						alert(data.MESSAGE);
					}
					else if(data.URL)
					{
						window.location.href = data.URL;
					}
				}
			}, 'json');
		}
		return false;
	},
	
	ShowThanks: function(url)
	{
		$(".log_in-shadow.full-screen").show();
		$(".log_in-fix.thanksed").show();
		$(".log_in .delete-btn").click(function(){
			window.location.href = url;
		});
	},
	
	ShowAddressField: function(btn)
	{
		$(btn).closest('td').hide();
		$(btn).closest('table').find('tfoot').show();
		$(btn).closest('.order-form').find('.col_bottom').show();
		this.InitDelivery();
	},
	
	InitDelivery: function()
	{
		if(!document.getElementById('deliveryForm')) return;
		
		if(document.getElementById('address_fields').style.display=='none')
		{
			$('#address_fields input[type=text]').removeAttr('validate');
			$('#oaddr input[type=radio][title]').attr('validate', 'not_empty');
			document.deliveryForm.address_source.value = 1;
		}
		else
		{
			$('#address_fields input[type=text]').attr('validate', 'not_empty');
			$('#oaddr input[type=radio][title]').removeAttr('validate');
			document.deliveryForm.address_source.value = 0;
		}
	}
}

var Address = {
	ShowForm: function()
	{
		$.post('/personal/address/form.php', {}, function(data){
			if(document.getElementById('addrForm'))
			{
				$('#addrForm').replaceWith(data)
			}
			else
			{
				$(document.body).append(data);
			}
			InitValidate($('#addrForm'));
			$(".log_in-fix.addr-form .delete-btn").click(function(){
				$(".log_in-shadow").hide();
				$(".log_in-fix.addr-form").hide();
			});
			$(".log_in-shadow.full-screen").show();
			$(".log_in-fix.addr-form").show();
		});
	},
	
	Add: function(btn)
	{
		var form = $(btn).closest('form');
		$.post(form[0].action, form.serialize(), function(data){
			$('#address_list').html(data);
			$(".log_in-fix.addr-form .delete-btn").trigger('click');
		});
		return false;
	},
	
	Remove: function(id)
	{
		$.post('/personal/address/form.php', {action: 'delete', id: id}, function(data){
			$('#address_list').html(data);
		});
	},
	
	SetBasic: function(id)
	{
		$.post('/personal/address/form.php', {action: 'set_basic_address', id: id}, function(data){
			
		});
	}
}

var OList = {
	Init: function()
	{
		var id = window.location.hash.replace('#', '');
		if(id.length > 0 && document.getElementById('order'+id))
		{
			$("html, body").animate({scrollTop: $('#order'+id).offset().top - 100});
			$('#order'+id+' a.line').trigger('click');
		}
	},
	
	Open: function(link)
	{
		if(!$(link).hasClass('open'))
		{
			$(link).addClass('open');
			var block = $('.detail', link.parentNode);
			block.slideDown();
		}
		else
		{
			$(link).removeClass('open');
			var block = $('.detail', link.parentNode);
			block.slideUp();
		}
	},
	
	Repeat: function(id)
	{
		$.post('/handlers/repeat_order.php', {ID: id}, function(data){
			window.location.href = "/personal/basket/";
		});
	}
}