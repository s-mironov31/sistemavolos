<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

?>
<div class="large recommendation">
	<div class="small">
		<p class="title">Рекомендации</p>
		
		<?
		foreach($arResult['SECTIONS'] as $k=>$v)
		{
			echo '<article class="element">
					<p class="e-ttl">'.$v['NAME'].'</p>
					<div>'.$v['DESCRIPTION'].'</div>
					<a href="/recommendations/#s'.$v['ID'].'" class="to-detail">подробнее</a>
				</article>';
		}
		?>
		<div class="clear"></div>
		<a href="/recommendations/" class="to-all examples">все рекомендации</a>
		<div class="clear"></div>
	</div>
</div>