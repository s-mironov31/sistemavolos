<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?//print_r($arResult);?>
<? echo $arResult["NAV_STRING"]; ?>
<section class="goods">
<table>
	<tr>
<?
for($i=0; $i<ceil(count($arResult['ITEMS'])/3); $i++)
{
	if($i>0)
	{
		echo '</tr><tr>';
	}
	$arItems = array_slice($arResult['ITEMS'], ($i*3), 3);
	foreach($arItems as $k=>$v)
	{
		echo '<td><article class="a">
					<a href="'.$v['DETAIL_PAGE_URL'].'" class="image" style="background-image:url('.$v['PREVIEW_PICTURE']['SRC'].')" title="'.htmlspecialchars($v['PREVIEW_PICTURE']['TITLE']).'"></a>
					<p class="descrrr"><a href="'.$v['DETAIL_PAGE_URL'].'">'.$v['NAME'].'</a></p>
				</article></td>';
	}
	echo '</tr><tr>';
	foreach($arItems as $k=>$v)
	{
		echo '<td><article class="b">
					<p class="good-price">'.number_format($v['PRICES']['BASE']['DISCOUNT_VALUE'], 0, '', ' ').' р.</p>
					<p class="good-name pink">'.$arResult['SECTIONS'][$v['IBLOCK_SECTION_ID']]['NAME'].'</p>
					<a class="radiused to-basket" href="/handlers/add2basket.php?action=ADD2BASKET&id='.$v['ID'].'" target="hidden_frame">В корзину</a>
				</article></td>';
	}
}
?>
	</tr>
</table>
</section>
<? echo $arResult["NAV_STRING"]; ?>