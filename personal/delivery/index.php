<?
define('NOT_SHOW_TITLE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Доставка");

/*Адреса доставки*/
$arAddresses = array();
$arProfiles = array();
if($GLOBALS['USER']->IsAuthorized())
{
	$dbRes = CUser::GetList(($by="ID"), ($order="desc"), array('ID'=>$GLOBALS['USER']->GetID()), array('SELECT'=>array('UF_BASIC_ADDRESS')));
	$arUser = $dbRes->Fetch();

	$dbRes = CSaleOrderUserProps::GetList(array(), array("USER_ID" => $GLOBALS['USER']->GetID()));
	while($arr = $dbRes->Fetch())
	{
		$arProfiles[$arr['ID']] = $arr;
	}

	if(count($arProfiles) > 0)
	{
		$dbRes = CSaleOrderUserPropsValue::GetList(array(), Array("USER_PROPS_ID"=>array_keys($arProfiles)));
		while($arr = $dbRes->Fetch())
		{
			$arAddresses[$arr['USER_PROPS_ID']][$arr['NAME']] = $arr['VALUE'];
		}
	}
}
/*/Адреса доставки*/

$showAddresList = (!empty($arAddresses));

if($_POST['action']=='next_step')
{
	$APPLICATION->RestartBuffer();
	$strError = '';
	if(!$GLOBALS['USER']->IsAuthorized())
	{
		if(!trim($_POST['ORDER']['USER']['EMAIL']))
		{
			$strError .= 'Не задан E-mail-адрес<br>';
		}
		$rsUser = CUser::GetByLogin($_POST['ORDER']['USER']['EMAIL']);
		$arUser = $rsUser->Fetch();
		if($arUser)
		{
			$strError .= 'Пользователь с указанным E-mail-адресом уже существует'."\r\n";
		}
	}
	
	if(strlen($strError)==0)
	{
		if($_POST['address_source'] && is_array($arAddresses[$_POST['ORDER']['ADDRESS_PROFILE']]))
		{
			foreach($arAddresses[$_POST['ORDER']['ADDRESS_PROFILE']] as $k=>$v)
			{
				$_POST['ORDER']['ADDRESS'][$k] = $v;
			}
		}
		$_SESSION['ORDER'] = $_POST['ORDER'];
		//LocalRedirect('/personal/payment/');
		$arResult = array('TYPE'=>'OK');
	}
	else
	{
		$arResult = array('TYPE'=>'ERROR', 'MESSAGE'=>$strError);
	}
	echo json_encode($arResult);
	die();
}

$arOrder = $_SESSION['ORDER'];
if(empty($arOrder))
{
	$arFilter = Array(
	   "USER_ID" => $USER->GetID()
	);

	$dbRes = CSaleOrder::GetList(array("DATE_INSERT" => "DESC"), $arFilter, false, array('nTopCount'=>1), array('ID'));
	if($arr = $dbRes->Fetch())
	{
		$orderId = $arr['ID'];
		
		$dbRes = CSaleOrderPropsValue::GetList(
			array(),
			array("ORDER_ID" => $orderId)
		);
		$arProps = array();
		while($arr = $dbRes->Fetch())
		{
			$arProps[$arr['CODE']] = $arr['VALUE'];
		}
		$arOrder['USER']['NAME'] = $arProps['USER_NAME'];
		$arOrder['USER']['PHONE'] = $arProps['USER_PHONE'];
	}
}

/*Службы доставки*/
$db_dtype = CSaleDelivery::GetList(
    array(
            "SORT" => "ASC",
            "NAME" => "ASC"
        ),
    array(
            "LID" => SITE_ID,
			"ACTIVE" => "Y"
        ),
    false,
    false,
    array()
);

$i=0;
$arDelivery = array();
while($ar_dtype = $db_dtype->Fetch())
{
	$arDelivery[] = $ar_dtype;
}
/*/Службы доставки*/
?>
<form method="post" action="" class="small config" id="deliveryForm" name="deliveryForm" validate="true">
	<input type="hidden" name="action" value="next_step">
	<input type="hidden" name="address_source" value="0">
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
	<?if(!$GLOBALS['USER']->IsAuthorized()){?>
		<p class="title-24 mmr">Быстрая регистрация</p>
		<input class="your-email" type="text" name="ORDER[USER][EMAIL]" value="<?=($arOrder['USER']['EMAIL'] ? $arOrder['USER']['EMAIL'] : 'Ваш e-mail')?>" initValue="Ваш e-mail" validate="not_empty email" title="Ваш e-mail">
		<p class="font-11 your-email-text">Уже зарегистрировались? <a href="javascript:void(0)" onclick="ShowLoginForm()" class="pink">Вход</a></p>
		<div class="hr"></div>
	<?}?>
	<p class="title-24 marg-t-b">Доставка</p>
	<div class="conditions-descr">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "page",
				"AREA_FILE_SUFFIX" => "delivery_inc",
				"EDIT_TEMPLATE" => ""
			)
		);?>
	</div>
	<div class="radios-customizes rdelivery">
			<div class="radios circled cust" dynamic_change="delivery">
