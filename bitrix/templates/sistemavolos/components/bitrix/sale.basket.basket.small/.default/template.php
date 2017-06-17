<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$sum = 0;
$cnt = 0;
if(is_array($arResult['ITEMS']))
{
    foreach($arResult['ITEMS'] as $k=>$v)
    {
        $sum += $v['PRICE']*$v['QUANTITY'];
		$cnt += $v['QUANTITY'];
    }
}

$APPLICATION->SetPageProperty('BASKET_QUANTITY', $cnt);

if($sum > 0)
{
    echo '<a href="'.$arParams['PATH_TO_BASKET'].'">('.$cnt.')</a>';
}
else
{
    echo '(0)';
}
?>
