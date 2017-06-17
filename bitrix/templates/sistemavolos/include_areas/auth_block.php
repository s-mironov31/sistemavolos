<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="admission_wrap">
<?
if(!$GLOBALS['USER']->IsAuthorized())
{
	echo '<div class="btn"><a href="javascript:void(0)" onclick="ShowLoginForm()" class="admission radiused myriad-12">вход</a></div>';
}
else
{
	echo '<a href="/personal/">Личный кабинет</a>
		  <div class="btn2"><a href="?logout=yes" class="admission radiused myriad-12">выход</a></div>';
}
?>
</div>