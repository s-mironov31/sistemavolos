<?
define('NOT_SHOW_TITLE', 'Y');
/*$showContent = function(){
	$GLOBALS['APPLICATION']->IncludeComponent(
		"bitrix:catalog",
		"",
		Array(
			"IBLOCK_TYPE" => "system",
			"IBLOCK_ID" => "2",
			"HIDE_NOT_AVAILABLE" => "N",
			"TEMPLATE_THEME" => "",
			"SHOW_DISCOUNT_PERCENT" => "N",
			"SHOW_OLD_PRICE" => "N",
			"DETAIL_SHOW_MAX_QUANTITY" => "N",
			"MESS_BTN_BUY" => "Купить",
			"MESS_BTN_ADD_TO_BASKET" => "В корзину",
			"MESS_BTN_COMPARE" => "Сравнение",
			"MESS_BTN_DETAIL" => "Подробнее",
			"MESS_NOT_AVAILABLE" => "Нет в наличии",
			"DETAIL_USE_VOTE_RATING" => "N",
			"DETAIL_USE_COMMENTS" => "N",
			"DETAIL_BRAND_USE" => "N",
			"SECTION_ID_VARIABLE" => "SECTION_ID",
			"SEF_MODE" => "Y",
			"SEF_FOLDER" => "/e-store/",
			"SEF_URL_TEMPLATES" => array(
				"sections" => "",
				"section" => "#SECTION_CODE#/",
				"element" => "#SECTION_CODE#/#ELEMENT_ID#/",
				"compare" => "compare.php?action=#ACTION_CODE#",
			),
			"VARIABLE_ALIASES" => array(
				"compare" => array(
					"ACTION_CODE" => "action",
				),
			),
			"AJAX_MODE" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"AJAX_OPTION_HISTORY" => "N",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_FILTER" => "N",
			"CACHE_GROUPS" => "Y",
			"SET_STATUS_404" => "Y",
			"SET_TITLE" => "Y",
			"ADD_SECTIONS_CHAIN" => "N",
			"ADD_ELEMENT_CHAIN" => "N",
			"USE_ELEMENT_COUNTER" => "N",
			"USE_FILTER" => "N",
			"FILTER_VIEW_MODE" => "VERTICAL",
			"USE_REVIEW" => "N",
			"USE_COMPARE" => "N",
			"PRICE_CODE" => array("BASE"),
			"USE_PRICE_COUNT" => "N",
			"SHOW_PRICE_COUNT" => "1",
			"PRICE_VAT_INCLUDE" => "Y",
			"PRICE_VAT_SHOW_VALUE" => "N",
			"CONVERT_CURRENCY" => "N",
			"BASKET_URL" => "/personal/basket/",
			"ACTION_VARIABLE" => "action",
			"PRODUCT_ID_VARIABLE" => "id",
			"USE_PRODUCT_QUANTITY" => "N",
			"ADD_PROPERTIES_TO_BASKET" => "Y",
			"PRODUCT_PROPS_VARIABLE" => "prop",
			"PARTIAL_PRODUCT_PROPERTIES" => "N",
			"PRODUCT_PROPERTIES" => array(),
			"SHOW_TOP_ELEMENTS" => "N",
			"TOP_ELEMENT_COUNT" => "9",
			"TOP_LINE_ELEMENT_COUNT" => "3",
			"TOP_ELEMENT_SORT_FIELD" => "",
			"TOP_ELEMENT_SORT_ORDER" => "",
			"TOP_ELEMENT_SORT_FIELD2" => "",
			"TOP_ELEMENT_SORT_ORDER2" => "",
			"TOP_PROPERTY_CODE" => array("",""),
			"SECTION_COUNT_ELEMENTS" => "N",
			"SECTION_TOP_DEPTH" => "2",
			"SECTIONS_VIEW_MODE" => "LIST",
			"SECTIONS_SHOW_PARENT_NAME" => "Y",
			"PAGE_ELEMENT_COUNT" => "6",
			"LINE_ELEMENT_COUNT" => "3",
			"ELEMENT_SORT_FIELD" => "",
			"ELEMENT_SORT_ORDER" => "",
			"ELEMENT_SORT_FIELD2" => "",
			"ELEMENT_SORT_ORDER2" => "",
			"LIST_PROPERTY_CODE" => array("",""),
			"INCLUDE_SUBSECTIONS" => "Y",
			"LIST_META_KEYWORDS" => "-",
			"LIST_META_DESCRIPTION" => "-",
			"LIST_BROWSER_TITLE" => "-",
			"DETAIL_PROPERTY_CODE" => array("",""),
			"DETAIL_META_KEYWORDS" => "-",
			"DETAIL_META_DESCRIPTION" => "-",
			"DETAIL_BROWSER_TITLE" => "-",
			"DETAIL_DISPLAY_NAME" => "Y",
			"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
			"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
			"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "H",
			"LINK_IBLOCK_TYPE" => "",
			"LINK_IBLOCK_ID" => "",
			"LINK_PROPERTY_SID" => "",
			"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
			"USE_ALSO_BUY" => "N",
			"USE_STORE" => "N",
			"PAGER_TEMPLATE" => "",
			"DISPLAY_TOP_PAGER" => "N",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"PAGER_TITLE" => "Товары",
			"PAGER_SHOW_ALWAYS" => "Y",
			"PAGER_DESC_NUMBERING" => "N",
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
			"PAGER_SHOW_ALL" => "Y"
		)
	);
};

if($_REQUEST['AJAX']=='Y')
{
	unset($_REQUEST['AJAX'], $_GET['AJAX'], $_POST['AJAX']);
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->SetPageProperty("description", "Ленты, клеи, раствроители и другие сопуствующие товары для приобретаемых систем замещения волос в интернет-магазине \"Система Волос\"");
	$showContent();
	die();
}
*/
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
//$APPLICATION->SetTitle("Сопутствующие товары для систем волос | Интернет-магазин \"Система Волос\"");
echo '<div id="pcatalog">';
$APPLICATION->IncludeComponent(
	"bitrix:catalog", 
	".default1", 
	array(
		"IBLOCK_TYPE" => "system",
		"IBLOCK_ID" => "2",
		"HIDE_NOT_AVAILABLE" => "N",
		"TEMPLATE_THEME" => "",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_OLD_PRICE" => "N",
		"DETAIL_SHOW_MAX_QUANTITY" => "N",
		"MESS_BTN_BUY" => "Купить",
		"MESS_BTN_ADD_TO_BASKET" => "В корзину",
		"MESS_BTN_COMPARE" => "Сравнение",
		"MESS_BTN_DETAIL" => "Подробнее",
		"MESS_NOT_AVAILABLE" => "Нет в наличии",
		"DETAIL_USE_VOTE_RATING" => "N",
		"DETAIL_USE_COMMENTS" => "N",
		"DETAIL_BRAND_USE" => "N",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SEF_MODE" => "Y",
		"SEF_FOLDER" => "/e-store/",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"SET_STATUS_404" => "Y",
		"SET_TITLE" => "Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_ELEMENT_CHAIN" => "N",
		"USE_ELEMENT_COUNTER" => "N",
		"USE_FILTER" => "N",
		"FILTER_VIEW_MODE" => "VERTICAL",
		"USE_REVIEW" => "N",
		"USE_COMPARE" => "N",
		"PRICE_CODE" => array(
			0 => "BASE",
		),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"CONVERT_CURRENCY" => "N",
		"BASKET_URL" => "/personal/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"USE_PRODUCT_QUANTITY" => "N",
		"ADD_PROPERTIES_TO_BASKET" => "Y",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRODUCT_PROPERTIES" => array(
		),
		"SHOW_TOP_ELEMENTS" => "N",
		"TOP_ELEMENT_COUNT" => "9",
		"TOP_LINE_ELEMENT_COUNT" => "3",
		"TOP_ELEMENT_SORT_FIELD" => "",
		"TOP_ELEMENT_SORT_ORDER" => "",
		"TOP_ELEMENT_SORT_FIELD2" => "",
		"TOP_ELEMENT_SORT_ORDER2" => "",
		"TOP_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"SECTION_COUNT_ELEMENTS" => "N",
		"SECTION_TOP_DEPTH" => "2",
		"SECTIONS_VIEW_MODE" => "LIST",
		"SECTIONS_SHOW_PARENT_NAME" => "Y",
		"PAGE_ELEMENT_COUNT" => "6",
		"LINE_ELEMENT_COUNT" => "3",
		"ELEMENT_SORT_FIELD" => "",
		"ELEMENT_SORT_ORDER" => "",
		"ELEMENT_SORT_FIELD2" => "",
		"ELEMENT_SORT_ORDER2" => "",
		"LIST_PROPERTY_CODE" => array(
			0 => "",
			1 => "",
		),
		"INCLUDE_SUBSECTIONS" => "Y",
		"LIST_META_KEYWORDS" => "-",
		"LIST_META_DESCRIPTION" => "-",
		"LIST_BROWSER_TITLE" => "-",
		"DETAIL_PROPERTY_CODE" => array(
			0 => "",
			1 => "MORE_PHOTO",
			2 => "",
		),
		"DETAIL_META_KEYWORDS" => "-",
		"DETAIL_META_DESCRIPTION" => "-",
		"DETAIL_BROWSER_TITLE" => "-",
		"DETAIL_DISPLAY_NAME" => "Y",
		"DETAIL_DETAIL_PICTURE_MODE" => "IMG",
		"DETAIL_ADD_DETAIL_TO_SLIDER" => "N",
		"DETAIL_DISPLAY_PREVIEW_TEXT_MODE" => "H",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
		"USE_ALSO_BUY" => "N",
		"USE_STORE" => "N",
		"PAGER_TEMPLATE" => "",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"ADD_PICT_PROP" => "-",
		"LABEL_PROP" => "-",
		"AJAX_OPTION_ADDITIONAL" => "",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"SEF_URL_TEMPLATES" => array(
			"sections" => "",
			"section" => "#SECTION_CODE#/",
			"element" => "#SECTION_CODE#/#ELEMENT_ID#/",
			"compare" => "compare.php?action=#ACTION_CODE#",
		),
		"VARIABLE_ALIASES" => array(
			"compare" => array(
				"ACTION_CODE" => "action",
			),
		)
	),
	false
);
echo '</div>';
?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>