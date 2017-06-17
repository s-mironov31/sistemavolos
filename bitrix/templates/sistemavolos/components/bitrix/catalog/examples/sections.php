<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
CModule::IncludeModule('iblock');

if($_POST['AJAX']!='Y')
{

$minPrice = 10000;
$maxPrice = 40000;
$dbRes = CIblockElement::GetList(array('PROPERTY_MIN_PRICE'=>'ASC'), array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'ACTIVE'=>'Y'), false, array('nTopCount'=>1), array('PROPERTY_MIN_PRICE'));
if($arr = $dbRes->Fetch())
{
	$minPrice = intval($arr['PROPERTY_MIN_PRICE_VALUE']);
}

$dbRes = CIblockElement::GetList(array('PROPERTY_MIN_PRICE'=>'DESC'), array('IBLOCK_ID'=>$arParams["IBLOCK_ID"], 'ACTIVE'=>'Y'), false, array('nTopCount'=>1), array('PROPERTY_MIN_PRICE'));
if($arr = $dbRes->Fetch())
{
	$maxPrice = intval($arr['PROPERTY_MIN_PRICE_VALUE']);
}
?>
<!--
<div class="options">
	<div class="slider_price" >
		<div class="s-line"><div class="l"></div><div class="r"></div></div>
		<div class="slider-lbl"><span></span></div>
		<div class="slider-lbl jslider-label-to"><span></span></div>
	</div>
</div>


<script>
$(function() {
var min_ = <?=$minPrice?>;
var max_ = <?=$maxPrice?>;
var measure = 'p.';
	$( ".slider_price" ).slider({
		range: true,
		min:min_,
		step:1000,
		max: max_,
		values: [<?=($_REQUEST['PRICE_FROM'] ? intval($_REQUEST['PRICE_FROM']) : $minPrice)?>, <?=($_REQUEST['PRICE_TO'] ? intval($_REQUEST['PRICE_TO']) : $maxPrice)?>],
		slide: function( event, ui ) {
			$('.slider_price .slider-cur-value').eq(0).text(ui.values[0]+measure);
			$('.slider_price .slider-cur-value-pink span').eq(0).text(ui.values[0]+measure);
			$('.slider_price .slider-cur-value').eq(1).text(ui.values[1]+measure);
			$('.slider_price .slider-cur-value-pink span').eq(1).text(ui.values[1]+measure);
			
			$.post(window.location.pathname+'?PRICE_FROM='+ui.values[0]+'&PRICE_TO='+ui.values[1], {'AJAX':'Y'}, function(data){
				$('#examples').html(data);
			});
		}
	});
	
	//начальные значения
	$('.slider_price .slider-lbl span').text(min_+measure);
	$('.slider_price .slider-lbl.jslider-label-to span').text(max_+measure);
	
	$(".ui-slider-handle").html('<div class="slider-cur-value"></div><div class="slider-cur-value-pink"><div class="triangle"></div><span></span></div>');
	
	$('.slider_price .slider-cur-value').eq(0).text($('.slider_price').slider("values",0)+measure);
	$('.slider_price .slider-cur-value-pink span').eq(0).text($('.slider_price').slider("values",0)+measure);
	$('.slider_price .slider-cur-value').eq(1).text($('.slider_price').slider("values",1)+measure);
	$('.slider_price .slider-cur-value-pink span').eq(1).text($('.slider_price').slider("values",1)+measure);
			
	var pink_wi = parseInt($('.slider-cur-value-pink').css("width"));
	$('.slider-cur-value-pink').css("min-width",pink_wi);
	$('.slider-cur-value').css("min-width",pink_wi);
	var pink_left = -pink_wi/2;
	$('.slider-cur-value-pink').css("left",pink_left);
	$('.slider-cur-value').css("left",pink_left);

});
</script>
-->
<div id="examples">
<?
}

global $arFilter;
$arFilter = array();
if($_REQUEST['PRICE_FROM']) $arFilter['>=PROPERTY_MIN_PRICE'] = $_REQUEST['PRICE_FROM'];
if($_REQUEST['PRICE_TO']) $arFilter['<=PROPERTY_MIN_PRICE'] = $_REQUEST['PRICE_TO'];

