<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
	<div class="small clips-det">
		<a href="./../" class="to-list">назад к списку товаров</a>
		<p class="pink font-16"><?=$arResult['SECTION']['NAME']?></p>
		<div class="l" style="background-image:url(<?=$arResult['PREVIEW_PICTURE']['SRC']?>)" title="<?=htmlspecialchars($arResult['PREVIEW_PICTURE']['TITLE'])?>"></div>
		<div class="r">
			<p class="title-24"><?=$arResult['NAME']?></p>
			<p class="text"><?=$arResult['DETAIL_TEXT']?></p>
			<p class="det-price"><?=number_format($arResult['PRICES']['BASE']['DISCOUNT_VALUE'], 0, '', ' ')?> р.</p>
			<p class="quantity-text beige">Количество:</p>
			<section class="quantity">
				<a href="javascript:void(0)" onclick="Basket.Minus(this);" rel="UpdateLink" class="minus" title="Меньше"></a>
				<div class="quantity-nmb beige">1</div>
				<a href="javascript:void(0)" onclick="Basket.Plus(this);" rel="UpdateLink" class="plus" title="Больше"></a>
			</section>
			<div class="clear"></div>
			<a class="radiused more-and-order" href="/handlers/add2basket.php?action=ADD2BASKET&id=<?=$arResult['ID']?>" target="hidden_frame">В корзину</a>
		</div>
		<div class="clear"></div>
	</div>