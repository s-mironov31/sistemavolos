<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule('sale');

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
	$arProps = array();
	while($arr = $dbRes->Fetch())
	{
		$arProps[$arr['USER_PROPS_ID']][$arr['ID']] = $arr;
	}
}

foreach($arProps as $k=>$v)
{
	echo '<div class="item">
			<a href="javascript:void(0)" class="remove" title="Удалить" onclick="Address.Remove('.$k.')"></a>
			<div class="basic">
				<input type="radio" name="basic" value="'.$k.'" id="basic_'.$k.'" '.($arUser['UF_BASIC_ADDRESS']==$k ? 'checked="checked"' : '').'>
				<label for="basic_'.$k.'">сделать основным адресом</label>
				<a href="javascript:void(0)" onclick="Address.SetBasic('.$k.')">Ок</a>
			</div>
			<table>';
	foreach($v as $k2=>$v2)
	{
		echo '<tr>
				<td>'.$v2['PROP_NAME'].'</td>
				<td>'.$v2['VALUE'].'</td>
			  </tr>';
	}			
	echo '</table>
		  </div>';
}
?>
