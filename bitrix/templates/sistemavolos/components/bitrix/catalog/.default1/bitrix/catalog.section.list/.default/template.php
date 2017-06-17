<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div class="l-list">
	<?
	foreach($arResult['SECTIONS'] as $arSection)
	{
		if($APPLICATION->GetCurDir()==$arSection['SECTION_PAGE_URL'])
		{			
			echo '<p class="bord"><a href="'.$arSection['SECTION_PAGE_URL'].'">'.$arSection['NAME'].'</a></p>';
		}
		else
		{
			echo '<p><a href="'.$arSection['SECTION_PAGE_URL'].'">'.$arSection['NAME'].'</a></p>';
		}
	}
	?>
</div>
