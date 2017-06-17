<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if($arResult['process'] == 'sent'){?>
        <html><body>
			<div id="wrap">
				<div class="log_in-fix thanksed" id="callbackThanks">
					<div class="log_in">
						<p class="pink thanks">Спасибо.</p>
						<p class="for-choose">Мы свяжемся с Вами <br>в ближайшее время!</p>
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
	<div class="wletter">
      <form method="post" action="/handlers/contact_form.php" target="hidden_frame" name="contactsForm" enctype="multipart/form-data" validate="1">
			<h3>Написать письмо</h3>
			<input type="hidden" name="send" value="0">

			<table>
				<col width="356px">
				<col>
				<tr>
					<td>
						<input name="public_fio_label" type="hidden" value="Как к Вам обращаться?" />
						<input type="text" class="text empty" name="public_fio" value="Как к Вам обращаться?" initValue="Как к Вам обращаться?" validate="not_empty">
						
						<input name="public_email_label" type="hidden" value="Ваш e-mail" />
						<input type="text" class="text empty" name="public_email" value="Ваш e-mail" initValue="Ваш e-mail" validate="not_empty email">
					</td>
					<td>
						<input name="public_message_label" type="hidden" value="Ваше сообщение" />
						<textarea class="empty" name="public_message" initValue="Ваше сообщение" validate="not_empty">Ваше сообщение</textarea>
					</td>
				</tr>
			</table>
			
			<input class="submit" type="image" src="/images/send_btn.png" name="send_btn" value="Отправить" title="Отправить">
      </form>
	</div>
<?}?>