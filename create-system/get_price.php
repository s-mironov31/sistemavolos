<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

/*Загрузка файлов*/
if($_FILES['EXAMPLE'])
{
	$arFiles = array();
	$dir = $_SERVER['DOCUMENT_ROOT'].'/upload/orders/'.$_POST['FUSER_ID'].'/';
	if(!file_exists($dir)) mkdir($dir);
	foreach($_FILES['EXAMPLE'] as $k=>$v)
	{
		if(!is_array($_FILES['EXAMPLE'][$k])) $_FILES['EXAMPLE'][$k] = array($_FILES['EXAMPLE'][$k]);
	}
	
	foreach($_FILES['EXAMPLE']['name'] as $k=>$v)
	{
		if($v && $_FILES['EXAMPLE']['error'][$k]==0)
		{
			$ext = end(explode('.', $v));
			$fn = $fnSmall = '';
			while(!$fn || file_exists($dir.$fn))
			{
				$fn = time().round(current(explode(' ', microtime())) * 1000);
				$fnSmall = $fn.'_small.'.$ext;
				$fn = $fn.'.'.$ext;
			}
			$fn = $dir.$fn;
			$fnSmall = $dir.$fnSmall;
			move_uploaded_file($_FILES['EXAMPLE']['tmp_name'][$k], $fn);
			CFile::ResizeImageFile($fn, $fnSmall, array('width'=>170, 'height'=>170),BX_RESIZE_IMAGE_PROPORTIONAL);
			$arFiles[] = array(
				'name' => htmlspecialchars($v),
				'src' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $fn),
				'icon_src' => str_replace($_SERVER['DOCUMENT_ROOT'], '', $fnSmall),
			);
		}
	}
}
/*/Загрузка файлов*/

$price = 0;
$arProps = array();

/*Длина*/
$length1 = $_POST['LENGTH'];
$length2 = strtr($length1, array('.'=>',', ','=>'.'));
$dbRes = CIblockElement::GetList(array(), array('IBLOCK_ID'=>4, 'NAME'=>array($length1, $length2)), false, false, array('NAME', 'CODE'));
$arr = $dbRes->Fetch();
$price = floatval(str_replace(',', '.', $arr['CODE']));
$arProps['LENGTH'] = floatval(str_replace(',', '.', $_POST['LENGTH']));
/*/Длина*/

/*Размер головы 1*/
$size = str_replace('.', ',', floatval(str_replace(',', '.', $_POST['HEADSIZE1'])));
$dbRes = CIblockElement::GetList(array('NAME'=>'DESC'), array('IBLOCK_ID'=>5, '<=NAME'=>$size), false, array('nTopCount'=>1), array('NAME', 'CODE'));
$arr = $dbRes->Fetch();
$price += floatval(str_replace(',', '.', $arr['CODE']));
/*/Размер головы 1*/

/*Все размеры головы*/
$arProps['HEADSIZE1'] = floatval(str_replace(',', '.', $_POST['HEADSIZE1']));
$arProps['HEADSIZE2'] = floatval(str_replace(',', '.', $_POST['HEADSIZE2']));
$arProps['HEADSIZE3'] = floatval(str_replace(',', '.', $_POST['HEADSIZE3']));
$arProps['HEADSIZE4'] = floatval(str_replace(',', '.', $_POST['HEADSIZE4']));
$arProps['HEADSIZE5'] = floatval(str_replace(',', '.', $_POST['HEADSIZE5']));
$arProps['HEADSIZE6'] = floatval(str_replace(',', '.', $_POST['HEADSIZE6']));
/*/Все размеры головы*/

/*Наценка за цвет*/
if($_POST['COLOR'] > 0)
{
	$dbRes = CIblockElement::GetList(array(), array('ID'=>$_POST['COLOR']), false, false, array('CODE'));
	$arr = $dbRes->Fetch();
	$price = $price * (1 + floatval(str_replace(',', '.', $arr['CODE']))/100);
	$arProps['COLOR'] = intval($_POST['COLOR']);
}
/*/Наценка за цвет*/

