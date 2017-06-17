var forms = {};

//------------------------------------------------------------------------------------------------
//----------------------------------Главная функция проверки--------------------------------------
//------------------------------------------------------------------------------------------------
function init_validate(FormObj, prefix, callback)
{	
	var oValidate = form.init(FormObj);
	var valid = oValidate.checkFields();
	if(valid && prefix)
	{
		ClearLocalStorage(prefix);
	}
	
	if(valid && (typeof callback=='function'))
	{
		valid = (callback());
	}
	
	return valid;
}
//------------------------------------------------------------------------------------------------
//---------------------------------/Главная функция проверки--------------------------------------
//------------------------------------------------------------------------------------------------

var form = {
	items: {},
	
	/*Регистрация формы*/
	init: function(FormObj)
	{
		var id = this.getId(FormObj);
		var oValidate = this.items[id];
		if(1 /*!oValidate*/)
		{
			oValidate = new validate(FormObj);
			oValidate.initFields();
			this.items[id] = oValidate;
		}
		return oValidate;
	},
	/*/Регистрация формы*/
	
	/*Найдем id формы*/
	getId: function(FormObj)
	{
		var arForms = document.getElementsByTagName('form');
		var id = 0;
		for(var i=0; i<arForms.length; i++)
		{
			if(arForms[i]==FormObj)
			{
				id = i;
			}
		}
		return id;
	}
	/*/Найдем id формы*/
};

function validate(formObj)
{
	this.formObj = formObj;
	this.fieldTypes = new Array(
									'input',
									'textarea',
									'select'
								);
}

