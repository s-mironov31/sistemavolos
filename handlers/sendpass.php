<?php
if($_POST['send']!=1) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = $USER->SendPassword('', $_POST['USER']['LOGIN']);
if($arResult["TYPE"] == "OK")
{
    echo '<html><body>
			<div id="message">
				<div class="success">
					На Ваш E-mail выслано письмо с дальнейшими инструкциями по смене пароля
				</div>
			</div>
		  </body></html>
		  <script>window.parent.document.getElementById("sendpass_error").innerHTML = document.getElementById("message").innerHTML;</script>';
}
else
{
    echo '<html><body>
			<div id="message">
				Введенный E-mail не найден
			</div>
		</body></html>
		<script>window.parent.document.getElementById("sendpass_error").innerHTML = document.getElementById("message").innerHTML;</script>';
}
?>