<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<div class="multi-progress">
<?
$arUrl = parse_url($_SERVER['REQUEST_URI']);
$path = $arUrl['path'];
$count = count($arResult);
foreach($arResult as $k=>$arItem){
	if(strpos($path, $arItem["LINK"])===0)
	{
		if($path==$arItem["LINK"])
		{
			echo '<div class="m-p-element current">'.$arItem["TEXT"].'</div>';
		}
		else
		{
			echo '<a href="'.$arItem["LINK"].'" class="m-p-element current">'.$arItem["TEXT"].'</a>';
		}
	}
	else
	{
		if($k==$count-1)
		{
			echo '<div class="m-p-element">'.$arItem["TEXT"].'</div>';
		}
		else
		{
			echo '<a href="'.$arItem["LINK"].'" class="m-p-element">'.$arItem["TEXT"].'</a>';
		}
	}
}
?>
</div>

<?endif?>