<?
foreach($arDelivery as $k=>$v)
{
	$v['LOGOTIP'] = CFile::GetFileArray($v['LOGOTIP']);
	echo '<div class="radio-wrap"><div class="inner">';
	if(is_array($v['LOGOTIP']))
	{
		echo '<label for="delivery'.$v['ID'].'" class="img1" style="background-image:url('.$v['LOGOTIP']['SRC'].'); width:'.$v['LOGOTIP']['WIDTH'].'px; height:'.round($v['LOGOTIP']['HEIGHT']/2).'px" title="'.htmlspecialchars($v['NAME']).'"></label>
				<div class="img2" style="background-image:url('.$v['LOGOTIP']['SRC'].'); width:'.$v['LOGOTIP']['WIDTH'].'px; height:'.round($v['LOGOTIP']['HEIGHT']/2).'px" title="'.htmlspecialchars($v['NAME']).'"></div>';
	}
	else
	{
		echo '<label for="delivery'.$v['ID'].'" class="cash">'.$v['NAME'].'</label>';
	}
	echo '<input type="radio" class="niceRadio" name="ORDER[DELIVERY_ID]" id="delivery'.$v['ID'].'" value="'.$v['ID'].'" data-value="'.intval($v['PRICE']).'" '.($k==0 ? 'validate="not_empty"' : '').' title="Способ доставки" '.($k==0 ? 'checked' : '').'>
		  </div>
			'.($v['DESCRIPTION'] ? '<div class="info">'.$v['DESCRIPTION'].'</div>' : '').'
		  </div>';
	if($k%2==1)
	{
		echo '<div class="clear"></div>';
	}
              
    $k++;    
}
?>
</div>
		</div>

<div class="price_delivery">
	Стоимость <span class="dynamic_change_here" dynamic_change_here="delivery"><?=intval($arDelivery[0]['PRICE'])?></span> руб.
