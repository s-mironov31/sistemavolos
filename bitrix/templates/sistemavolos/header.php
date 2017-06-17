<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!DOCTYPE html>
<html>
<head>
<?
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-1.7.2.min.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/jquery-ui.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/SlideJS/slides.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/validate.js');
$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH.'/js/j.js');

$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/js/SlideJS/style.css');
$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH.'/js/slider-range/style.css');
?>
<?$APPLICATION->ShowHead()?>
<title><?$APPLICATION->ShowTitle()?></title>
<!--[if lt IE 9]>
<style type='text/css'>
table.top-menu td { 
	font-family: Arial;
}
</style>
<![endif]-->
</head>

<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>

	<iframe name="hidden_frame" id="hidden_frame" style="display: none;"></iframe>
	<?$APPLICATION->IncludeFile(
		$APPLICATION->GetTemplatePath("include_areas/auth_form.php"),
		Array(),
		Array("MODE"=>"php")
	);?>
	<?$APPLICATION->IncludeFile(
		$APPLICATION->GetTemplatePath("include_areas/thanks_form.php"),
		Array(),
		Array("MODE"=>"php")
	);?>
	<div class="h-fixed">
		<div class="header small" id="initial">
			<a class="logo" href="/" alt="Системы замещения волос по низким ценам с бесплатной доставкой." title="Системы замещения волос по низким ценам с бесплатной доставкой."></a>
			<?$APPLICATION->IncludeFile(
				$APPLICATION->GetTemplatePath("include_areas/auth_block.php"),
				Array(),
				Array("MODE"=>"php")
			);?>
			<div class="basket" id="basket">
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.basket.basket.small",
					"",
					Array(
						"PATH_TO_BASKET" => "/personal/basket/",
						"PATH_TO_ORDER" => "/personal/basket/"
					),
					false
				);?>
			</div>
			<div class="phones">
				<p class="free">Бесплатный звонок по России</p>
				<p class="p_number">8 (800) 700-15-82</p>
			</div>
			<a href="javascript:void(0)" onclick="GoToCallback()" class="order_ring">заказать звонок</a>
			
			<div class="hr"></div>
			<a href="/create-system/" class="hair_system blue-button radiused">система волос на заказ</a>
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"top",
				Array(
					"ROOT_MENU_TYPE" => "top", 
					"MAX_LEVEL" => "1", 
					"CHILD_MENU_TYPE" => "left", 
					"USE_EXT" => "Y", 
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => Array()
				)
			);?>
		</div>
		<div class="header small" id="compact">
			<a class="logo" href="/" alt="Системы замещения волос по низким ценам с бесплатной доставкой." title="Системы замещения волос по низким ценам с бесплатной доставкой."></a>
			<a href="/create-system/" class="hair_system blue-button radiused">система волос на заказ</a>
			<?$APPLICATION->IncludeFile(
				$APPLICATION->GetTemplatePath("include_areas/auth_block.php"),
				Array(),
				Array("MODE"=>"php")
			);?>
			<div class="basket" id="basket2">
				<?$APPLICATION->IncludeComponent(
					"bitrix:sale.basket.basket.small",
					"",
					Array(
						"PATH_TO_BASKET" => "/personal/basket/",
						"PATH_TO_ORDER" => "/personal/basket/"
					),
					false
				);?>
			</div>
			<?$APPLICATION->IncludeComponent(
				"bitrix:menu",
				"top",
				Array(
					"ROOT_MENU_TYPE" => "top", 
					"MAX_LEVEL" => "1", 
					"CHILD_MENU_TYPE" => "left", 
					"USE_EXT" => "Y", 
					"MENU_CACHE_TYPE" => "A",
					"MENU_CACHE_TIME" => "3600",
					"MENU_CACHE_USE_GROUPS" => "Y",
					"MENU_CACHE_GET_VARS" => Array()
				)
			);?>
		</div>
	</div>
	<div class="header-height"></div>
	<!--/header-->
	
	<?if(MAINPAGE!=='Y'){?>
	<div class="small content">
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.include",
			"",
			Array(
				"AREA_FILE_SHOW" => "page",
				"AREA_FILE_SUFFIX" => "top_inc",
				"EDIT_TEMPLATE" => ""
			)
		);?>
		<?if(NOT_SHOW_TITLE!=='Y'){?>
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
		<?}?>
	<?}?>