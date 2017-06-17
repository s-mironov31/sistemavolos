<?
if($_POST['AJAX']=='Y')
{
	include($_SERVER["DOCUMENT_ROOT"]."/handlers/get_examples.php");
	die();
}
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Системы волос в наличии | Интернет-магазин \"Система Волос\"");
$APPLICATION->SetPageProperty("description", "Варианты исполнения и цены \"от\" для представленных вариантов систем замещения волос интернет-магазина \"Системы Волос\".");
$APPLICATION->SetTitle("Системы волос в наличии");
?>

	<div class="example">
		<div class="title-24 examlpe">Каталог примеров систем волос с учетом некоторых параметров, на основе которых вы можете 
			<a href="/create-system/" class="create_hair_system2 blue-button radiused">создать свою систему волос</a>
		</div>
		<div class="clear"></div>
		<div class="hr"></div>
		<!--<div class="sli" style="float:left;"></div>-->
		
		<?include($_SERVER["DOCUMENT_ROOT"]."/handlers/get_examples.php");?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>