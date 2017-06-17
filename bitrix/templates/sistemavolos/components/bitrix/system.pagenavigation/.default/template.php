<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//print_r($arResult);

//нужно переопределить первую и последнюю страницу, т.к. выводим только 5
$cnt = 5;
$pcnt = floor($cnt/2);
$arResult['nStartPage'] = max(1, $arResult['NavPageNomer'] - $pcnt - max(0, ($pcnt - ($arResult['NavPageCount'] - $arResult['NavPageNomer']))));
$arResult['nEndPage'] = min($arResult['NavPageCount'], $arResult['NavPageNomer'] + $pcnt + max(0, (2 - ($arResult['NavPageNomer']-1))));

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$path = $arResult["sUrlPath"].'?'.($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "").'PAGEN_'.$arResult["NavNum"];


if($arResult['NavPageCount'] > 1)
{
	echo '<div class="pages">';
	if($arResult['NavPageNomer'] > 1)
        {
            echo '<a href="'.$path.'='.($arResult["NavPageNomer"]-1).'" class="prev" title="Назад"></a>';
        }
        if($arResult['nStartPage'] > 1)
	{
		//echo '<a href="'.$path.'=1">1</a>&nbsp;';
	}
	if($arResult['nStartPage'] > 2)
	{
		//echo '<span class="points">...</span>&nbsp;';
	}
	
	//echo '<span class="pages">';
	
	for($i=$arResult['nStartPage']; $i<$arResult['nEndPage']+1; $i++)
	{
		if($arResult['NavPageNomer']==$i)
		{
			echo '<span class="page current">'.$i.'</span>&nbsp;';
		}
		else
		{
			echo '<a href="'.$path.'='.$i.'" class="page">'.$i.'</a>&nbsp;';
		}
	}
	
	//echo '</span>';
	
	if($arResult['nEndPage'] < $arResult['NavPageCount']-1)
	{
		//echo '<span class="points">...</span>&nbsp;';
	}
	if($arResult['NavPageCount'] > $arResult['nEndPage'])
	{
		//echo '<a href="'.$path.'='.$arResult['NavPageCount'].'">'.$arResult["NavPageCount"].'</a>';
	}
	if($arResult['NavPageCount'] > $arResult['NavPageNomer'])
	{
		echo '<a href="'.$path.'='.($arResult["NavPageNomer"]+1).'" class="next" title="Вперед"></a>';
	}
	echo '</div>';
}
?>
<div class="clear"></div>