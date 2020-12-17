<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru" title="Перейти на сайт Университета"><img src="http://synergy.ru/lp/box/logo/logo.png" alt="" width="240" height="35"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы зарегистрировались на лекцию Юрия Дегтярева <b>«{$lead->program}»</b>.</p>
		<p>Мы ждем вас <b>{$lead->dater}</b> по&nbsp;адресу: м.&nbsp;«Семеновская», ул.&nbsp;Измайловский Вал, д.&nbsp;2, стр.&nbsp;1, конференц-зал.</p>
		<p style="margin:40px 0; text-align: center;"><a href="{$link}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Ваша ссылка на онлайн-трансляцию »</a></p>
		<p>Мы рекомендуем подключаться к трансляции за 10 минут до начала.</p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С&nbsp;уважением, команда <p style="color:#505050;">Университета «Синергия»</p></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 2015. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href="tel:+74958001001">+7 (495) 800 10 01</a></div>
</div>
EOD;
return $str;