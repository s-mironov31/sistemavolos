<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult);?>
<? echo $arResult["NAV_STRING"]; ?>
<?
foreach($arResult['ITEMS'] as $k=>$v)
{
	$arProps = array();
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
	}
	
	echo '<section class="one-element">		
			<div class="example-wrap">
				<div class="example-block">
					<div class="img"><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" height="222px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></div>
					<p class="descr" style="text-align: center;">'.$v['NAME'].'</p>
					<!--'.$props.'
					<p class="price"><span class="frm">oт</span> <span class="prc">'.number_format($v['PROPERTIES']['MIN_PRICE']['VALUE'], 0, '', ' ').' р.</p>
					<a href="/create-system/?example='.$v['ID'].'" class="radiused more-and-order">Уточнить и заказать</a>-->
				</div>
				<div class="clear"></div>
				<div class="delete-btn"></div>
			</div>
			<div class="example-block">
				<div class="img"><a href="javascript:void(0)" onclick="ShowExample(this)"><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" height="222px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></a></div>
				<p class="descr" style="text-align: center;">'.$v['NAME'].'</p>
				<!--<p class="price"><span class="frm">oт</span> <span class="prc">'.number_format($v['PROPERTIES']['MIN_PRICE']['VALUE'], 0, '', ' ').' р.</p>
				<a href="/create-system/?example='.$v['ID'].'" class="radiused more-and-order">Уточнить и заказать</a>-->
			</div>
			<div class="clear"></div>
		</section>';
}
?>
<div class="clear"></div>
<? echo $arResult["NAV_STRING"]; ?>