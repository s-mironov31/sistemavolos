<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404. Страница не найдена");
$APPLICATION->AddChainItem("Ошибка 404. Страница не найдена");
?>
	Запрошенная страница не существует:
	<ul>
		<li>проверьте правильность написания адреса страницы;</li>
		<li>попробуйте изменить путь страницы или воспользоваться <a href="/sitemap/">картой сайта</a>.</li>
	</ul>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>