<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$APPLICATION->IncludeComponent(
	"myrmex:forms",
	"contacts",
	Array(
		"EMAIL_FROM" => "no-reply@sistemavolos.ru",
		"EMAIL_TO" => "krivochurov@myrmex.ru",
		"SUBJECT" => "sistemavolos.ru: Письмо со страницы Контакты",
		"EVENT_TYPE" => "FEEDBACK",
		"IBLOCK_TYPE" => "system_forms",
		"IBLOCK_ID" => "13",
		"SEND_NAME" => "send",
		"VALID_FIO" => "not_empty",
		"VALID_EMAIL" => "not_empty",
		"VALID_MESSAGE" => "not_empty",
	)
);
?>