<div class="pinfo">
	<a class="btn" href="/personal/orders/">Просмотреть историю заказов</a>
	<div class="id"><?=$GLOBALS['USER']->GetID()?></div>
</div>
<div class="addrs">
	<div class="title">Ваши адреса доставки:</div>
	<div id="address_list">
		<?include(__DIR__.'/address_list.php');?>
	</div>
	<a href="javascript:void(0)" onclick="Address.ShowForm()" class="add">добавить адрес доставки</a>
</div>