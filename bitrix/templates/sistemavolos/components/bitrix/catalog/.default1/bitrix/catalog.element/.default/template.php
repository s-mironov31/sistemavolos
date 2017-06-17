<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$strMainID = $this->GetEditAreaId($arResult['ID']);
$arItemIDs = array(
	'ID' => $strMainID,
	'PICT' => $strMainID.'_pict',
	'DISCOUNT_PICT_ID' => $strMainID.'_dsc_pict',
	'STICKER_ID' => $strMainID.'_sticker',
	'BIG_SLIDER_ID' => $strMainID.'_big_slider',
	'BIG_IMG_CONT_ID' => $strMainID.'_bigimg_cont',
	'SLIDER_CONT_ID' => $strMainID.'_slider_cont',
	'SLIDER_LIST' => $strMainID.'_slider_list',
	'SLIDER_LEFT' => $strMainID.'_slider_left',
	'SLIDER_RIGHT' => $strMainID.'_slider_right',
	'OLD_PRICE' => $strMainID.'_old_price',
	'PRICE' => $strMainID.'_price',
	'DISCOUNT_PRICE' => $strMainID.'_price_discount',
	'SLIDER_CONT_OF_ID' => $strMainID.'_slider_cont_',
	'SLIDER_LIST_OF_ID' => $strMainID.'_slider_list_',
	'SLIDER_LEFT_OF_ID' => $strMainID.'_slider_left_',
	'SLIDER_RIGHT_OF_ID' => $strMainID.'_slider_right_',
	'QUANTITY' => $strMainID.'_quantity',
	'QUANTITY_DOWN' => $strMainID.'_quant_down',
	'QUANTITY_UP' => $strMainID.'_quant_up',
	'QUANTITY_MEASURE' => $strMainID.'_quant_measure',
	'QUANTITY_LIMIT' => $strMainID.'_quant_limit',
	'BUY_LINK' => $strMainID.'_buy_link',
	'ADD_BASKET_LINK' => $strMainID.'_add_basket_link',
	'COMPARE_LINK' => $strMainID.'_compare_link',
	'PROP' => $strMainID.'_prop_',
	'PROP_DIV' => $strMainID.'_skudiv',
	'DISPLAY_PROP_DIV' => $strMainID.'_sku_prop',
	'OFFER_GROUP' => $strMainID.'_set_group_',
	'BASKET_PROP_DIV' => $strMainID.'_basket_prop',
);
$strObName = 'ob'.preg_replace("/[^a-zA-Z0-9_]/", "x", $strMainID);
$templateData['JS_OBJ'] = $strObName;
?>
<?//dump($arItemIDs);?>
	<div class="small clips-det">
		<a href="./../" class="to-list">назад к списку товаров</a>
		<p class="pink font-16"><?=$arResult['SECTION']['NAME']?></p>
		
		<?
		reset($arResult['MORE_PHOTO']);
		$arFirstPhoto = current($arResult['MORE_PHOTO']);
		
		if (5 < $arResult['MORE_PHOTO_COUNT'])
		{
			$strClass = 'bx_item_detail_scu full';
			$strOneWidth = (100/$arResult['MORE_PHOTO_COUNT']).'%';
			$strWidth = (20*$arResult['MORE_PHOTO_COUNT']).'%';
			$strSlideStyle = '';
		}
		else
		{
			$strClass = 'bx_item_detail_scu';
			$strOneWidth = '20%';
			$strWidth = '100%';
			$strSlideStyle = 'display: none;';
		}
		?>
		
		<div class="bx_item_detail" id="<? echo $arItemIDs['ID']; ?>">
		<div class="bx_item_container">
		<div class="bx_lt">
			<div class="bx_item_slider" id="<? echo $arItemIDs['BIG_SLIDER_ID']; ?>">
		
				<div class="bx_bigimages" id="<? echo $arItemIDs['BIG_IMG_CONT_ID']; ?>">
					<div class="bx_bigimages_imgcontainer">
						<span class="bx_bigimages_aligner"><img
							id="<? echo $arItemIDs['PICT']; ?>"
							src="<? echo $arFirstPhoto['SRC']; ?>"
							alt="<? echo $strAlt; ?>"
							title="<? echo $strTitle; ?>"
						></span>
					</div>
				</div>
		
		
				<div class="<? echo $strClass; ?>" id="<? echo $arItemIDs['SLIDER_CONT_ID']; ?>">
					<div class="bx_slider_scroller_container">
						<div class="bx_slide">
							<ul style="width: <? echo $strWidth; ?>;" id="<? echo $arItemIDs['SLIDER_LIST']; ?>">
			<?
					foreach ($arResult['MORE_PHOTO'] as &$arOnePhoto)
					{
			?>
								<li data-value="<? echo $arOnePhoto['ID']; ?>" style="width: <? echo $strOneWidth; ?>; padding-top: <? echo $strOneWidth; ?>;"><span class="cnt"><span class="cnt_item" style="background-image:url('<? echo $arOnePhoto['SRC']; ?>');"></span></span></li>
			<?
					}
					unset($arOnePhoto);
			?>
							</ul>
						</div>
						<div class="bx_slide_left" id="<? echo $arItemIDs['SLIDER_LEFT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
						<div class="bx_slide_right" id="<? echo $arItemIDs['SLIDER_RIGHT']; ?>" style="<? echo $strSlideStyle; ?>"></div>
					</div>
				</div>
			</div><?// bx_item_slider?>
			</div><?// bx_lt?>

			</div><?// bx_item_container?>
		</div><?// bx_item_detail?>
		
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
	
	<?
	$arJSParams = array(
		'CONFIG' => array(
			'USE_CATALOG' => $arResult['CATALOG'],
			'SHOW_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
			'SHOW_PRICE' => (isset($arResult['MIN_PRICE']) && !empty($arResult['MIN_PRICE']) && is_array($arResult['MIN_PRICE'])),
			'SHOW_DISCOUNT_PERCENT' => ('Y' == $arParams['SHOW_DISCOUNT_PERCENT']),
			'SHOW_OLD_PRICE' => ('Y' == $arParams['SHOW_OLD_PRICE']),
			'DISPLAY_COMPARE' => ('Y' == $arParams['DISPLAY_COMPARE']),
			'MAIN_PICTURE_MODE' => $arParams['DETAIL_PICTURE_MODE']
		),
		'VISUAL' => array(
			'ID' => $arItemIDs['ID'],
		),
		'PRODUCT_TYPE' => $arResult['CATALOG_TYPE'],
		'PRODUCT' => array(
			'ID' => $arResult['ID'],
			'PICT' => $arFirstPhoto,
			'NAME' => $arResult['~NAME'],
			'SUBSCRIPTION' => true,
			'PRICE' => $arResult['MIN_PRICE'],
			'SLIDER_COUNT' => $arResult['MORE_PHOTO_COUNT'],
			'SLIDER' => $arResult['MORE_PHOTO'],
			'CAN_BUY' => $arResult['CAN_BUY'],
			'CHECK_QUANTITY' => $arResult['CHECK_QUANTITY'],
			'QUANTITY_FLOAT' => is_double($arResult['CATALOG_MEASURE_RATIO']),
			'MAX_QUANTITY' => $arResult['CATALOG_QUANTITY'],
			'STEP_QUANTITY' => $arResult['CATALOG_MEASURE_RATIO'],
			'BUY_URL' => $arResult['~BUY_URL'],
		),
		'BASKET' => array(
			'ADD_PROPS' => ('Y' == $arParams['ADD_PROPERTIES_TO_BASKET']),
			'QUANTITY' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
			'PROPS' => $arParams['PRODUCT_PROPS_VARIABLE'],
			'EMPTY_PROPS' => $emptyProductProperties,
			'BASKET_URL' => $arParams['BASKET_URL']
		)
	);
	?>
	
<script type="text/javascript">
var <? echo $strObName; ?> = new JCCatalogElement(<? echo CUtil::PhpToJSObject($arJSParams, false, true); ?>);
</script>