validate.prototype = 
{
	/*Проверка полей*/
	checkFields: function(){
		/*Сбросим значения*/
		this.errorText = '';
		this.valid = true;
		/*/Сбросим значения*/
		
		for(var i=0; i<this.fieldTypes.length; i++){
			var set = this.formObj.getElementsByTagName(this.fieldTypes[i]);
			for(var j=0; j<set.length; j++){
				if(!this.checkField(set[j])){
					this.valid = false;
				}
			}
		}
		
		/*Отдельно проверяем капчу*/
		if(this.valid && this.formObj.captcha){
			this.xmlHttp = this.createXmlHttpRequestObject();
			this.checkCaptcha();
		}
		/*/Отдельно проверяем капчу*/
		
		/*Если есть, что показать, то покажем*/
		if(this.errorText.length > 0){
			alert(this.errorText);
		}
		/*/Если есть, что показать, то покажем*/
		
		/*Если все клево, то нужно убрать значения по умолчанию*/
		if(this.valid){
			for(var i=0; i<this.fieldTypes.length; i++){
				var set = this.formObj.getElementsByTagName(this.fieldTypes[i]);
				for(var j=0; j<set.length; j++){
					var obj = set[j];
					if(obj.getAttribute('initValue') && obj.value==obj.getAttribute('initValue')){
						obj.value = '';
					}
				}
			}
		}
		/*/Если все клево, то нужно убрать значения по умолчанию*/
		
		return this.valid;
	},
	/*/Проверка полей*/
	
	/*Проверка капчи*/
	checkCaptcha: function()
	{
		if ((this.xmlHttp.readyState == 4) || (this.xmlHttp.readyState == 0))
		{
			cValue = this.formObj.captcha.value;
			hash = this.formObj.captcha_img.value;

			this.xmlHttp.open("GET","/_get_captcha.php?captcha="+cValue+"&hash="+hash, false);

			this.xmlHttp.send(null);

			var xmlResponse = this.xmlHttp.responseXML;

			//При ошибке разбора XML функция просто умирает без лишних вопросов, поэтому имеет смысл смотреть responseText
			//alert(this.xmlHttp.responseText);
			xmlRoot = xmlResponse.documentElement;
			id = xmlRoot.getElementsByTagName('result');

			id_text  = id.item(0).firstChild.data;

			//Проверка XML-ответа
			if(id_text=='0')
			{
				this.valid = false;
				this.errorText += "Контрольный код введен неверно\r\n";
				this.changeCaptha();
			}
		}	
		return;	
	},
	/*/Проверка капчи*/
	
	/*Создание xmlHttp-объекта*/
	createXmlHttpRequestObject: function()
	{
		var xmlHttp;

		if(window.ActiveXObject)
		{ // Если IE
			try
			{
				xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch (e)
			{
				try
				{
					xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (e) {}
			}
		}
		else
		{ // Все остальные браузеры
			try
			{
				xmlHttp = new XMLHttpRequest();
			}
			catch (e)
			{
				xmlHttp = false;
			}
		}

		if(!xmlHttp)
		{ // Не удалось создать
			Alert('Не удалось создать объект XmlHttpRequest');
		}
		else
		{
			return xmlHttp;
		}
	},
	/*/Создание xmlHttp-объекта*/
	
	/*Замена неверно введенной капчи*/
	changeCaptha: function()
	{
		var img = this.formObj.captcha_img.parentNode.getElementsByTagName('img')[0];
		var src = img.src;
		src = src.replace(/&hash=[\d\.]+/, '');
		var hash = parseInt(Math.random()*1000000000);
		src += '&hash='+hash;
		this.formObj.captcha_img.value = hash;
		img.src = src;
	},
	/*/Замена неверно введенной капчи*/
	
	/*Проверка поля*/
	checkField: function(obj)
	{
		var valid = true;
		var type = obj.getAttribute('validate');
		if(type)
		{		
			arType = type.split(' ');
			for(var k=0; k<arType.length; k++)
			{
				methodName = this.getMethodName(arType[k]);
				if(this[methodName])
				{
					var result = this[methodName](obj);
					if(!result.success)
					{
						var error = obj.getAttribute('errorText');
						if(!error)
						{
							error = result.error;
						}
						
						this.errorText += error + "\r\n";
						valid = false;
					}
				}
			}
			
			if(valid)
			{
				this.setValid(obj);
			}
			else
			{
				this.setNotValid(obj);
			}
		}
		return valid;
	},
	/*/Проверка поля*/
	
	/*Отмечаем как не прошедшее валидацию*/
	setNotValid: function(obj)
	{
		obj.className = obj.className + ' not_valid';
		obj.parentNode.className = obj.parentNode.className + ' not_valid';
		this.addEvents(obj);

		if(obj.tagName=="SELECT" && obj.style.display=='none')
		{
			$(obj).next().addClass("not_valid");
		}
	},
	/*/Отмечаем как не прошедшее валидацию*/
	
	/*Отмечаем как прошедшее валидацию*/
	setValid: function(obj)
	{
		obj.className = obj.className.replace(/\s*not_valid/g, '');
		obj.parentNode.className = obj.parentNode.className.replace(/\s*not_valid/g, '');
		
		if(obj.tagName=="SELECT" && obj.style.display=='none')
		{
			$(obj).next().removeClass("not_valid");
		}
	},
	/*/Отмечаем как прошедшее валидацию*/
	
	/*Добавление события на элемент*/
	addEvents: function(obj)
	{
		if(!obj.getAttribute('event'))
		{
			var object = this;
			$(obj).bind("change", function(){object.checkField(this)});
			$(obj).bind("keyup", function(){object.checkField(this)});
			obj.setAttribute('event', true);
		}
	},
	/*/Добавление события на элемент*/
	
	/*Добавление события на focus и blur*/
	initFields: function()
	{
		if(!this.formObj.getAttribute('init'))
		{
			for(var i=0; i<this.fieldTypes.length; i++)
			{
				var set = this.formObj.getElementsByTagName(this.fieldTypes[i]);
				for(var j=0; j<set.length; j++)
				{
					var obj = set[j];
					if(1 || obj.getAttribute('initValue'))
					{
						var object = this;
						if(obj.addEventListener) 
						{
							obj.addEventListener("focus", function(){object.onFocus(this)}, false);
							obj.addEventListener("blur", function(){object.onBlur(this)}, false);
						} 
						else if(obj.attachEvent) 
						{
							obj.attachEvent("onfocus", function(event){object.onFocus(event.srcElement)});
							obj.attachEvent("onblur", function(event){object.onBlur(event.srcElement)});
						} 
						else 
						{
							obj.focus = function(){object.onFocus(this)};
							obj.blur = function(){object.onBlur(this)};
						}
						
						this.onBlur(obj);
						obj.setAttribute('init', true);
					}
				}
			}
		}
	},
	/*/Добавление события на focus и blur*/
	
	/*focus*/
	onFocus: function(obj)
	{
		var initValue = obj.getAttribute('initValue');
		if(initValue && this.trim(initValue)==this.trim(obj.value))
		{
			obj.value = '';
		}
		$(obj).parent().removeClass('empty');
		$(obj).removeClass('empty');
	},
	/*/focus*/
	
	/*blur*/
	onBlur: function(obj)
	{
		var initValue = obj.getAttribute('initValue');
		if(this.trim(obj.value)=='')
		{
			if(initValue)
			{
				obj.value = initValue;
			}
			$(obj).addClass('empty');
			$(obj).parent().addClass('empty');
		}
	},
	/*/blur*/
	
	/*Возвращает имя методжа для валидации*/
	getMethodName: function(name)
	{
		var arName = name.split('_');
		for(var i=0; i<arName.length; i++)
		{
			arName[i] = arName[i].substring(0,1).toUpperCase() + arName[i].substring(1);
		}
		return 'validate'+arName.join('');
	},
	/*/Возвращает имя методжа для валидации*/
	
	/*Возвращает имя поля для пользователя*/
	getNameField: function(obj)
	{
		if(this.formObj[obj.name+'_label'])
		{
			return this.formObj[obj.name+'_label'].value;
		}
		else
		{
			return obj.title;
		}
	},
	/*/Возвращает имя поля для пользователя*/
	
	/*Проверка на пустую строку*/
	trim: function(val)
	{
		return val.replace(/^\s+/, '').replace(/\s+$/, '');
	},
	/*/Проверка на пустую строку*/
	
	/*Проверка пустой строки*/
	validateNotEmpty: function(obj)
	{
		/*Для чекбокса отдельная ветка*/
		if(obj.type=='checkbox')
		{
			return {
						success: (obj.checked),
						error: 'Не поставлена галочка в поле "'+this.getNameField(obj)+'"'
					};
		}
		/*/Для чекбокса отдельная ветка*/
		
		/*Для radiobutton отдельная ветка*/
		if(obj.type=='radio')
		{
			var inputs = this.formObj[obj.name];
			var success = false;
			for(var i=0; i<inputs.length; i++)
			{
				if(inputs[i].checked) success = true;
			}
			return {
						success: (success),
						error: 'Не заполнено поле "'+this.getNameField(obj)+'"'
					};
		}
		/*/Для radiobutton отдельная ветка*/
		
		return {
					success: (this.trim(obj.value)!='' && !(obj.getAttribute('initValue') && obj.value==this.trim(obj.getAttribute('initValue')))),
					error: 'Не заполнено обязательное поле "'+this.getNameField(obj)+'"'
				};
	},
	/*/Проверка пустой строки*/
	
	/*Проверка числового значения*/
	validateNumber: function(obj)
	{		
		return {
					success: (parseFloat(obj.value)==obj.value),
					error: 'Поле "'+this.getNameField(obj)+'" должно содержать чисоловое значение'
				};
	},
	/*/Проверка числового значения*/
	
	/*Проверка на email*/
	validateEmail: function(obj)
	{
		return {
					success: (obj.value.replace(/^\s+/, '').replace(/\s+$/, '')=='' || /(.+)@(.+)\.(.+)/.test(obj.value)),
					error: 'В поле "'+this.getNameField(obj)+'" введен некорректный E-mail-адрес'
				};
	},
	/*/Проверка на email*/
	
	/* Проверка пароля на количество символом */
	validatePassword: function(obj)
	{
		return {
					success: (this.trim(obj.value).length >= 6),
					error: 'Пароль должен быть не менее 6 символов длиной'
				}
	}
	/* Проверка пароля на количество символом */
}