</div>

	<div class="clear"></div>
	<!--<table class="order-form">
		<tr class="title-24">
			<td colspan="2"><p>Кто будет получать</p></td>
			<td colspan="2"><p class="title-24">Куда доставить</p></td>
		</tr>
		<tr>
			<td class="one-hundr">Ф. И. О.</td>
			<td class="three-hundr"><input type="text" name="ORDER[USER][NAME]" value="<?=$arOrder['USER']['NAME']?>" validate="not_empty" title="Ф. И. О."></td>
			<td class="one-hundr">Город</td>
			<td><input type="text" name="ORDER[ADDRESS][CITY]" value="<?=$arOrder['ADDRESS']['CITY']?>" validate="not_empty" title="Город"></td>
		</tr>
		<tr>
			<td>Телефон</td>
			<td><input type="text" name="ORDER[USER][PHONE]" value="<?=$arOrder['USER']['PHONE']?>" validate="not_empty" title="Телефон"></td>
			<td>Адрес</td>
			<td><input type="text" name="ORDER[ADDRESS][ADDRESS]" value="<?=$arOrder['ADDRESS']['ADDRESS']?>" validate="not_empty" title="Адрес"></td>
		</tr>
		<tr>
			<td colspan="2" class="pink">Пожалуйста, введите паспортные данные получателя<br>(необходимо для логистической службы)</td>
			<td>Индекс</td>
			<td><input type="text" name="ORDER[ADDRESS][ZIP]" value="<?=$arOrder['ADDRESS']['ZIP']?>" validate="not_empty" title="Индекс"></td>
		</tr>
		<tr>
			<td>Серия</td>
			<td><input type="text" name="ORDER[USER][PASSPORT_SERIAL]" value="<?=$arOrder['USER']['PASSPORT_SERIAL']?>" validate="not_empty" title="Серия"></td>
			<td>Регион</td>
			<td><input type="text" name="ORDER[ADDRESS][AREA]" value="<?=$arOrder['ADDRESS']['AREA']?>" validate="not_empty" title="Регион"></td>
		</tr>
		<tr>
			<td>Номер</td>
			<td><input type="text" name="ORDER[USER][PASSPORT_NUMBER]" value="<?=$arOrder['USER']['PASSPORT_NUMBER']?>" validate="not_empty" title="Номер"></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Дата выдачи</td>
			<td><input type="text" name="ORDER[USER][PASSPORT_DATE]" value="<?=$arOrder['USER']['PASSPORT_DATE']?>" validate="not_empty" title="Дата выдачи"></td>
			<td colspan="2">
				<div class="radios-customizes">
					<div class="text-beige">Нет</div>
					<div class="radios squared">
						<input type="radio" class="niceRadio" name="ORDER[SAVE_ADDRESS_DELIVERY]" tabindex="1" value="N" <?=($arOrder['SAVE_ADDRESS_DELIVERY']!='Y' ? 'checked="checked"' : '')?> /> 
						<input type="radio" class="niceRadio" name="ORDER[SAVE_ADDRESS_DELIVERY]" tabindex="2" value="Y" <?=($arOrder['SAVE_ADDRESS_DELIVERY']=='Y' ? 'checked="checked"' : '')?> /> 
					</div>
					<div class="text-beige">Да</div>
				</div>
				<span class="font-16 save-address">сохранить адрес доставки</span>
			</td>
		</tr>
	</table>-->
	
	<table class="order-form">
		<tr>
			<td class="col" rowspan="2">
				<table>
					<tr class="title-24">
						<td colspan="2"><p>Кто будет получать</p></td>
					</tr>
					<tr>
						<td class="one-hundr">Ф. И. О.</td>
						<td class="three-hundr"><input type="text" name="ORDER[USER][NAME]" value="<?=$arOrder['USER']['NAME']?>" validate="not_empty" title="Ф. И. О."></td>
					</tr>
					<tr>
						<td>Телефон</td>
						<td><input type="text" name="ORDER[USER][PHONE]" value="<?=$arOrder['USER']['PHONE']?>" validate="not_empty" title="Телефон"></td>
					</tr>
					<!--<tr>
						<td colspan="2" class="pink">Пожалуйста, введите паспортные данные получателя<br>(необходимо для логистической службы)</td>
					</tr>
					<tr>
						<td>Серия</td>
						<td><input type="text" name="ORDER[USER][PASSPORT_SERIAL]" value="<?=$arOrder['USER']['PASSPORT_SERIAL']?>" validate="not_empty" title="Серия"></td>
					</tr>
					<tr>
						<td>Номер</td>
						<td><input type="text" name="ORDER[USER][PASSPORT_NUMBER]" value="<?=$arOrder['USER']['PASSPORT_NUMBER']?>" validate="not_empty" title="Номер"></td>
					</tr>
					<tr>
						<td>Дата выдачи</td>
						<td><input type="text" name="ORDER[USER][PASSPORT_DATE]" value="<?=$arOrder['USER']['PASSPORT_DATE']?>" validate="not_empty" title="Дата выдачи"></td>
					</tr>-->
				</table>
			</td>
			<td class="col">
				<table width="410px">
					<tr class="title-24">
						<td colspan="2"><p class="title-24">Куда доставить</p></td>
					</tr>
					<?
					if($showAddresList)
					{
						echo '<tr><td colspan="2"><div class="oaddr" id="oaddr">';
						$i = 0;
						foreach($arAddresses as $k=>$v)
						{
							$name = implode(', ', array_diff(array($v['CITY'], $v['ADDRESS']), array('')));
							echo '<div class="item">
									<input type="radio" name="ORDER[ADDRESS_PROFILE]" value="'.$k.'" id="address'.$k.'" '.($i==0 ? 'validate="not_empty" title="Адрес доставки"' : '').' '.(($arOrder['ADDRESS_PROFILE']==$k || (!$arOrder['ADDRESS_PROFILE'] && $arUser['UF_BASIC_ADDRESS']==$k)) ? 'checked="checked"' : '').'>
									<label for="address'.$k.'">'.$name.'</label>
								  </div>';
							$i++;
						}
						echo '<div class="add_block"><a class="add" href="javascript:void(0)" onclick="Order.ShowAddressField(this);">добавить адрес доставки</a></div></div></td></tr>';
					}
					?>
					<tfoot id="address_fields" <?=($showAddresList ? 'style="display:none;"' : '');?>>
						<tr>
							<td>Индекс</td>
							<td><input type="text" name="ORDER[ADDRESS][ZIP]" value="<?=$arOrder['ADDRESS']['ZIP']?>" validate="not_empty" title="Индекс"></td>
						</tr>
						<tr>
							<td>Регион</td>
							<td><input type="text" name="ORDER[ADDRESS][AREA]" value="<?=$arOrder['ADDRESS']['AREA']?>" validate="not_empty" title="Регион"></td>
						</tr>
						<tr>
							<td class="one-hundr">Город</td>
							<td><input type="text" name="ORDER[ADDRESS][CITY]" value="<?=$arOrder['ADDRESS']['CITY']?>" validate="not_empty" title="Город"></td>
						</tr>
						<tr>
							<td>Адрес</td>
							<td><input type="text" name="ORDER[ADDRESS][ADDRESS]" value="<?=$arOrder['ADDRESS']['ADDRESS']?>" validate="not_empty" title="Адрес"></td>
						</tr>
					</tfoot>
				</table>
			</td>
		</tr>
		<tr>
			<td class="col_bottom" <?=($showAddresList ? 'style="display:none;"' : '');?>>
				<div class="radios-customizes">
					<div class="text-beige">Нет</div>
					<div class="radios squared">
						<input type="radio" class="niceRadio" name="ORDER[SAVE_ADDRESS_DELIVERY]" tabindex="1" value="N" <?=($arOrder['SAVE_ADDRESS_DELIVERY']!='Y' ? 'checked="checked"' : '')?> /> 
						<input type="radio" class="niceRadio" name="ORDER[SAVE_ADDRESS_DELIVERY]" tabindex="2" value="Y" <?=($arOrder['SAVE_ADDRESS_DELIVERY']=='Y' ? 'checked="checked"' : '')?> /> 
					</div>
					<div class="text-beige">Да</div>
				</div>
				<span class="font-16 save-address">сохранить адрес доставки</span>
			</td>
		</tr>
	</table>
	
	<div class="hr"></div>
	<!--config footer-->
	<section class="cont-controls">
		<input type="submit" class="create_hair_system2 pink-button radiused" value="Cледующий шаг" onclick="return Order.SetDelivery(this);">
		<span class="beige"> или</span>
		<a class="pink" href="/personal/basket/">вернуться к формированию заказа</a>
		<br><div class="next-step-descr">Перейти к оплате</div>
	</section>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>