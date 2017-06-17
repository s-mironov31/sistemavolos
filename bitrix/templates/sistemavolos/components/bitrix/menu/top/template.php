<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if (!empty($arResult)):?>
<table class="top-menu"><tr>
<?
$arUrl = parse_url($_SERVER['REQUEST_URI']);
$path = $arUrl['path'];
$count = count($arResult);
foreach($arResult as $k=>$arItem){
	/*$class = '';
	if($k==0) $class = 'first';
	if($k==$count-1) $class = 'last';
	*/
	if(strpos($path, $arItem["LINK"])===0)
	{
		if($path==$arItem["LINK"])
		{
			echo '<td><span class="a">'.$arItem["TEXT"].'</span></td>';
		}
		else
		{
			echo '<td><a href="'.$arItem["LINK"].'" class="active">'.$arItem["TEXT"].'</a></td>';
		}
	}
	else
	{
		echo '<td><a href="'.$arItem["LINK"].'">'.$arItem["TEXT"].'</a></td>';
	}
}
?>
</tr></table>
<div class="clear"></div>

<?endif?>