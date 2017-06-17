<?
if(!$_POST['ID']) die();
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Cmodule::IncludeModule('catalog');
Cmodule::IncludeModule('sale');

$dbBasketItems = CSaleBasket::GetList(
        array(
                "ID" => "ASC"
            ),
        array(
                "ORDER_ID" => $_POST['ID']
            ),
        false,
        false,
        array("PRODUCT_ID", "QUANTITY")
    );
while($arItem = $dbBasketItems->Fetch())
{
	Add2BasketByProductID($arItem['PRODUCT_ID'], $arItem['QUANTITY']);
}
?>