$intSectionID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"",
	array(
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID" => $arParams["IBLOCK_ID"],
		"ELEMENT_SORT_FIELD" => $arParams["ELEMENT_SORT_FIELD"],
		"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_ORDER" => $arParams["ELEMENT_SORT_ORDER"],
		"ELEMENT_SORT_FIELD2" => $arParams["ELEMENT_SORT_FIELD2"],
		"ELEMENT_SORT_ORDER2" => $arParams["ELEMENT_SORT_ORDER2"],
		"PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
		"META_KEYWORDS" => $arParams["LIST_META_KEYWORDS"],
		"META_DESCRIPTION" => $arParams["LIST_META_DESCRIPTION"],
		"BROWSER_TITLE" => $arParams["LIST_BROWSER_TITLE"],
		"INCLUDE_SUBSECTIONS" => $arParams["INCLUDE_SUBSECTIONS"],
		"BASKET_URL" => $arParams["BASKET_URL"],
		"ACTION_VARIABLE" => $arParams["ACTION_VARIABLE"],
		"PRODUCT_ID_VARIABLE" => $arParams["PRODUCT_ID_VARIABLE"],
		"SECTION_ID_VARIABLE" => $arParams["SECTION_ID_VARIABLE"],
		"PRODUCT_QUANTITY_VARIABLE" => $arParams["PRODUCT_QUANTITY_VARIABLE"],
		"PRODUCT_PROPS_VARIABLE" => $arParams["PRODUCT_PROPS_VARIABLE"],
		"FILTER_NAME" => 'arFilter',
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		"CACHE_FILTER" => $arParams["CACHE_FILTER"],
		"CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
		"SET_TITLE" => $arParams["SET_TITLE"],
		"SET_STATUS_404" => $arParams["SET_STATUS_404"],
		"DISPLAY_COMPARE" => $arParams["USE_COMPARE"],
		"PAGE_ELEMENT_COUNT" => $arParams["PAGE_ELEMENT_COUNT"],
		"LINE_ELEMENT_COUNT" => $arParams["LINE_ELEMENT_COUNT"],
		"PRICE_CODE" => $arParams["PRICE_CODE"],
		"USE_PRICE_COUNT" => $arParams["USE_PRICE_COUNT"],
		"SHOW_PRICE_COUNT" => $arParams["SHOW_PRICE_COUNT"],

		"PRICE_VAT_INCLUDE" => $arParams["PRICE_VAT_INCLUDE"],
		"USE_PRODUCT_QUANTITY" => $arParams['USE_PRODUCT_QUANTITY'],
		"ADD_PROPERTIES_TO_BASKET" => (isset($arParams["ADD_PROPERTIES_TO_BASKET"]) ? $arParams["ADD_PROPERTIES_TO_BASKET"] : ''),
		"PARTIAL_PRODUCT_PROPERTIES" => (isset($arParams["PARTIAL_PRODUCT_PROPERTIES"]) ? $arParams["PARTIAL_PRODUCT_PROPERTIES"] : ''),
		"PRODUCT_PROPERTIES" => $arParams["PRODUCT_PROPERTIES"],

		"DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
		"DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
		"PAGER_TITLE" => $arParams["PAGER_TITLE"],
		"PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
		"PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
		"PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
		"PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
		"PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],

		"OFFERS_CART_PROPERTIES" => $arParams["OFFERS_CART_PROPERTIES"],
		"OFFERS_FIELD_CODE" => $arParams["LIST_OFFERS_FIELD_CODE"],
		"OFFERS_PROPERTY_CODE" => $arParams["LIST_OFFERS_PROPERTY_CODE"],
		"OFFERS_SORT_FIELD" => $arParams["OFFERS_SORT_FIELD"],
		"OFFERS_SORT_ORDER" => $arParams["OFFERS_SORT_ORDER"],
		"OFFERS_SORT_FIELD2" => $arParams["OFFERS_SORT_FIELD2"],
		"OFFERS_SORT_ORDER2" => $arParams["OFFERS_SORT_ORDER2"],
		"OFFERS_LIMIT" => $arParams["LIST_OFFERS_LIMIT"],

		"SECTION_ID" => $arResult["VARIABLES"]["SECTION_ID"],
		"SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
		"SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
		"DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["element"],
		'CONVERT_CURRENCY' => $arParams['CONVERT_CURRENCY'],
		'CURRENCY_ID' => $arParams['CURRENCY_ID'],
		'HIDE_NOT_AVAILABLE' => $arParams["HIDE_NOT_AVAILABLE"],

		'LABEL_PROP' => $arParams['LABEL_PROP'],
		'ADD_PICT_PROP' => $arParams['ADD_PICT_PROP'],
		'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],

		'OFFER_ADD_PICT_PROP' => $arParams['OFFER_ADD_PICT_PROP'],
		'OFFER_TREE_PROPS' => $arParams['OFFER_TREE_PROPS'],
		'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
		'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
		'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
		'MESS_BTN_BUY' => $arParams['MESS_BTN_BUY'],
		'MESS_BTN_ADD_TO_BASKET' => $arParams['MESS_BTN_ADD_TO_BASKET'],
		'MESS_BTN_SUBSCRIBE' => $arParams['MESS_BTN_SUBSCRIBE'],
		'MESS_BTN_DETAIL' => $arParams['MESS_BTN_DETAIL'],
		'MESS_NOT_AVAILABLE' => $arParams['MESS_NOT_AVAILABLE'],

		'TEMPLATE_THEME' => (isset($arParams['TEMPLATE_THEME']) ? $arParams['TEMPLATE_THEME'] : ''),
		"ADD_SECTIONS_CHAIN" => "N",
		"SHOW_ALL_WO_SECTION" => "Y"
	),
	$component
);

if($_POST['AJAX']!='Y')
{
?>
</div>
<?
}
?>