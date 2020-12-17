<?php

$str = '
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>'.$lead->name.', поздравляем!</h3>
		<p>Вы зарегистрировались на&nbsp;предпринимательский форум Героев российского бизнеса, который состоится '.$lead->dater.'&nbsp;года в&nbsp;VEGAS CITY HALL (г.&nbsp;Москва).</p>
		<p>На&nbsp;форуме вас ждут выступления предпринимателей, чьи кейсы изменили экономику страны: мы собрали на&nbsp;одной сцене людей, которые создавали и&nbsp;развивали свой бизнес в&nbsp;России, невзирая на&nbsp;трудности, и&nbsp;в&nbsp;итоге пришли к&nbsp;победе.</p>
		<p>Спасибо, что решили быть с&nbsp;нами!</p>
		<p>Держите телефон под&nbsp;рукой: мы позвоним, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.</p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-'.Date('Y').'. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал,&nbsp;2, стр.&nbsp;1, офис&nbsp;602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
</div>
';

if($lead->form == 'offer-speaker') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Спасибо за&nbsp;ваше участие в&nbsp;формировании пула спикеров предпринимательского форума «Герои российского бизнеса». Мы&nbsp;учтем ваше пожелание, а&nbsp;<a href="http://sbs.edu.ru/assets/SBS_catalog_web.pdf" target="_blank">пока посмотрите, кого мы&nbsp;уже собрали на&nbsp;форуме</a>.</p>
			<p>Успейте <a href="http://synergyheroes.ru?utm_source=tranzmail-sm" target="_blank">зарегистрироваться на&nbsp;форум</a> и&nbsp;занять лучшие места в&nbsp;зале Crocus Vegas! Герои российского бизнес ждут вас '.$lead->dater.', чтобы поделиться секретами создания и&nbsp;управления бизнесом в&nbsp;России.</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru?utm_source=tranzmail-sm" target="_blank" style="width: 200px; height: 50px;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-'.Date('Y').'. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
	</div>
	';
}

elseif($lead->form == 'programm') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на получение программы форума Героев российского бизнеса. <br>Скачать программу вы можете, <a href="http://synergyvision.ru/Russian-Business-Heroes-Forum-Program.pdf" target="_blank">пройдя по ссылке</a>.</p>
			<p>Успейте зарегистрироваться на&nbsp;форум и&nbsp;получите заряд вдохновения от&nbsp;наших Героев! 5&ndash;6 октября в&nbsp;Vegas City Hall вас ждут выступления Алексея Нечаева (Faberlic), Евгения Демина (SPLAT), Александра Глушкова (МОНЕ) и&nbsp;других предпринимателей, изменивших российскую действительность.</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru?utm_source=tranzmail-sm" target="_blank" style="width: 200px; height: 50px;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-'.Date('Y').'. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
	</div>
	';
}

elseif($lead->form == 'catalog') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на получение каталога Школы Бизнеса. <br>Скачать каталог вы можете, <a href="http://sbs.edu.ru/assets/SBS_catalog_web.pdf" target="_blank">пройдя по ссылке</a>.</p>
			<p>Успейте зарегистрироваться на&nbsp;форум и&nbsp;получите заряд вдохновения от&nbsp;наших Героев! 5&ndash;6 октября в&nbsp;Vegas City Hall вас ждут выступления Алексея Нечаева (Faberlic), Евгения Демина (SPLAT), Александра Глушкова (МОНЕ) и&nbsp;других предпринимателей, изменивших российскую действительность.</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru?utm_source=tranzmail-sm" target="_blank" style="width: 200px; height: 50px;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-'.Date('Y').'. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
	</div>
	';
}

elseif($lead->form == 'prgrm') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Добрый день!</h3>
			<p>Вы оставляли заявку на&nbsp;получение программы Предпринимательского форума &laquo;Герои российского бизнеса 2017&raquo;.</p>
			<p>Скачать программу вы можете, пройдя <a href="http://synergyvision.ru/Russian-Business-Heroes-Forum-Program.pdf" target="_blank" style="width: 200px; height: 50px;">по&nbsp;ссылке</a>.</p>
			<p>Успейте зарегистрироваться на&nbsp;форум и&nbsp;получить максимум полезного контента от&nbsp;легендарных предпринимателей!</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyvision.ru?utm_source=tranzmail-sm" target="_blank" style="width: 200px; height: 50px;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-'.Date('Y').'. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
	</div>
	';
}
/* #140231
elseif($lead->form == 'subscription-lp-17' && $lead->land == 'forumgeroev') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Спасибо! Ваша заявка отправлена.</h3>
			<p>Уже совсем скоро вы&nbsp;получите первое письмо с&nbsp;видео выступления спикера форума &laquo;Герои российского бизнеса 2016&raquo;.</p>

		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. +7&nbsp;(800)&nbsp;707-41-77</div>
	</div>
	';
}
*/


return $str;