<?
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
Cmodule::IncludeModule('catalog');
Cmodule::IncludeModule('sale');

if($_GET['action']=='ADD2BASKET')
{
	Add2BasketByProductID($_GET['id'], max(1, intval($_GET['quantity'])));
}
?>
<html>
<body>
<?$APPLICATION->IncludeComponent(
    "bitrix:sale.basket.basket.small",
    "",
    Array(
        "PATH_TO_BASKET" => "/personal/basket/",
        "PATH_TO_ORDER" => "/personal/basket/"
    ),
    false
);?>
</body>
</html>
<script>
window.parent.document.getElementById('basket').innerHTML = document.body.innerHTML;
window.parent.document.getElementById('basket2').innerHTML = document.body.innerHTML;
window.parent.ShowBasketForm();
</script>