<?
define('NOT_SHOW_TITLE', 'Y');
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("title", "Шаблон подбора индивидуальной системы волос | Интернет-магазин \"Система Волос\"");
$APPLICATION->SetPageProperty("description", "Пошаговая инструкция по созданию своей системы волос на основе личных особенностей средствами интернет-магазина \"Система Волос\"");
$APPLICATION->SetTitle("Создать свою систему волос");
CModule::IncludeModule("iblock");
CModule::IncludeModule("sale");

/*Цвета*/
$arColors = array();
$dbRes = CIblockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=>6, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'PREVIEW_PICTURE'));
while($arr = $dbRes->Fetch())
{
	$arr['PREVIEW_PICTURE'] = CFile::GetFileArray($arr['PREVIEW_PICTURE']);
	$arColors[] = $arr;
}
/*/Цвета*/

/*Седые цвета*/
$arGreyColors = array();
$dbRes = CIblockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=>7, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'PREVIEW_PICTURE'));
while($arr = $dbRes->Fetch())
{
	$arr['PREVIEW_PICTURE'] = CFile::GetFileArray($arr['PREVIEW_PICTURE']);
	$arGreyColors[] = $arr;
}
/*/Седые цвета*/

/*Завивка / волнистость*/
$arWaves = array();
$dbRes = CIblockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=>8, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'XML_ID', 'PREVIEW_PICTURE'));
while($arr = $dbRes->Fetch())
{
	$arr['PREVIEW_PICTURE'] = CFile::GetFileArray($arr['PREVIEW_PICTURE']);
	$arWaves[] = $arr;
}
/*/Завивка / волнистость*/

/*Имитация кожного покрова*/
$arImitationSkin = array();
$dbRes = CIblockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=>9, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME'));
while($arr = $dbRes->Fetch())
{
	$arImitationSkin[] = $arr;
}
/*/Имитация кожного покрова*/

/*Основа*/
$arBasis = array();
$dbRes = CIblockElement::GetList(array('SORT'=>'ASC'), array('IBLOCK_ID'=>10, 'ACTIVE'=>'Y'), false, false, array('ID', 'NAME', 'PREVIEW_PICTURE'));
while($arr = $dbRes->Fetch())
{
	$arr['PREVIEW_PICTURE'] = CFile::GetFileArray($arr['PREVIEW_PICTURE']);
	$arBasis[] = $arr;
}
/*/Основа*/


$arProps = array();
if($_GET['example'])
{
	$arSelect = array(
		'PROPERTY_LENGTH',
		'PROPERTY_COLOR',
		'PROPERTY_WAVE',
		'PROPERTY_VOLUME',
		'PROPERTY_BASIS'
	);
	$dbRes = CIblockElement::GetList(array(), array('ID'=>$_GET['example']), false, false, $arSelect);
	if($arr = $dbRes->Fetch())
	{
		foreach($arr as $k=>$v)
		{
			if(preg_match('/^PROPERTY_(\S+)_VALUE$/', $k, $m))
			{
				$arProps[$m[1]] = $v;
			}
		}
	}
}
?>

