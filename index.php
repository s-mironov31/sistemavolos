<?
define('MAINPAGE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords_inner", "система волос, система волос купить, система замещения волос, система волос цена");
$APPLICATION->SetPageProperty("keywords", "система волос, система волос купить, система замещения волос, система волос цена");
$APPLICATION->SetPageProperty("description", "Предлагаем систему замещения волос по низким ценам с бесплатной доставкой по всей России! Возврат денежных стредств по первому требованию.");
$APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y");
$APPLICATION->SetTitle("Система волос: легко купить по низкой цене, не выходя из дома! | Интернет-магазин «Система Волос»");
?><!--<div class="main-banner large">
		<div class="small">
			<div class="m-b-text">
				<p class="ttl">Заказать систему волос<br>без посещения салона </p>
				<p class="grey-ul">- Система от 23500 руб.</p>
				<p class="grey-ul">- Ремонт от 7000 руб.</p>
				<p class="description">Изготовление систем волос любой сложности на заказ по вашим индивидуальным параметрам. Создать свою систему волос с помощью нашего онлайн-конфигуратора.</p>
				<div class="create_hair_system"></div>
			</div>
			
		</div>
	</div>-->
	
	<div class="main-banner large">
		<div class="grl"></div>
		<div class="fifty">
			<div class="m-b-text">
				<p class="ttl">Вы можете заказать систему из натуральных волос без посещения салона </p>
				<p class="grey-ul">-Система от 26800 руб.</p>
				<p class="grey-ul">-Ремонт от 7000 руб.</p>
				<p class="description simple-text">Изготовление систем волос любой сложности на заказ по вашим индивидуальным параметрам. Создайте свою систему волос с помощью нашего онлайн-конфигуратора.</p>
				<a href="/create-system/" class="create_hair_system" title="Создать свою систему волос"></a>
			</div>
			
		</div>
	</div>
	
	<div class="small main-text">
		<article class="main-2-left-text">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"EDIT_TEMPLATE" => "",
					"PATH" => "/include_areas/main1.php"
				)
			);?>
		</article>
		<article class="main-2-bordered">
			<?$APPLICATION->IncludeComponent(
				"bitrix:main.include",
				"",
				Array(
					"AREA_FILE_SHOW" => "file",
					"AREA_FILE_SUFFIX" => "inc",
					"EDIT_TEMPLATE" => "",
					"PATH" => "/include_areas/main2.php"
				)
			);?>
			<a href="/about/" class="to-all" title="Подробнее"></a>
		</article>
		<div class="clear"></div>
		<div class="hr"></div>
		
		<?$APPLICATION->IncludeComponent("bitrix:catalog.section", "main_examples", array(
	"AJAX_MODE" => "N",
		"IBLOCK_TYPE" => "system",
		"IBLOCK_ID" => "11",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"SECTION_USER_FIELDS" => "",
		"ELEMENT_SORT_FIELD" => "SORT",
		"ELEMENT_SORT_ORDER" => "ASC",
		"FILTER_NAME" => "arrFilter",
		"INCLUDE_SUBSECTIONS" => "Y",
		"SHOW_ALL_WO_SECTION" => "Y",
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		"BASKET_URL" => "/personal/basket/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"META_KEYWORDS" => "-",
		"META_DESCRIPTION" => "-",
		"BROWSER_TITLE" => "-",
		"ADD_SECTIONS_CHAIN" => "N",
		"DISPLAY_COMPARE" => "N",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "N",
		"PAGE_ELEMENT_COUNT" => "4",
		"LINE_ELEMENT_COUNT" => "3",
		"PROPERTY_CODE" => array(
			0 => "LENGTH",
			1 => "COLOR",
			2 => "WAVE",
			3 => "IMITATION_SKIN",
			4 => "VOLUME",
			5 => "BASIS",
			6 => "MIN_PRICE",
		),
		"OFFERS_LIMIT" => "5",
		"PRICE_CODE" => "",
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRODUCT_PROPERTIES" => "",
		"USE_PRODUCT_QUANTITY" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"PAGER_TEMPLATE" => "",
		"DISPLAY_TOP_PAGER" => "Y",
		"DISPLAY_BOTTOM_PAGER" => "Y",
		"PAGER_TITLE" => "Товары",
		"PAGER_SHOW_ALWAYS" => "Y",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "Y",
		"CONVERT_CURRENCY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
	</div>
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:catalog.section.list",
		"main_recommendations",
		Array(
			"IBLOCK_TYPE" => "system",
			"IBLOCK_ID" => "1",
			"SECTION_ID" => "",
			"SECTION_CODE" => "",
			"COUNT_ELEMENTS" => "N",
			"TOP_DEPTH" => "1",
			"SECTION_FIELDS" => array("ID", "NAME", "DESCRIPTION", ""),
			"SECTION_USER_FIELDS" => array("", ""),
			"VIEW_MODE" => "TEXT",
			"SHOW_PARENT_NAME" => "Y",
			"SECTION_URL" => "",
			"CACHE_TYPE" => "A",
			"CACHE_TIME" => "36000000",
			"CACHE_GROUPS" => "N",
			"ADD_SECTIONS_CHAIN" => "N"
		)
	);?>
	
	<!--div class="extra-small doubt"-->
  <div class="extra-small main3-text">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "file",
				"AREA_FILE_SUFFIX" => "inc",
				"EDIT_TEMPLATE" => "",
				"PATH" => "/include_areas/main3.php"
			)
		);?>
   
		<a href="/create-system/" class="create_hair_system" style="margin: 30px 0px 30px 200px;"></a>
  
    </div>
	</div><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>