<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?> 
	<?if(MAINPAGE!=='Y'){?>
	</div>
	<?}?>
	
	<?$APPLICATION->IncludeComponent(
		"bitrix:main.include",
		"",
		Array(
			"AREA_FILE_SHOW" => "page",
			"AREA_FILE_SUFFIX" => "bottom_inc",
			"EDIT_TEMPLATE" => ""
		)
	);?>

	<!--footer-->
	<div class="footer large f-pink">
		<div class="small">
			<div class="top-arrow"></div>
			<div class="clear"></div>
			<div class="free-phone">
				<p class="free-text">Бесплатный звонок по России</p>
				<p class="free_number">8 (800) 700-15-82</p>
			</div>
			<?include($_SERVER['DOCUMENT_ROOT'].'/handlers/callback.php');?>
			
			<div class="myrmex">
				Сделано с <!--<span class="heart">&hearts;</span>-->
				<img style="position: relative;" src="/images/heart.png" width="11" height="12" >
				<a href="http://www.myrmex.ru" target="_blank"><img style="position: relative; top: 2px;" src="/images/myrmex_logo.jpg" alt="Мирмекс - разработка, поддержка, продвижение сайтов" title="Мирмекс - разработка, поддержка, продвижение сайтов" width="12" height="17" ></a> 
				&laquo;<a href="http://www.myrmex.ru" target="_blank">Мирмекс</a>&raquo;
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div class="footer large f-beige">
		<div class="small">
			<div class="f-b-1">Мы доставляем по всей России</div>
			<div class="f-b-2">
				<div class="post" title="Почта России"></div>
				<div class="ems" title="EMS"></div>
			</div>
			<div class="vert-line"></div>
			<div class="f-b-3"><div style="clear: both;">Удобные системы оплаты</div>
      <div style="clear: both;text-align: center;padding-top: 5px;">
      <!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t18.18;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border='0' width='88' height='31'><\/a>")
//--></script><!--/LiveInternet-->
</div>
      </div>
			<div class="f-b-4"></div>
			<div class="clear"></div>
		</div>
	</div>
	<!--/footer-->
	<!--<div class="working">
		На сайте проводятся работы. Возможны технические наполадки.
	</div>-->
	
<noindex>


<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter26109384 = new Ya.Metrika({id:26109384,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/26109384" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</noindex>
<!-- BEGIN JIVOSITE CODE {literal}-->
<script type='text/javascript'>
(function(){ var widget_id = 'xe43MTNlBi';var d=document;var w=window;function l(){
var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();</script> 
<!-- {/literal} END JIVOSITE CODE --> 	
</body>
</html>