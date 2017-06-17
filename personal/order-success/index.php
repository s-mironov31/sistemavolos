<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Заказ успешно оформлен");
?>
<p>Ваш заказ успешно оформлен.</p>
<p>Номер заказа: <?=$_GET['ORDER_ID']?>.</p>
<p>На Ваш E-mail было выслано письмо с деталями заказа.</p>
<p>Следить за статусом заказа Вы можете в личном кабинете.</p>


<?
CModule::IncludeModule('sale');
$arOrder = CSaleOrder::GetByID($_GET['ORDER_ID']);
$dbPaySysAction = CSalePaySystemAction::GetList(
		array(),
		array(
				"PAY_SYSTEM_ID" => $arOrder["PAY_SYSTEM_ID"],
				"PERSON_TYPE_ID" => $arOrder["PERSON_TYPE_ID"]
			),
		false,
		false,
		array("NAME", "ACTION_FILE", "NEW_WINDOW", "PARAMS", "ENCODING", "LOGOTIP")
	);
if ($arPaySysAction = $dbPaySysAction->Fetch())
{
	$arPaySysAction["NAME"] = htmlspecialcharsEx($arPaySysAction["NAME"]);
	if (strlen($arPaySysAction["ACTION_FILE"]) > 0)
	{
		if ($arPaySysAction["NEW_WINDOW"] != "Y")
		{
			CSalePaySystemAction::InitParamArrays($arOrder, $arOrder["ID"], $arPaySysAction["PARAMS"]);

			$pathToAction = $_SERVER["DOCUMENT_ROOT"].$arPaySysAction["ACTION_FILE"];

			$pathToAction = str_replace("\\", "/", $pathToAction);
			while (substr($pathToAction, strlen($pathToAction) - 1, 1) == "/")
				$pathToAction = substr($pathToAction, 0, strlen($pathToAction) - 1);

			if (file_exists($pathToAction))
			{
				if (is_dir($pathToAction) && file_exists($pathToAction."/payment.php"))
					$pathToAction .= "/payment.php";

				$arPaySysAction["PATH_TO_ACTION"] = $pathToAction;
			}

			if(strlen($arPaySysAction["ENCODING"]) > 0)
			{
				define("BX_SALE_ENCODING", $arPaySysAction["ENCODING"]);
				AddEventHandler("main", "OnEndBufferContent", "ChangeEncoding");
				function ChangeEncoding($content)
				{
					global $APPLICATION;
					header("Content-Type: text/html; charset=".BX_SALE_ENCODING);
					$content = $APPLICATION->ConvertCharset($content, SITE_CHARSET, BX_SALE_ENCODING);
					$content = str_replace("charset=".SITE_CHARSET, "charset=".BX_SALE_ENCODING, $content);
				}
			}
		}
	}

	if ($arPaySysAction > 0)
		$arPaySysAction["LOGOTIP"] = CFile::GetFileArray($arPaySysAction["LOGOTIP"]);

	$arResult["PAY_SYSTEM"] = $arPaySysAction;
}

if (!empty($arResult["PAY_SYSTEM"]))
{
	?>
	<div class="pay_block">

	<table class="sale_order_full_table">
		<tr>
			<td class="ps_logo">
				<div class="pay_name"><?=GetMessage("SOA_TEMPL_PAY")?></div>
				<?/*=CFile::ShowImage($arResult["PAY_SYSTEM"]["LOGOTIP"], 100, 100, "border=0", "", false);*/?>
				<div class="paysystem_name"><?= $arResult["PAY_SYSTEM"]["NAME"] ?></div><br>
			</td>
		</tr>
		<?
		if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
		{
			?>
			<tr>
				<td>
					<?
					if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
					{
						?>
						<script language="JavaScript">
							window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?=urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))?>');
						</script>
						<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))))?>
						<?
						if (CSalePdf::isPdfAvailable() && CSalePaySystemsHelper::isPSActionAffordPdf($arResult['PAY_SYSTEM']['ACTION_FILE']))
						{
							?><br />
							<?= GetMessage("SOA_TEMPL_PAY_PDF", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".urlencode(urlencode($arResult["ORDER"]["ACCOUNT_NUMBER"]))."&pdf=1&DOWNLOAD=Y")) ?>
							<?
						}
					}
					else
					{
						if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
						{
							include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
						}
					}
					?>
				</td>
			</tr>
			<?
		}
		?>
	</table>
	</div>
	<?
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>