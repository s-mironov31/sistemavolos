<?
define('NOT_SHOW_TITLE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Используемые понятия и их описание для правильного понимания точного подбора своей системы замещения волос.");
$APPLICATION->SetTitle("Рекомендации по созданию своей системы замещения волос | Интернет-магазин \"Система Волос\"");

CModule::IncludeModule('iblock');
$arSelect = Array("ID", "NAME", "PREVIEW_TEXT", "IBLOCK_SECTION_ID");
$arFilter = Array("IBLOCK_ID"=>1, "ACTIVE"=>"Y", "SECTION_GLOBAL_ACTIVE"=>"Y");
$dbRes = CIBlockElement::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter, false, false, $arSelect);
$arElements = array();
while($arr = $dbRes->Fetch())
{
	$arElements[$arr['IBLOCK_SECTION_ID']][] = $arr;
}

$arSectionsKeys = array_keys($arElements);
$arSections = array();
if(!empty($arSectionsKeys))
{
	$arFilter = Array("IBLOCK_ID"=>1, "GLOBAL_ACTIVE"=>"Y", "ID"=>$arSectionsKeys);
	$dbRes = CIBlockSection::GetList(Array("SORT"=>"ASC", "ID"=>"ASC"), $arFilter);
	while($arr = $dbRes->Fetch())
	{
		$arSections[] = $arr;
	}
}

echo '<div class="small article">';
foreach($arSections as $k=>$sect)
{
	echo '<a href="#" name="s'.$sect['ID'].'"></a>';
	if($k==0)
	{
		echo '<div class="title">'.$sect['NAME'].'</div>';
	}
	else
	{
		echo '<div class="hr"></div><div class="title article">'.$sect['NAME'].'</div>';
	}
	
	if(is_array($arElements[$sect['ID']]))
	{
		foreach($arElements[$sect['ID']] as $k2=>$elem)
		{
			echo '<div class="one-el">
					<div class="element">
						<div class="show-hide-det-arrow"></div>
						<p class="title-24">'.$elem['NAME'].'</p>
					</div>
					<div class="element-description">'.$elem['PREVIEW_TEXT'].'</div>
				</div>';
		}
	}
}
echo '</div>';
?>
 	
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>