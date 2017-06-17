<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');
$PERSON_TYPE_ID = 1;

if($_POST['action']=='set_basic_address' && $_POST['id'])
{
	$user = new CUser;
	$user->Update($GLOBALS['USER']->GetID(), array('UF_BASIC_ADDRESS'=>$_POST['id']));
	die();
}

if($_POST['action']=='delete' && $_POST['id'])
{
	CSaleOrderUserPropsValue::DeleteAll($_POST['id']);
	CSaleOrderUserProps::Delete($_POST['id']);
	
	include(__DIR__.'/address_list.php');
	die();
}

if(is_array($_POST['ADDRESS']))
{
	if(!$GLOBALS['USER']->GetID()) die();
	$arAddr = $_POST['ADDRESS'];
	
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
	
	include(__DIR__.'/address_list.php');
	die();
}
?>
	<div class="log_in-fix addr-form" id="addrForm">
		<div class="log_in">
			<p class="tttl">Добавить адрес доставки</p>
			<form method="post" target="hidden_frame" action="/personal/address/form.php" target="hidden_frame" validate="true">
				<input type="hidden" name="send" value="0">
				<table>
					<tr>
						<td>Город</td>
						<td><input type="text" name="ADDRESS[CITY]" value="" validate="not_empty" title="Город"></td>
					</tr>
					<tr>
						<td>Адрес</td>
						<td><input type="text" name="ADDRESS[ADDRESS]" value="" validate="not_empty" title="Адрес"></td>
					</tr>
					<tr>
						<td>Индекс</td>
						<td><input type="text" name="ADDRESS[ZIP]" value="" validate="not_empty" title="Индекс"></td>
					</tr>
					<tr>
						<td>Регион</td>
						<td><input type="text" name="ADDRESS[AREA]" value="" validate="not_empty" title="Регион"></td>
					</tr>
				</table>
				<input type="submit" class="rounded" value="сохранить" onclick="return Address.Add(this);">
			</form>
			<div class="clear"></div>
			<div class="delete-btn" title="Закрыть"></div>
		</div>
	</div>