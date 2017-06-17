<?php
if($_POST['send']!=1) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = $GLOBALS['USER']->ChangePassword($_POST['USER_LOGIN'], $_POST['USER_CHECKWORD'], $_POST['USER']['PASSWORD'], $_POST['USER']['CONFIRM_PASSWORD']);
if($arResult["TYPE"] == "OK")
{
    echo '<html><body>
			<div id="message">
				<div class="success">
					Пароль успешно изменен
				</div>
			</div>
		  </body></html>
		  <script>window.parent.document.getElementById("changepass_error").innerHTML = document.getElementById("message").innerHTML;</script>';
}
else
{
    echo '<html><body>
			<div id="message">
				'.$arResult['MESSAGE'].'
			</div>
		</body></html>
		<script>window.parent.document.getElementById("changepass_error").innerHTML = document.getElementById("message").innerHTML;</script>';
}
?>