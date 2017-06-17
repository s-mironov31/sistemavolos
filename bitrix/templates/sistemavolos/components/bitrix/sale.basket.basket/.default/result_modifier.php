<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule('iblock');

$arIds = array();
foreach($arResult['GRID']['ROWS'] as $k=>$v)
{
	$arIds[] = $v['PRODUCT_ID'];
}

/*/Свойства системы волос*/
$arProps = array(
	'PROPERTY_LENGTH' => 'Длина',
	'PROPERTY_COLOR.NAME' => 'Цвет',
	'PROPERTY_WAVE.NAME' => 'Завивка',
	'PROPERTY_IMITATION_SKIN.NAME' => 'Имитация кожного покрова',
	'PROPERTY_VOLUME' => 'Объем',
	'PROPERTY_BASIS.NAME' => 'Основа'
);
$arSelect = array_merge(array('ID'), array_keys($arProps));
$dbRes = CIblockElement::GetList(array(), array('ID'=>$arIds, 'IBLOCK_ID'=>3), false, false, $arSelect);
$arProductProps = array();
while($arr = $dbRes->Fetch())
{
	foreach($arr as $k=>$v)
	{
		if($v)
		{
			if($k=='PROPERTY_LENGTH_VALUE') $v .= ' см';
			if(preg_match('/^PROPERTY_(\S+)_VALUE$/', $k, $m))
			{
				$arProductProps[$arr['ID']][$m[1]] = array(
					'TITLE' => $arProps['PROPERTY_'.$m[1]],
					'VALUE' => $v
				);
			}
			elseif(preg_match('/^PROPERTY_(\S+)_NAME$/', $k, $m))
			{
				$arProductProps[$arr['ID']][$m[1]] = array(
					'TITLE' => $arProps['PROPERTY_'.$m[1].'.NAME'],
					'VALUE' => $v
				);
			}
		}
	}
}
$arResult['PRODUCT_PROPS'] = $arProductProps;
/*Свойства системы волос*/


$arPictures = array();
$dbRes = CIblockElement::GetList(array(), array('ID'=>$arIds), false, false, array('ID', 'PREVIEW_PICTURE'));
while($arr = $dbRes->Fetch())
{
	$arPictures[$arr['ID']] = CFile::GetFileArray($arr['PREVIEW_PICTURE']);
}
$arResult['PICTURES'] = $arPictures;
?>