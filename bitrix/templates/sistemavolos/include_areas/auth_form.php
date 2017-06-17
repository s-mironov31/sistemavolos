<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!$GLOBALS['USER']->IsAuthorized())
{
?>
	<div class="log_in-shadow"></div>
	<div class="log_in-fix log-in">
		<div class="log_in">
			<p class="tttl">Личный кабинет</p>
			<form method="post" target="hidden_frame" action="/handlers/auth.php" validate="true">
				<input type="hidden" name="send" value="0">
				<div class="field">
					<div class="placeholder">e-mail</div>
					<input type="text" name="USER[LOGIN]" value="" validate="not_empty" title="e-mail">
				</div>
				<div class="field">
					<div class="placeholder">пароль</div>
					<input type="password" name="USER[PASSWORD]" value="" validate="not_empty" title="пароль">
				</div>
				<input type="submit" class="rounded" value="войти">
				<div class="error" id="auth_error"></div>
			</form>
			<a href="javascript:void(0)" class="open-sendpass">Забыли пароль?</a>
			<a href="javascript:void(0)" class="open-reg">Я еще не зарегистрировался</a>
			<div class="clear"></div>
			<div class="delete-btn" title="Закрыть"></div>
		</div>
	</div>
	
	<div class="log_in-fix reg-form">
		<div class="log_in">
			<p class="tttl">Регистрация</p>
			<form method="post" target="hidden_frame" action="/handlers/register.php" validate="true">
				<input type="hidden" name="send" value="0">
				<div class="field">
					<div class="placeholder">e-mail</div>
					<input type="text" name="USER[LOGIN]" value="" validate="not_empty email" title="e-mail">
				</div>
				<div class="field">
					<div class="placeholder">создайте пароль</div>
					<input type="password" name="USER[PASSWORD]" value="" validate="not_empty password" title="создайте пароль">
				</div>
				<input type="submit" class="rounded" value="зарегистрироваться">
				<div class="error" id="reg_error"></div>
			</form>
			<div class="clear"></div>
			<div class="delete-btn" title="Закрыть"></div>
		</div>
	</div>
	
	<div class="log_in-fix send-pass">
		<div class="log_in">
			<p class="tttl">Восставноление пароля</p>
			<form method="post" target="hidden_frame" action="/handlers/sendpass.php" validate="true">
				<input type="hidden" name="send" value="0">
				<div class="field">
					<div class="placeholder">e-mail</div>
					<input type="text" name="USER[LOGIN]" value="" validate="not_empty email" title="e-mail">
				</div>
				<input type="submit" class="rounded" value="отправить">
				<div class="error" id="sendpass_error"></div>
			</form>
			<div class="clear"></div>
			<div class="delete-btn" title="Закрыть"></div>
		</div>
	</div>
<?
}
?>

<div class="log_in-fix change-pass">
	<div class="log_in">
		<p class="tttl">Новый пароль</p>
		<form method="post" target="hidden_frame" action="/handlers/changepass.php" validate="true">
			<input type="hidden" name="send" value="0">
			<?
			if(is_array($_GET))
			{
				foreach($_GET as $k=>$v)
				{
					if(!is_array($v))
					{
						echo '<input type="hidden" name="'.$k.'" value="'.htmlspecialchars($v).'">';
					}
				}
			}
			?>
			<div class="field">
				<div class="placeholder">создайте пароль</div>
				<input type="text" name="USER[PASSWORD]" value="" validate="not_empty" title="Создайте пароль">
			</div>
			<div class="field">
				<div class="placeholder">повторите пароль</div>
				<input type="text" name="USER[CONFIRM_PASSWORD]" value="" validate="not_empty" title="Повторите пароль">
			</div>
			<input type="submit" class="rounded" value="сохранить">
			<div class="error" id="changepass_error"></div>
		</form>
		<div class="clear"></div>
		<div class="delete-btn" title="Закрыть"></div>
	</div>
</div>

<div class="log_in-fix add2basket">
	<div class="log_in">
		<p class="tttl">Товар успешно добавлен в корзину</p>
		<div class="add2basket_inner">
			<div class="delete-btn">продолжить покупки</div>
			<a href="/personal/basket/" class="tobasket">в корзину</a>
		</div>
		<div class="clear"></div>
		<div class="delete-btn" title="Закрыть"></div>
	</div>
</div>