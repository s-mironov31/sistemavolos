<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//print_r($arResult);
?>

<form method="post" action="" name="basketForm" class="goods">
	<?
	foreach($arResult['GRID']['ROWS'] as $k=>$v)
	{
		$props = '';
		if(is_array($arResult['PRODUCT_PROPS'][$v['PRODUCT_ID']]))
		{
			foreach($arResult['PRODUCT_PROPS'][$v['PRODUCT_ID']] as $k2=>$v2)
			{
				$props .= $v2['TITLE'].': '.$v2['VALUE'].'<br>';
			}
		}
	
		echo '<div class="good">
				<div class="image">'.(is_array($arResult['PICTURES'][$v['PRODUCT_ID']]) ? '<img src="'.$arResult['PICTURES'][$v['PRODUCT_ID']]['SRC'].'" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'">' : '').'</div>
				<div class="params">
					<p class="ttll">'.$v['NAME'].'</p>
					'.($props ? '<p>Параметры системы:</p><br>'.$props : '').'
				</div>
				<div class="price">
					<p class="p-price">'.$v['SUM'].'</p>
					<!--<p>*включая доставку</p>-->
					<p class="quantity-text beige">Количество</p>
					<section class="quantity">
						<input type="hidden" name="QUANTITY_'.$v['ID'].'" value="'.$v['QUANTITY'].'">
						<a href="javascript:void(0)" onclick="Basket.Minus(this);" class="minus" title="Меньше"></a>
						<div class="quantity-nmb beige">'.$v['QUANTITY'].'</div>
						<a href="javascript:void(0)" onclick="Basket.Plus(this);" class="plus" title="Больше"></a>
					</section>
				</div>
				<a href="javascript:void(0)" onclick="Basket.Delete('.$v['ID'].');" class="delete-btn" title="Удалить"></a>
				<div class="clear"></div>
			</div>';
	}
	?>
	<div class="total-line"></div>
	<div class="total">
		<div class="beige">всего </div>
		<div>
			<p class="p-price"><?=$arResult['allSum_FORMATED']?></p>
			<!--<p>*включая доставку</p>-->
		</div>
	</div>
	<div class="clear"></div>
</form>
		


<?
return;

$arUrls = Array(
	"delete" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delete&id=#ID#",
	"delay" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=delay&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?".$arParams["ACTION_VARIABLE"]."=add&id=#ID#",
);

$arBasketJSParams = array(
	'SALE_DELETE' => GetMessage("SALE_DELETE"),
	'SALE_DELAY' => GetMessage("SALE_DELAY"),
	'SALE_TYPE' => GetMessage("SALE_TYPE"),
	'TEMPLATE_FOLDER' => $templateFolder,
	'DELETE_URL' => $arUrls["delete"],
	'DELAY_URL' => $arUrls["delay"],
	'ADD_URL' => $arUrls["add"]
);
?>
<script type="text/javascript">
	var basketJSParams = <?=CUtil::PhpToJSObject($arBasketJSParams);?>
</script>
<?
$APPLICATION->AddHeadScript($templateFolder."/script.js");

include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/functions.php");

if (strlen($arResult["ERROR_MESSAGE"]) <= 0)
{
	?>
	<div id="warning_message">
		<?
		if (is_array($arResult["WARNING_MESSAGE"]) && !empty($arResult["WARNING_MESSAGE"]))
		{
			foreach ($arResult["WARNING_MESSAGE"] as $v)
				echo ShowError($v);
		}
		?>
	</div>
	<?

	$normalCount = count($arResult["ITEMS"]["AnDelCanBuy"]);
	$normalHidden = ($normalCount == 0) ? "style=\"display:none\"" : "";

	$delayCount = count($arResult["ITEMS"]["DelDelCanBuy"]);
	$delayHidden = ($delayCount == 0) ? "style=\"display:none\"" : "";

	$subscribeCount = count($arResult["ITEMS"]["ProdSubscribe"]);
	$subscribeHidden = ($subscribeCount == 0) ? "style=\"display:none\"" : "";

	$naCount = count($arResult["ITEMS"]["nAnCanBuy"]);
	$naHidden = ($naCount == 0) ? "style=\"display:none\"" : "";

	?>
		<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form" id="basket_form">
			<div id="basket_form_container">
				<div class="bx_ordercart">
					<div class="bx_sort_container">
						<span><?=GetMessage("SALE_ITEMS")?></span>
						<a href="javascript:void(0)" id="basket_toolbar_button" class="current" onclick="showBasketItemsList()"><?=GetMessage("SALE_BASKET_ITEMS")?><div id="normal_count" class="flat" style="display:none">&nbsp;(<?=$normalCount?>)</div></a>
						<a href="javascript:void(0)" id="basket_toolbar_button_delayed" onclick="showBasketItemsList(2)" <?=$delayHidden?>><?=GetMessage("SALE_BASKET_ITEMS_DELAYED")?><div id="delay_count" class="flat">&nbsp;(<?=$delayCount?>)</div></a>
						<a href="javascript:void(0)" id="basket_toolbar_button_subscribed" onclick="showBasketItemsList(3)" <?=$subscribeHidden?>><?=GetMessage("SALE_BASKET_ITEMS_SUBSCRIBED")?><div id="subscribe_count" class="flat">&nbsp;(<?=$subscribeCount?>)</div></a>
						<a href="javascript:void(0)" id="basket_toolbar_button_not_available" onclick="showBasketItemsList(4)" <?=$naHidden?>><?=GetMessage("SALE_BASKET_ITEMS_NOT_AVAILABLE")?><div id="not_available_count" class="flat">&nbsp;(<?=$naCount?>)</div></a>
					</div>
					<?
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_delayed.php");
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_subscribed.php");
					include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items_not_available.php");
					?>
				</div>
			</div>
			<input type="hidden" name="BasketOrder" value="BasketOrder" />
			<!-- <input type="hidden" name="ajax_post" id="ajax_post" value="Y"> -->
		</form>
	<?
}
else
{
	ShowError($arResult["ERROR_MESSAGE"]);
}
?>