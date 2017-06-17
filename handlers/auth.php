<?php
if($_POST['send']!=1) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$arResult = $USER->Login($_POST['USER']['LOGIN'], $_POST['USER']['PASSWORD'], "N", "Y");

if($arResult['TYPE']!='ERROR')
{
	$GLOBALS['USER']->Authorize($ID);
    echo '<html><body>
			<script>window.parent.location.href = window.parent.location.href;</script>
		  </body></html>';
}
else
{
    echo '<html><body>'.$arResult['MESSAGE'].'</body></html>
		  <script>window.parent.document.getElementById("auth_error").innerHTML = document.body.innerHTML;</script>';
}
?>