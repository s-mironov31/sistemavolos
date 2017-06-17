<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="order_list">
<?
//print_r($arResult);

foreach($arResult['ORDERS'] as $k0=>$v0)
{
	echo '<div class="order" id="order'.$v0['ORDER']['ID'].'">
			<a class="line" href="javascript:void(0)" title="Детали заказа" onclick="OList.Open(this)">
				<span class="center">
					<span class="date">
						'.$v0['ORDER']['DATE_INSERT_FORMATED'].'
						<span class="status">'.$arResult['INFO']['STATUS'][$v0['ORDER']['STATUS_ID']]['NAME'].'</span>
					</span>
					<span class="arrow" title="Подробнее"></span>
				</span>
			</a>';
?>
<div class="detail">
	<form method="post" action="" name="basketForm" class="goods">
		<?
		foreach($v0['BASKET_ITEMS'] as $k=>$v)
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
						<p class="p-price">'.number_format($v['PRICE']*$v['QUANTITY'], 0, '', ' ').' р.</p>
						<p>*включая доставку</p>
						<p class="quantity-text beige">Количество</p>
						<section class="quantity">
							<input type="hidden" name="QUANTITY_'.$v['ID'].'" value="'.$v['QUANTITY'].'">
							<a href="javascript:void(0)" onclick="Basket.Minus(this);" class="minus" title="Меньше" style="visibility:hidden;"></a>
							<div class="quantity-nmb beige">'.$v['QUANTITY'].'</div>
							<a href="javascript:void(0)" onclick="Basket.Plus(this);" class="plus" title="Больше" style="visibility:hidden;"></a>
						</section>
					</div>
					<!--<a href="javascript:void(0)" onclick="Basket.Delete('.$v['ID'].');" class="delete-btn" title="Удалить"></a>-->
					<div class="clear"></div>
				</div>';
		}
		?>
		<div class="total-line"></div>
		<div class="total">
			<a href="javascript:void(0)" onclick="OList.Repeat(<?=$v0['ORDER']['ID']?>)" class="repeat">Повторить заказ</a>
			<div class="beige">всего </div>
			<div>
				<p class="p-price"><?=$v0['ORDER']['FORMATED_PRICE']?></p>
				<p>*включая доставку</p>
			</div>
		</div>
		<div class="clear"></div>
	</form>
</div>
<?
	echo '</div>';
}
?>
</div>