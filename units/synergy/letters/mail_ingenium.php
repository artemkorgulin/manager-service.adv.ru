<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru" title="Перейти на сайт Университета"><img src="http://synergy.ru/lp/box/logo/logo.png" alt="" width="240" height="35"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Добрый день!</h3>
		<p>Вы запросили презентацию по направлению обучения &laquo;{$lead->program}&raquo;. Посмотреть презентацию можно <a href="http://synergy.ru/lp/college_all/ingenium/{$lead->link}" target="_blank">здесь</a></p>
		<p>Ждем вас в Приемной комиссии нашего Колледжа!</p>
		<hr style="color: #E5E5E5;">
		<p>У вас остались вопросы? <br>Звоните: 8 (800) 100 00 11; +7 (495) 800 10 01</p>
		<p style="color:#505050;"><i>С&nbsp;уважением, команда <a style="color:#505050;" href="http://synergy.ru?utm_source=tranzmail-wb">Университета «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 2015. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href="tel:+74958001001">+7 (495) 800 10 01</a></div>
</div>
EOD;
return $str;