<form class="small calculator" method="post" action="./get_price.php" target="hidden_frame" name="calcForm" enctype="multipart/form-data" validate="true">
	<input type="hidden" name="FUSER_ID" value="<?=CSaleBasket::GetBasketUserID();?>">

	<p class="title">Создать свою систему <br>волос</p>
	<div class="multi-progress nine-elements">
		<div class="m-p-element current" dynamic_change_progress="LENGTH">длина</div>
		<div class="m-p-element" dynamic_change_progress="params">параметры</div>
		<div class="m-p-element" dynamic_change_progress="hair-color">цвет</div>
		<!--<div class="m-p-element" dynamic_change_progress="grey-haired">седые*</div>-->
		<!--<div class="m-p-element" dynamic_change_progress="wave">завивка</div>-->
		<div class="m-p-element" dynamic_change_progress="sixth">кожа</div>
		<div class="m-p-element" dynamic_change_progress="VALUME">объем</div>
		<!--<div class="m-p-element" dynamic_change_progress="base">основа</div>-->
		<div class="m-p-element blued" dynamic_change_progress="">расчет</div>
	</div>

	<!--
	<div class="i-help">i
		<div class="i-helper-text"> 
			<div class="lbl">i</div>
			<div class="triangle"><div class="triangle-inner"></div></div>
		</div>
	</div>
	<div class="clear"></div>-->
	<section class="oled">
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip1",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class="title-24">1. Выбираем длину <br>волос:</p>
		<!--<div class="sli"></div>-->
		<iframe src="<?=SITE_TEMPLATE_PATH?>/tmp/1.php?LENGTH=<?=$arProps['LENGTH']?>" class="slider-range" scrolling="no"></iframe>
		
		<div class="clear"></div>
		<section class="lbbl-1">
			<span class="pink floated">Выбранная длина </span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="LENGTH"></span>
		</section>
		<div class="clear oled-marg"></div>
		<!--2-->
		<p class="title-24">2. Измеряем голову</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip2",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="oled-2-l" dynamic_change_flag="params" id="headsizes">
			<p class="pink descrp">Введите данные измерений в сантиметрах:</p>
			<p>
				<span class="ttr pink">1 — </span>
				<input type="text" class="calced lft" name="HEADSIZE1" value="" validate="not_empty" title="Размер головы 1" onchange="ChangeMultiProgress('params')">
				<span class="ttr pink">2 — </span>
				<input type="text" class="calced" name="HEADSIZE2" value="" validate="not_empty" title="Размер головы 2">
			</p>
			<p>
				<span class="ttr pink">3 — </span>
				<input type="text" class="calced lft" name="HEADSIZE3" value="" validate="not_empty" title="Размер головы 3">
				<span class="ttr pink">4 — </span>
				<input type="text" class="calced" name="HEADSIZE4" value="" validate="not_empty" title="Размер головы 4">
			</p>
			<p>
				<span class="ttr pink">5 — </span>
				<input type="text" class="calced lft" name="HEADSIZE5" value="" validate="not_empty" title="Размер головы 5">
				<span class="ttr pink">6 — </span>
				<input type="text" class="calced" name="HEADSIZE6" value="" validate="not_empty" title="Размер головы 6">
			</p>
			
		</div>
		<div class="oled-2-r"></div>
		<div class="clear"></div>
		
		<!--3-->
		<p class="title-24">3. Выбираем цвет</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip3",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class="descrr third">Наценка за светлые волосы + 10% (цвета с 7 по 27S)</p>
		<div class="container radios-customizes slider-for">
			<div class="radios circled" dynamic_change="hair-color">
				<div class="horiz_slider horiz_slider_custom horiz_slider_color">
				<div class="dynamic_block">
				<?
				$arItems = array(10, 10, 9, 9);
				for($i=0; $i<count($arItems); $i++)
				{
					$arTmp = array_slice($arColors, array_sum(array_slice($arItems, 0, $i)), $arItems[$i]);
					echo '<div class="item item_'.$arItems[$i].'">';
					foreach($arTmp as $k=>$v)
					{
						if($arProps['COLOR']==$v['ID'])
						{
							$APPLICATION->SetPageProperty('clider_color_num', $i);
						}
						echo '<div class="radio-wrap">
									<p class="txt"><!--Кодировка цвета -->'.$v['NAME'].'</p>
									<input type="radio" class="niceRadio" name="COLOR" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.(($k==0 && $i==0) ? 'validate="not_empty" title="Цвет"' : '').' '.($arProps['COLOR']==$v['ID'] ? 'checked' : '').' /> 
								</div>';
					}
					echo '<div class="shareimg"><img src="/images/color'.($i+1).'.jpg" width="814px" height="558px" alt="" title=""></div>';
					echo '</div>';
				}
				?>
				<div class="clear"></div>
				</div>
				</div>
			</div>
		</div>
		<?/*?>
		<div class="container radios-customizes slider-for">
			<div class="radios circled" dynamic_change="hair-color">
				<?
				echo '<div class="horiz_slider horiz_slider_color">';
				if(count($arColors) > 10)
				{
					echo '<a href="javascript:void(0)" class="left_btn" title="Назад"></a>
						  <a href="javascript:void(0)" class="right_btn" title="Вперед"></a>';
				}

				echo '<div class="static_block"> 					 
							<!--<div class="dynamic_block" id="horiz_slider_colors">-->';
				$APPLICATION->AddBufferContent(function(){return '<div class="dynamic_block" id="horiz_slider_colors" style="margin-left: '.(-814 * max(0, intval($GLOBALS['APPLICATION']->GetPageProperty('clider_color_num')))).'px">';});
				$arItems = array(10, 10, 9, 9);
				for($i=0; $i<count($arItems); $i++)
				{
					$arTmp = array_slice($arColors, array_sum(array_slice($arItems, 0, $i)), $arItems[$i]);
					echo '<div class="item item_'.$arItems[$i].'">';
					foreach($arTmp as $k=>$v)
					{
						if($arProps['COLOR']==$v['ID'])
						{
							$APPLICATION->SetPageProperty('clider_color_num', $i);
						}
						echo '<div class="radio-wrap">
									<p class="txt"><!--Кодировка цвета -->'.$v['NAME'].'</p>
									<input type="radio" class="niceRadio" name="COLOR" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.(($k==0 && $i==0) ? 'validate="not_empty" title="Цвет"' : '').' '.($arProps['COLOR']==$v['ID'] ? 'checked' : '').' /> 
								</div>';
					}
					echo '<div class="shareimg"><img src="/images/color'.($i+1).'.jpg" width="814px" height="558px" alt="" title=""></div>';
					echo '</div>';
				}
				echo '</div></div></div>';
				?>
			</div>
		</div>
		<?*/?>
		<?/*?>
		<div class="container radios-customizes slider-for">
			<div id="slides" class="s-slides radios circled" dynamic_change="hair-color">				
					<section class="one-view">
						<?
						foreach($arColors as $k=>$v)
						{
							if($k>0 && $k%6==0)
							{
								echo '<div class="clear"></div></section><section class="one-view">';
							}
							echo '<div class="radio-wrap">
										<div class="img-wrap">
											<table class="vert-aligned-table"><tr><td><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" width="214px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></td></tr></table>
										</div>
										<p class="txt">Кодировка цвета '.$v['NAME'].'</p>
										<input type="radio" class="niceRadio" name="COLOR" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.($k==0 ? 'validate="not_empty" title="Цвет"' : '').' '.($arProps['COLOR']==$v['ID'] ? 'checked' : '').' /> 
									</div>';
						}
						?>
						<div class="clear"></div>
					</section>
			</div>
		</div>
		<?*/?>


		<div class="clear"></div>
		<section class="lbbl">
			<span class="pink floated">Выбранный цвет</span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="hair-color">не выбран</span>
		</section>
		<div class="clear oled-marg"></div>
		
		<!--4-->
		<?/*?>
		<p class="title-24">4. Седые волосы*</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip4",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class="descrr">Наценка за седые волосы + 5%</p>
		
		<div class="container radios-customizes slider-for">
			<div class="radios circled" dynamic_change="grey-haired">
				<?
				echo '<div class="horiz_slider">';
				if(count($arGreyColors) > 10)
				{
					echo '<a href="javascript:void(0)" class="left_btn" title="Назад"></a>
						  <a href="javascript:void(0)" class="right_btn" title="Вперед"></a>';
				}

				echo '<div class="static_block"> 					 
							<!--<div class="dynamic_block" id="horiz_slider_greycolors">-->';
				$APPLICATION->AddBufferContent(function(){return '<div class="dynamic_block" id="horiz_slider_greycolors" style="margin-left: '.(-280 * max(0, intval($GLOBALS['APPLICATION']->GetPageProperty('clider_greycolor_num')) - 2)).'px">';});
				$i = 0;
				while(count($arGreyColors) > $i)
				{
					$arTmp = array_slice($arGreyColors, $i, 1);
					echo '<div class="item">';
					foreach($arTmp as $k=>$v)
					{
						if($arProps['GRAY_HAIR']==$v['ID'])
						{
							$APPLICATION->SetPageProperty('clider_greycolor_num', $i/1);
						}
						echo '<div class="radio-wrap">
									<p class="txt"><!--Кодировка цвета -->'.$v['NAME'].'</p>
									<input type="radio" class="niceRadio" name="GRAY_HAIR" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.($arProps['GRAY_HAIR']==$v['ID'] ? 'checked' : '').' /> 
									<div class="img-wrap">
										<table class="vert-aligned-table"><tr><td><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" height="214px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></td></tr></table>
									</div>
								</div>';
					}
					echo '</div>';
					$i += 1;
				}
				echo '</div></div></div>';
				?>
			</div>
		</div>
		<?*/?>
		<?/*?>
		<div class="container radios-customizes slider-for">
			<div id="slides2" class="s-slides radios circled" dynamic_change="grey-haired">
					<section class="one-view">
						<?
						foreach($arGreyColors as $k=>$v)
						{
							if($k>0 && $k%6==0)
							{
								echo '<div class="clear"></div></section><section class="one-view">';
							}
							echo '<div class="radio-wrap">
										<div class="img-wrap">
											<table class="vert-aligned-table"><tr><td><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" width="214px" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></td></tr></table>
										</div>
										<p class="txt">Кодировка цвета '.$v['NAME'].'</p>
										<input type="radio" class="niceRadio" name="GRAY_HAIR" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.($arProps['GRAY_HAIR']==$v['ID'] ? 'checked' : '').' /> 
									</div>';
						}
						?>
					<div class="clear"></div>
				</section>
			
			</div>
		</div>
		<?*/?>
		
		<?/*?>
		<div class="clear"></div>
		<section class="lbbl">
			<span class="pink floated">Выбранный цвет</span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="grey-haired">не выбран</span>
		</section>
		<div class="clear oled-marg"></div>
		<?*/?>
		
		<!--5-->
		<?/*?>
		<p class="title-24">5. Выбираем завивку/волнистость</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip5",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="radios-customizes fifth">
			<div class="radios circled" dynamic_change="wave">
				<!--<div class="slider-arrow-l"></div>
				<div class="slider-arrow-r"></div>-->
				<section class="one-view">
						<?
						foreach($arWaves as $k=>$v)
						{
							if($k>0 && $k%10==0)
							{
								echo '<div class="clear"></div></section><section class="one-view">';
							}
							echo '<div class="radio-wrap">
										<div class="img-wrap">
											<table class="vert-aligned-table"><tr><td><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></td></tr></table>
										</div>
										<p class="txt">'.$v['NAME'].'<br>('.$v['XML_ID'].')</p>
										<input type="radio" class="niceRadio" name="WAVE" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['XML_ID']).'" '.($k==0 ? 'validate="not_empty" title="Завивка/волнистость"' : '').'  '.($arProps['WAVE']==$v['ID'] ? 'checked' : '').' /> 
									</div>';
						}
						?>
					<div class="clear"></div>
				</section>
			</div>
		</div>
		<div class="clear"></div>
		<section class="lbbl fifth">
			<span class="pink floated">Выбранная волнистость</span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="wave">не выбрана</span>
		</section>
		<div class="clear oled-marg"></div>
		<?*/?>
		<!--6-->
		<p class="title-24">4. Нужна ли шелковая вставка?</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip6",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class="descrr">Для максимальной имитации кожного покрова</p>
		<div class="clear"></div>
		<div class="radios-customizes sixth" dynamic_change_flag="sixth">
			<div class="text-beige">Нет</div>
			<div class="radios squared">
				<input type="radio" class="niceRadio" name="IMITATION_SKIN_Y" tabindex="1" value="N" checked="checked" onchange="if(this.checked){document.calcForm.IMITATION_SKIN[0].removeAttribute('validate');$('#iskin').hide();}else {document.calcForm.IMITATION_SKIN[0].setAttribute('validate', 'not_empty');$('#iskin').show();}" /> 
				<input type="radio" class="niceRadio" name="IMITATION_SKIN_Y" tabindex="2" value="Y" onchange="if(this.checked){document.calcForm.IMITATION_SKIN[0].setAttribute('validate', 'not_empty');$('#iskin').show();}else {document.calcForm.IMITATION_SKIN[0].removeAttribute('validate');$('#iskin').hide();}"/> 
			</div>
			<div class="text-beige">Да</div>
		</div>
		<div class="radios-customizes iskin" id="iskin" dynamic_change_flag="sixth" style="display: none;">
			<div class="radios circled">
				<section class="one-view">
						<?
						foreach($arImitationSkin as $k=>$v)
						{
							echo '<div class="radio-wrap">
										<p class="txt">'.$v['NAME'].'</p>
										<input type="radio" class="niceRadio" name="IMITATION_SKIN" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['XML_ID']).'" './*($k==0 ? 'validate="not_empty"' : '').*/' title="Имитация кожного покрова"  '.($arProps['IMITATION_SKIN']==$v['ID'] ? 'checked' : '').' /> 
									</div>';
						}
						?>
					<div class="clear"></div>
				</section>
			</div>
		</div>
		<div class="clear oled-marg"></div>
		
		
		<!--7-->
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip7",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class="title-24">5. Выбираем объем:</p>
		
		<!--<div class="sli"></div>-->
		<iframe src="<?=SITE_TEMPLATE_PATH?>/tmp/2.php?VOLUME=<?=$arProps['VOLUME']?>" class="slider-range" scrolling="no"></iframe>
		
		<div class="clear"></div>
		<section class="lbbl-1">
			<span class="pink floated">Выбранный объем </span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="VOLUME"></span>
			<span class="recommended-volume">Рекомендуемый объем</span>
		</section>
		<div class="clear oled-marg seventh"></div>
		
		<!--8-->
		<!--<p class="title-24">8. Выбираем основу:</p>
		<div class="i-help">i
			<div class="i-helper-text">Основа подбирается с учетом пожеланий и образа жизни клиента. От нее зависит продолжительность срока использования системы и качество фиксации. 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="radios-customizes eighth">
			<div class="radios circled" dynamic_change="base">
				<section class="one-view">
					<?
					foreach($arBasis as $k=>$v)
					{
						if($k>0 && $k%8==0)
						{
							echo '<div class="clear"></div></section><section class="one-view">';
						}
						echo '<div class="radio-wrap">
									<div class="img-wrap">
										<table class="vert-aligned-table"><tr><td><img src="'.$v['PREVIEW_PICTURE']['SRC'].'" alt="'.htmlspecialchars($v['NAME']).'" title="'.htmlspecialchars($v['NAME']).'"></td></tr></table>
									</div>
									<p class="txt">'.$v['NAME'].'</p>
									<input type="radio" class="niceRadio" name="BASIS" value="'.$v['ID'].'" data-value="'.htmlspecialchars($v['NAME']).'" '.($k==0 ? 'validate="not_empty" title="Основа"' : '').' '.($arProps['BASIS']==$v['ID'] ? 'checked' : '').' /> 
								</div>';
					}
					?>
					<div class="clear"></div>
				</section>
			</div>
		</div>
		<div class="clear"></div>
		<section class="lbbl">
			<span class="pink floated">Выбранная основа</span>
			<div class="triangle"></div>
			<span class="pink-label dynamic_change_here" dynamic_change_here="base">не выбрана</span>
		</section>
		<div class="clear oled-marg eighth"></div>-->
		
		<!--9-->
		<p class="title-24">6. Вы можете загрузить фото</p>
		<div class="i-help">i
			<div class="i-helper-text"> 
				<div class="lbl">i</div>
				<div class="triangle"><div class="triangle-inner"></div></div>
				<div class="t">		
					<?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "page",
							"AREA_FILE_SUFFIX" => "tip8",
							"EDIT_TEMPLATE" => "empty.php"
						)
					);?>
				</div>
			</div>
		</div>
		<p class='pink textt'></p>
		<div class="upload-file blue-button radiused" onclick="$('#upload_input').trigger('click')">загрузить
			<div>до 5 фото</div>
		</div>
		<input type="file" name="EXAMPLE[]" multiple style="display:none;" id="upload_input" onchange="ChangeMultiProgress('')">
		<div class="clear"></div>
		<section class="upl-photos" id="upl-photos">
			<div class="for-photo"></div>
			<div class="for-photo"></div>
			<div class="for-photo"></div>
			<div class="for-photo"></div>
			<div class="for-photo"></div>
		</section>
		<div class="hr"></div>
		<input type="image" src="/images/price.jpg" class="calc-total-price" name="ADD2BASKET" value="Расчитать окончательную стоимость">
	</section>
	<div class="total-price" id="total-price">
		<p class="ttlll">Стоимость</p>
		<p class="decsrr">с учетом выбранных параметров</p>
		<span class="prc"></span>
		<div class="triangle"></div>
	</div>
</form>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>