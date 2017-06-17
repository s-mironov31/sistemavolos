<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");
if(!$GLOBALS['USER']->GetId())
{
	LocalRedirect('/');
}

include(__DIR__.'/address/address.php');
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>