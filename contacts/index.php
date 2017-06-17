<?
define('NOT_SHOW_TITLE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты: написать письмо, отправить сообщение с сайта, БЕСПЛАТНЫЙ звонок по номеру | Интернет-магазин \"Система Волос\"");
echo '<div class="contacts">';
?><h3>Мы всегда рады проконсультировать вас по любому вопросу.</h3>
<table class="cdata">
<tbody>
<tr>
	<th>
		Звоните
	</th>
	<td>
		8-800-700-15-82
		<div class="note">
			Бесплатный звонок по России
		</div>
	</td>

</tr>
<tr>
<td></td>
<td>
		+7-969-711-93-97
		<div class="note">
			Санкт-Петербург
		</div>
	</td></tr>
<tr>
	<th>
		Пишите
	</th>
	<td>
		<a href="mailto:shop@sistemavolos.ru">shop@sistemavolos.ru</a>
	</td>
</tr>
</tbody>
</table>
<div class="address">
 <a class="maplink" href="#">смотреть на карте</a>
Наш адрес:<br>
 <b>г. Тула<br>
 ул. Фрунзе, д.29</b><br>
<b>г.Санкт-Петербург<br>
 Лиговский проспект, д.149, ст. метро "Обводный канал"</b><br>
	</div><?
echo '</div>';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>