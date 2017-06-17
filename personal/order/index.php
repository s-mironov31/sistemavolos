<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Корзина");
?><?$APPLICATION->IncludeComponent("bitrix:sale.order.full", ".default", array(
	"ALLOW_PAY_FROM_ACCOUNT" => "Y",
	"SHOW_MENU" => "N",
	"CITY_OUT_LOCATION" => "Y",
	"COUNT_DELIVERY_TAX" => "N",
	"COUNT_DISCOUNT_4_ALL_QUANTITY" => "N",
	"ONLY_FULL_PAY_FROM_ACCOUNT" => "N",
	"SEND_NEW_USER_NOTIFY" => "N",
	"DELIVERY_NO_SESSION" => "Y",
	"PROP_1" => array(
	),
	"PATH_TO_BASKET" => "index.php",
	"PATH_TO_PERSONAL" => "/personal/index.php",
	"PATH_TO_AUTH" => "/auth.php",
	"PATH_TO_PAYMENT" => "payment.php",
	"USE_AJAX_LOCATIONS" => "N",
	"SHOW_AJAX_DELIVERY_LINK" => "Y",
	"SET_TITLE" => "Y",
	"PRICE_VAT_INCLUDE" => "N",
	"PRICE_VAT_SHOW_VALUE" => "N"
	),
	false
);?> <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>