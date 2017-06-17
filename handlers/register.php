<?php
if($_POST['send']!=1) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$user = new CUser;
$arFields = Array(
  "EMAIL"             => $_POST['USER']['LOGIN'],
  "LOGIN"             => $_POST['USER']['LOGIN'],
  "ACTIVE"            => "Y",
  "PASSWORD"          => $_POST['USER']['PASSWORD'],
  "CONFIRM_PASSWORD"  => $_POST['USER']['PASSWORD']
);

$ID = $user->Add($arFields);
if (intval($ID) > 0)
{
	CEvent::Send("REGISTER_COMPLETE", SITE_ID, $arFields);
	$GLOBALS['USER']->Authorize($ID);
    echo '<html><body>
			<script>window.parent.location.href = window.parent.location.href;</script>
		  </body></html>';
}
else
{
    echo '<html><body>'.$user->LAST_ERROR.'</body></html>
		  <script>window.parent.document.getElementById("reg_error").innerHTML = document.body.innerHTML;</script>';
}
?>