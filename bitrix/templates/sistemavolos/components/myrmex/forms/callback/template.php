<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult['process'] == 'sent'){?>
        <html><body>
			<div id="wrap">
				<div class="log_in-fix thanksed" id="callbackThanks">
					<div class="log_in">
						<p class="pink thanks">Спасибо.</p>
						<p class="for-choose">Мы перезвоним Вам в ближайшее время!</p>
						<div class="clear"></div>
						<div class="delete-btn" onclick="Callback.Hide()"></div>
					</div>
				</div>
			</div>
		</body></html>
		<script>
			window.parent.Callback.Show('callbackThanks', document.getElementById('wrap').innerHTML);
		</script>
<?}else{?> 
      <form method="post" class="ring-order" action="/handlers/callback.php" target="hidden_frame" name="callbackForm" enctype="multipart/form-data" validate="1">
          <input type="hidden" name="send" value="0">

			<input name="public_fio_label" type="hidden" value="Как к Вам обращаться?" />
			<input type="text" class="pinked" name="public_fio" value="Как к Вам обращаться?" initValue="Как к Вам обращаться?" validate="not_empty">
			
			<input name="public_phone_label" type="hidden" value="По какому номеру перезвонить?" />
			<input type="text" class="pinked" name="public_phone" value="По какому номеру перезвонить?" initValue="По какому номеру перезвонить?" validate="not_empty">
			<button class="rounded">заказать звонок</button>
      </form>
<?}?>