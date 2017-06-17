<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
	"myrmex:forms",
	"callback",
	Array(
		"EMAIL_FROM" => "no-reply@sistemavolos.ru",
		"EMAIL_TO" => "krivochurov@myrmex.ru",
		"SUBJECT" => "sistemavolos.ru: Заказ обратного звонка",
		"EVENT_TYPE" => "FEEDBACK",
		"IBLOCK_TYPE" => "system_forms",
		"IBLOCK_ID" => "12",
		"SEND_NAME" => "send",
		"VALID_FIO" => "not_empty",
		"VALID_PHONE" => "not_empty",
	)
);
?>