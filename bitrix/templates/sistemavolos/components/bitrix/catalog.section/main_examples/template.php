<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<p class="title">Примеры системы волос</p>
<div class="title-24 examlpe">Каталог примеров системы волос с учетом некоторых параметров, на основе которых вы можете 
	<a class="create_hair_system2 blue-button radiused" href="/create-system/">создать свою систему волос</a>
</div>
<div class="clear"></div>		

<?
foreach($arResult['ITEMS'] as $k=>$v)
{
	/*$arProps = array();
	if($v['DISPLAY_PROPERTIES']['LENGTH']['VALUE'])
	{
		$arProps['длина'] = $v['DISPLAY_PROPERTIES']['LENGTH']['VALUE'].' см';
	}
	if($v['DISPLAY_PROPERTIES']['COLOR']['VALUE'])
	{
		$arProps['цвет'] = $v['DISPLAY_PROPERTIES']['COLOR']['LINK_ELEMENT_VALUE'][$v['DISPLAY_PROPERTIES']['COLOR']['VALUE']]['NAME'];
	}
	if($v['DISPLAY_PROPERTIES']['WAVE']['VALUE'])
	{
		$arProps['завивка'] = $v['DISPLAY_PROPERTIES']['WAVE']['LINK_ELEMENT_VALUE'][$v['DISPLAY_PROPERTIES']['WAVE']['VALUE']]['NAME'];
	}
	if($v['DISPLAY_PROPERTIES']['VOLUME']['VALUE'])
	{
		$arProps['объем'] = $v['DISPLAY_PROPERTIES']['VOLUME']['VALUE'].'%';
	}
	if($v['DISPLAY_PROPERTIES']['BASIS']['VALUE'])
	{
		$arProps['основа'] = $v['DISPLAY_PROPERTIES']['BASIS']['LINK_ELEMENT_VALUE'][$v['DISPLAY_PROPERTIES']['BASIS']['VALUE']]['NAME'];
	}
	$props = '';
	foreach($arProps as $k2=>$v2)
	{
		$props .= '<p class="font-12">'.$v2.' <span class="black">'.$k2.'</span></p>';
	}*/
	
	echo '<div class="example-block">
			<div class="img">
				<img src="'.$v['PREVIEW_PICTURE']['SRC'].'" height="222px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'">
			</div>
			<p class="descr">'.$v['NAME'].'</p>
			<!--<p class="price"><span class="frm">oт</span> <span class="prc">'.number_format($v['PROPERTIES']['MIN_PRICE']['VALUE'], 0, '', ' ').' р.</p>
			<a href="/create-system/?example='.$v['ID'].'" class="radiused more-and-order">Уточнить и заказать</a>-->
		</div>';
}
?>
<div class="clear"></div>
<a href="/examples/" class="to-all examples">все примеры</a>
<div class="clear"></div>