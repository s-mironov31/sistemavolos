<?
define('NOT_SHOW_TITLE', 'Y');
$showBasket = function(){
	$GLOBALS['APPLICATION']->IncludeComponent("bitrix:sale.basket.basket", ".default", array(
		"COLUMNS_LIST" => array(
			0 => "NAME",
			1 => "PRICE",
			2 => "QUANTITY",
			3 => "DELETE",
			4 => "DELAY",
			5 => "DISCOUNT",
		),
		"PATH_TO_ORDER" => "/cart/order.php",
		"HIDE_COUPON" => "N",
		"QUANTITY_FLOAT" => "N",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"COUNT_DISCOUNT_4_ALL_QUANTITY" => "Y",
		"USE_PREPAYMENT" => "N",
		"SET_TITLE" => "N"
		),
		false
	);
};
$showMenu = function(){
	$GLOBALS['APPLICATION']->IncludeComponent(
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
	);
};
if($_POST['AJAX']=='Y')
{
	require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
	CModule::IncludeModule('catalog');
	CModule::IncludeModule('sale');
	CBitrixComponent::includeComponentClass("bitrix:sale.basket.basket");
	$basket = new CBitrixBasketComponent();
	$basket->columns = array('QUANTITY', 'DELETE');
	$res = $basket->recalculateBasket($_POST);
	$showBasket();
	die();
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Ваша корзина");
echo '<div class="small config">
		'.$showMenu().'
		<!--/config header-->
		<p class="title">Вы покупаете это...</p>
			<div id="pcart">';
$showBasket();
echo '</div>
		<div class="hr lst"></div>
		<!--config footer-->
		<section class="cont-controls">		
			<a href="/personal/delivery/" class="create_hair_system2 pink-button radiused">Cледующий шаг</a> 
			<span class="beige"> или</span>
			<a class="pink" href="/e-store/">вернуться к формированию заказа</a>
			<br><div class="next-step-descr">Перейти к доставке</div>
		</section>
	</div>';
?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>