<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if((int)$APPLICATION->GetPageProperty('BASKET_QUANTITY') < 1)
{
	LocalRedirect('/');
}
?>