<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arSections = array();
foreach($arResult['ITEMS'] as $k=>$v)
{
	$arSections[$v['IBLOCK_SECTION_ID']] = $v['IBLOCK_SECTION_ID'];
}

if(!empty($arSections))
{
	$arFilter = Array("IBLOCK_ID"=>$arResult['IBLOCK_ID'], "ID"=>$arSections);
	$dbRes = CIBlockSection::GetList(Array(), $arFilter);
	while($arr = $dbRes->Fetch())
	{
		$arSections[$arr['ID']] = $arr;
	}
}

$arResult['SECTIONS'] = $arSections;
?>

