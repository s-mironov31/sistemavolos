<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="l-list">
	<?
	foreach ($arResult['SECTIONS'] as $arSection)
	{
		echo '<p>'.$arSection['NAME'].'</p>';
	}
	?>
</div>
