<?
define('NOT_SHOW_TITLE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Оплата");
CModule::IncludeModule('sale');
CModule::IncludeModule('subscribe');
$prevStepLink = '/personal/delivery/';

if($_POST['action']=='order')
{
	$APPLICATION->RestartBuffer();
	$PERSON_TYPE_ID = 1;
	
	if(!is_array($_SESSION['ORDER']['USER']))
	{
		//LocalRedirect($prevStepLink);
		$arResult = array('TYPE'=>'ERROR', 'URL'=>$prevStepLink);
	}

    if(!$GLOBALS['USER']->IsAuthorized())
    {
        /*Регистрироуем пользователя*/
        $user = new CUser;
        $pass = substr(md5(date('YmdHis')), rand(0, 20), 6);
        $USER_ID = $user->Add(array(
            "LOGIN" => $_SESSION['ORDER']['USER']['EMAIL'],
            "EMAIL" => $_SESSION['ORDER']['USER']['EMAIL'],
            "PASSWORD" => $pass,
            "CONFIRM_PASSWORD" => $pass
        ));
		if($USER_ID)
		{
			$GLOBALS['USER']->Authorize($USER_ID);
			$newUser = true;
			
			$arFields = array(
				'EMAIL' => $_SESSION['ORDER']['USER']['EMAIL'],
				'PASSWORD' => $pass
			);
			CEvent::Send("REGISTER_COMPLETE", SITE_ID, $arFields);
		}
		else
		{
			//LocalRedirect($prevStepLink);
			$arResult = array('TYPE'=>'ERROR', 'URL'=>$prevStepLink);
		}
        /*/Регистрироуем пользователя*/
    }
	
	if($arResult['TYPE']=='ERROR')
	{
		echo json_encode($arResult);
		die();
	}
	
	/*Подписка*/
	if($_POST['SUBSCRIBE']=='Y')
	{
		$arFields = array(
			'USER_ID' => $GLOBALS['USER']->GetID(),
			'EMAIL' => $GLOBALS['USER']->GetEmail(),
			'SEND_CONFIRM' => 'N',
			'ACTIVE' => 'Y',
			'RUB_ID' => 1
		);
		$subscr = new CSubscription;
		$ID = $subscr->Add($arFields);
		if($ID>0) CSubscription::Authorize($ID);
	}
	/*/Подписка*/
	
	/*Сохранение адреса доставки*/
	if($_SESSION['ORDER']['SAVE_ADDRESS_DELIVERY']=='Y' && is_array($_SESSION['ORDER']['ADDRESS']))
	{
		$arAddr = $_SESSION['ORDER']['ADDRESS'];
		$arProps = array();
		$dbRes = CSaleOrderProps::GetList(array(), array(), false, false, array('ID', 'CODE'));
		while($arr = $dbRes->Fetch())
		{
			$arProps[$arr['CODE']] = $arr['ID'];
		}
		
		/*Создаем профиль*/
		$arName = array(
			$arAddr['ZIP'],
			$arAddr['AREA'],
			$arAddr['CITY'],
			$arAddr['ADDRESS']
		);
		$name = array_diff($arName, array(''));
		$arFields = array(
		   "NAME" => $name,
		   "USER_ID" => $GLOBALS['USER']->GetID(),
		   "PERSON_TYPE_ID" => $PERSON_TYPE_ID
		);
		$ID = CSaleOrderUserProps::Add($arFields);
		/*/Создаем профиль*/
		
		/*Свойства профиля*/
		foreach($arAddr as $k=>$v)
		{
			$arFields = array(
			   "USER_PROPS_ID" => $ID,
			   "NAME" => $k,
			   "ORDER_PROPS_ID" => $arProps['ADDRESS_'.$k],
			   "VALUE" => $v
			);
			CSaleOrderUserPropsValue::Add($arFields);
		}
		/*/Свойства профиля*/
	}
	/*/Сохранение адреса доставки*/
	
	/*Способ доставки*/
	if($_SESSION['ORDER']['DELIVERY_ID'])
	{
		$deliveryId = intval($_SESSION['ORDER']['DELIVERY_ID']);
	}
	else
	{
		$deliveryId = 1;
	}
	$dbRes = CSaleDelivery::GetList(array(), array('ID'=>$deliveryId));
	$arDelivery = $dbRes->Fetch();
	/*/Способ доставки*/	

    /*Регистрируем заказ*/
    $dbRes = CSaleOrderProps::GetList(array(), array("PERSON_TYPE_ID" => $PERSON_TYPE_ID, "ACTIVE" => "Y"), false, false, array('ID', 'CODE', 'NAME'));
    $arProps = array();
    while($arr = $dbRes->Fetch())
    {
        $arProps[$arr['ID']] = $arr;
    }

    $arFields = array(
        "LID" => SITE_ID,
        "PERSON_TYPE_ID" => $PERSON_TYPE_ID,
        "PAYED" => "N",
        "CANCELED" => "N",
        "STATUS_ID" => "N",
        "PRICE" => 0,
        "CURRENCY" => "RUB",
        "USER_ID" => IntVal($GLOBALS['USER']->GetID()),
        "PAY_SYSTEM_ID" => $_POST['ORDER']['PAY_SYSTEM'],
        "PRICE_DELIVERY" => $arDelivery['PRICE'],
        "DELIVERY_ID" => $arDelivery['ID'],
        "DISCOUNT_VALUE" => 0,
        "TAX_VALUE" => 0,
        "USER_DESCRIPTION" => ''
    );
    $ORDER_ID = CSaleOrder::Add($arFields);
    $ORDER_ID = intval($ORDER_ID);
    if($ORDER_ID > 0)
    {
        /*Свойства товара*/
        foreach($arProps as $k=>$v)
        {
			if(strpos($v['CODE'], 'USER_')===0)
			{
				$value = $_SESSION['ORDER']['USER'][substr($v['CODE'], 5)];
			}
			elseif(strpos($v['CODE'], 'ADDRESS_')===0)
			{
				$value = $_SESSION['ORDER']['ADDRESS'][substr($v['CODE'], 8)];
			}

            CSaleOrderPropsValue::Add(array(
                "ORDER_ID" => $ORDER_ID,
                "ORDER_PROPS_ID" => $v['ID'],
                "NAME" => $v['NAME'],
                "CODE" => $v['CODE'],
                "VALUE" => $value
            ));
        }
        /*/Свойства товара*/

        /*обнуляем корзину*/
        CSaleBasket::OrderBasket($ORDER_ID, CSaleBasket::GetBasketUserID(), SITE_ID, false);
        /*/обнуляем корзину*/

        /*Обновляем цену заказа*/
        $dbBasketItems = CSaleBasket::GetList(
            array("NAME" => "ASC"),
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => $ORDER_ID
            ),
            false,
            false,
            array("ID", "NAME", "QUANTITY", "PRICE", "PRODUCT_ID")
        );
        $price = 0;
        $strOrderList = "";
		$arBasketItems = array();
		$arIds = array();
		while($arItem = $dbBasketItems->GetNext())
		{
			$arBasketItems[] = $arItem;
			$arIds[intval($arItem['PRODUCT_ID'])] = intval($arItem['PRODUCT_ID']);
		}
		if(count($arIds) > 0)
		{
			$dbRes = CIBlockElement::GetList(array(), array('ID'=>$arIds), false, false, array('ID', 'IBLOCK_ID'));
			while($arr = $dbRes->Fetch())
			{
				$arIds[$arr['ID']] = $arr['IBLOCK_ID'];
			}
		}
		
        foreach($arBasketItems as $arBasketItem)
        {
            $price += DoubleVal($arBasketItem["PRICE"]) * DoubleVal($arBasketItem["QUANTITY"]);
            $strOrderList .= $arBasketItem["NAME"]." (".DoubleVal($arBasketItem["PRICE"])." руб.) - ".$arBasketItem["QUANTITY"]." шт.\n<br>";
			if($arIds[$arBasketItem['PRODUCT_ID']]==3)
			{
				$dbRes = CIBlockElement::GetProperty($arIds[$arBasketItem['PRODUCT_ID']], $arBasketItem['PRODUCT_ID'], array("sort" => "asc"));
				$strOrderList .= '<ul>';
				while($arr = $dbRes->Fetch())
				{
					if($arr['LINK_IBLOCK_ID'] > 0 && $arr['VALUE'] > 0)
					{
						$dbRes2 = CIBlockElement::GetList(array(), array('ID'=>$arr['VALUE']), false, array('nTopCount'=>1), array('NAME'));
						if($arr2 = $dbRes2->Fetch())
						{
							$arr['VALUE'] = $arr2['NAME'];
						}
					}
					elseif($arr['PROPERTY_TYPE']=='F' && $arr['VALUE'] > 0)
					{
						$arFile = CFile::GetFileArray($arr['VALUE']);
						$arr['VALUE'] = '<img src="http://'.$_SERVER['HTTP_HOST'].$arFile['SRC'].'" height="150px">';
					}
					$strOrderList .= "<li>".$arr['NAME'].": ".$arr['VALUE']."</li>\n<br>";
				}
				$strOrderList .= '</ul>';
			}
        }
        //$totalOrderPrice = $arResult["ORDER_PRICE"] + $arResult["DELIVERY_PRICE"] + $arResult["TAX_PRICE"] - $arResult["DISCOUNT_PRICE"];
        $totalOrderPrice = $price;
        CSaleOrder::Update($ORDER_ID, Array("PRICE" => $totalOrderPrice + floatval($arDelivery['PRICE'])));
        /*/Обновляем цену заказа*/
		
		$cards = '';
		if($_POST['ORDER']['PAY_SYSTEM']==8)
		{
			$cards = 'Для оплаты заказа используйте следующие реквизиты карт:<br>
						1) Сбербанк: 5469 6600 1101 9522, действительна до 11/17<br>
						2) ВТБ: 5543 8633 1325 2813, действительна до 08/15<br><br><br>';
		}

        /*Отправим письмо*/
        $arFields = Array(
            "ORDER_ID" => $ORDER_ID,
            "ORDER_DATE" => Date($DB->DateFormatToPHP(CLang::GetDateFormat("SHORT", SITE_ID))),
            "ORDER_USER" => $_SESSION['ORDER']['USER']['LAST_NAME'].' '.$_SESSION['ORDER']['USER']['NAME'],
            "PRICE" => number_format($totalOrderPrice, 0, '', ' ').' р.',
			"PRICE_DELIVERY" => number_format(floatval($arDelivery['PRICE']), 0, '', ' ').' р.',
			"PRICE_SUM" => number_format($totalOrderPrice + floatval($arDelivery['PRICE']), 0, '', ' ').' р.',
            "BCC" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
            "EMAIL" => $GLOBALS['USER']->GetEmail(),
            "ORDER_LIST" => $strOrderList,
            "SALE_EMAIL" => COption::GetOptionString("sale", "order_email", "order@".$SERVER_NAME),
			"CARDS" => $cards
        );
        $event = new CEvent;
        $event->Send('SALE_NEW_ORDER', SITE_ID, $arFields, "N");
        /*/Отправим письмо*/

        unset($_SESSION['ORDER']);
        if($newUser)
        {
            $GLOBALS['USER']->Logout();
        }
        //LocalRedirect('/personal/order-success/?ORDER_ID='.$ORDER_ID);
		$arResult = array('TYPE'=>'OK', 'ID'=>$ORDER_ID);
		echo json_encode($arResult);
		die();
    }
    /*/Регистрируем заказ*/
}