/*Наценка за седые волосы*/
if($_POST['GRAY_HAIR'] > 0)
{
	$dbRes = CIblockElement::GetList(array(), array('ID'=>$_POST['GRAY_HAIR']), false, false, array('CODE'));
	$arr = $dbRes->Fetch();
	$price = $price * (1 + floatval(str_replace(',', '.', $arr['CODE']))/100);
	$arProps['GRAY_HAIR'] = intval($_POST['GRAY_HAIR']);
}
/*/Наценка за седые волосы*/

/*Завивка / волнистость*/
if($_POST['WAVE'] > 0)
{
	$dbRes = CIblockElement::GetList(array(), array('ID'=>$_POST['WAVE']), false, false, array('CODE'));
	$arr = $dbRes->Fetch();
	$price += floatval(str_replace(',', '.', $arr['CODE']));
	$arProps['WAVE'] = intval($_POST['WAVE']);
}
/*/Завивка / волнистость*/

/*Имитация кожного покрова*/
if($_POST['IMITATION_SKIN'] > 0 && $_POST['IMITATION_SKIN_Y']=='Y')
{
	$dbRes = CIblockElement::GetList(array(), array('ID'=>$_POST['IMITATION_SKIN']), false, false, array('CODE'));
	$arr = $dbRes->Fetch();
	$price += floatval(str_replace(',', '.', $arr['CODE']));
	$arProps['IMITATION_SKIN'] = intval($_POST['IMITATION_SKIN']);
}
/*/Имитация кожного покрова*/

/*Прочие параметры*/
$arProps['VOLUME'] = $_POST['VOLUME'];
$arProps['BASIS'] = intval($_POST['BASIS']);
/*/Прочие параметры*/

//print_r($_POST);

if($_POST['ADD2BASKET'] || $_POST['ADD2BASKET_x'])
{
	Cmodule::IncludeModule('catalog');
	Cmodule::IncludeModule('sale');
	
	/*Соберем фото*/
	$arPhoto = array();
	if(is_array($_POST['IMG']['SRC']))
	{
		foreach($_POST['IMG']['SRC'] as $k=>$v)
		{
			$arFile = CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"].$v);
			$arFile['name'] = $_POST['IMG']['NAME'][$k];
			$arPhoto[] = $arFile;
		}
	}
	$arProps['PHOTO'] = $arPhoto;
	/*/Соберем фото*/
	
	$el = new CIBlockElement;

	$arFields = Array(
		"IBLOCK_ID"      => 3,
		"PROPERTY_VALUES"=> $arProps,
		"NAME"           => "Система волос",
		"ACTIVE"         => "Y",
	);
	$PRODUCT_ID = $el->Add($arFields);
	
	/*Удаление картинок*/
	if(is_array($_POST['IMG']['SRC']))
	{
		foreach($_POST['IMG']['SRC'] as $k=>$v)
		{
			unlink($_SERVER["DOCUMENT_ROOT"].$v);
		}
		foreach($_POST['IMG']['SRC_SMALL'] as $k=>$v)
		{
			unlink($_SERVER["DOCUMENT_ROOT"].$v);
		}
	}
	/*/Удаление картинок*/
	
	CPrice::SetBasePrice($PRODUCT_ID, $price, 'RUB');
	CCatalogProduct::Add(array('ID'=>$PRODUCT_ID, 'CAN_BUY_ZERO'=>'Y'));
	
	Add2BasketByProductID($PRODUCT_ID, 1);
	$gotobasket = true;
}

?>
<html>
	<body>
		<?
		//if($arFiles) echo '<div id="files">'.json_encode($arFiles).'</div>';
		?>
		<div id="price"><?=$price?></div>
	</body>
</html>
<script>
	window.parent.SetCalcPrice(document.getElementById('price').innerHTML);
	<?
	if(!empty($arFiles))
	{
		echo 'window.parent.SetCalcFiles('.json_encode($arFiles).');';
	}
	
	if($gotobasket)
	{
		echo 'window.parent.location = "/personal/basket/";';
	}
	?>
</script>