$arPSActions = array();
$dbRes = CSalePaySystemAction::GetList(array('PS_SORT'=>'ASC'), array('PERSON_TYPE_ID'=>1, 'PS_ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'LOGOTIP', 'PS_DESCRIPTION'));
while($arr = $dbRes->Fetch())
{
	$arr['LOGOTIP'] = CFile::GetFileArray($arr['LOGOTIP']);
	$arPSActions[] = $arr;
}
?>
	<form method="post" action="" class="small config" validate="true">
		<input type="hidden" name="action" value="order">
		<?$APPLICATION->IncludeComponent(
			"bitrix:menu",
			"order",
			Array(
				"ROOT_MENU_TYPE" => "order", 
				"MAX_LEVEL" => "1", 
				"CHILD_MENU_TYPE" => "left", 
				"USE_EXT" => "Y", 
				"MENU_CACHE_TYPE" => "A",
				"MENU_CACHE_TIME" => "3600",
				"MENU_CACHE_USE_GROUPS" => "Y",
				"MENU_CACHE_GET_VARS" => Array()
			)
		);?>
		<!--/config header-->
		<p class="title-24 payment">Оплата заказа</p>
		<p class="myriad-12 safe-op">Все операции являются безопасными и зашифрованными.</p>
		<p class="pink">Пожалуйста, выберите способ оплаты:</p>
		
		<div class="radios-customizes rpayments">
			<div class="radios circled cust" dynamic_change="payments">
				<?
				foreach($arPSActions as $k=>$v)
				{
					echo '<div class="radio-wrap"><div class="inner">';
					if(is_array($v['LOGOTIP']))
					{
						echo '<label for="ps'.$v['ID'].'" class="img1" style="background-image:url('.$v['LOGOTIP']['SRC'].'); width:'.$v['LOGOTIP']['WIDTH'].'px; height:'.round($v['LOGOTIP']['HEIGHT']/2).'px" title="'.htmlspecialchars($v['NAME']).'"></label>
								<div class="img2" style="background-image:url('.$v['LOGOTIP']['SRC'].'); width:'.$v['LOGOTIP']['WIDTH'].'px; height:'.round($v['LOGOTIP']['HEIGHT']/2).'px" title="'.htmlspecialchars($v['NAME']).'"></div>';
					}
					else
					{
						echo '<label for="ps'.$v['ID'].'" class="cash">'.$v['NAME'].'</label>';
					}
					echo '<input type="radio" class="niceRadio" name="ORDER[PAY_SYSTEM]" id="ps'.$v['ID'].'" value="'.$v['ID'].'" data-value="'.$v['NAME'].'" '.($k==0 ? 'validate="not_empty"' : '').' title="Способ оплаты">
						  </div>
							'.($v['PS_DESCRIPTION'] ? '<div class="info">'.$v['PS_DESCRIPTION'].'</div>' : '').'
						  </div>';
					if($k%2==1)
					{
						echo '<div class="clear"></div>';
					}
				}
				?>
			</div>
		</div>
		
		<div class="clear" style="margin-top:65px;"></div>
		
		<span class="pink floated">Выбранный способ оплаты </span>
		<div class="triangle"></div>
		<span class="pink-label dynamic_change_here" dynamic_change_here="payments">не выбран</span>
		
		
		<div class="hr"></div>
		<p class="title-24 beige to-be">Держать меня в курсе</p>
		<div class="radios-customizes">
			<div class="text-beige">Нет</div>
			<div class="radios squared">
				<input type="radio" class="niceRadio" name="SUBSCRIBE" tabindex="1" value="N" /> 
				<input type="radio" class="niceRadio" name="SUBSCRIBE" tabindex="2" value="Y" checked="checked"/> 
			</div>
			<div class="text-beige">Да</div>
		</div>
		<span class="font-16 save-address">Я хочу получать сообщения о новых продуктах, акциях, и других новостях.</span>
					
		<div class="hr pink lst"></div>
		<!--config footer-->
		<section class="cont-controls">
			<input type="submit" class="create_hair_system2 pink-button radiused" id="buy" value="Купить" onclick="return Order.SetPayment(this);"> 
			<span class="beige"> или</span>
			<a class="pink" href="/personal/delivery/">вернуться к формированию заказа</a>
			<br><div class="next-step-descr">&nbsp;</div>
		</section>
	</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>