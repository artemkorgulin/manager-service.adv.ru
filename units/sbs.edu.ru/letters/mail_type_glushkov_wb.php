<?php
$leaddater = $lead->dater;
$leadprogram = $lead->program;

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Регистрация на вебинар Александра Глушкова «Бизнес на эндорфинах: когда удовольствие дороже денег»</h3>
		<h3>Здравствуйте, {$lead->name}.</h3>
		<p>Спасибо за регистрацию на вебинар <b>«{$leadprogram}»</b>, который ведет основатель и владелец сети салонов МОНЕ и Точка Красоты <b>{$lead->speaker}</b>.</p>
		<p>Вебинар состоится <b>{$leaddater}</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
		<p>На вебинаре Александр Глушков представит нам свою новую книгу «Эндорфины красоты», в которой расскажет, как создавал и развивал свой бизнес. Это книга о вдохновении и творческом подходе к выбору ниши, 18 глав из жизни, сделавших Александра Глушкова предпринимателем-визионером.</p>
		<p>Демо-версию книги вы можете прочитать, <a href="http://sbs.edu.ru/lp/glushkov/wb-v1/files/glushkov_demobook.pdf" target="_blank">пройдя по ссылке</a>.<br>
		Также вы можете сделать <a href="https://www.alpinabook.ru/catalog/SuccessStory/82257/?sphrase_id=126686" target="_blank">предзаказ книги</a> в электронной или бумажной версии.</p>
		<p style="margin:40px 0; text-align: center;"><a href="http://livestream.com/accounts/7155227/events/6274433/" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;

if($lead->form == 'download') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на получение программы форума Героев российского бизнеса. <br>Скачать программу вы можете, <a href="http://synergyvision.ru/Russian-Business-Heroes-Forum-Program.pdf" target="_blank">пройдя по ссылке</a>.</p>
			<p>Успейте <a href="http://synergyvision.ru/">зарегистрироваться на&nbsp;форум</a> и&nbsp;получите заряд вдохновения от&nbsp;наших Героев! 5&ndash;6&nbsp;октября в&nbsp;Vegas City Hall вас ждут выступления Давида Якобашвили <span style="white-space:nowrap;">(Вимм-Билль-Данн),</span> Евгения Демина (SPLAT), Александра Глушкова (МОНЕ) и&nbsp;других предпринимателей, изменивших российскую действительность.</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru" target="_blank" style="width: 200px; height: 50px; color: #fff;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
	</div>';
}

if($lead->form == 'demo') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Ваша демо-версия книги Александра Глушкова «Эндорфины красоты»
</h3>
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на получение демо-версии книги Александра Глушкова  «Эндорфины красоты». <br>Скачать демо-версию вы можете, <a href="http://sbs.edu.ru/lp/glushkov/wb-v1/files/glushkov_demobook.pdf" target="_blank">пройдя по ссылке</a>.</p>
			<p>Хотите услышать историю создания сети салонов МОНЕ и Точка красоты от первого лица?<br> <a href="http://sbs.edu.ru/lp/glushkov/wb-v1/#anchor=popup1/send=ok" target="_blank">Регистрируйтесь</a> на вебинар Александра Глушкова в Школе Бизнеса «Синергия».<br> Мероприятие состоится 20 сентября в 20:00. Присоединяйтесь!</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru" target="_blank" style="width: 200px; height: 50px; color: #fff;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
	</div>';
}

if($lead->form == 'buybook') {
	$str = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Оформите предзаказ на книгу Александра Глушкова «Эндорфины красоты»</h3>
			<h3>Здравствуйте, '.$lead->name.'!</h3>
			<p>Вы оставляли заявку на покупку книги Александра Глушкова «Эндорфины красоты». <br>Книга поступит в продажу 20 сентября, но уже сегодня вы можете оформить предзаказ, <a href="https://www.alpinabook.ru/catalog/SuccessStory/82257/?sphrase_id=126686" target="_blank">пройдя по ссылке</a>.</p>
			<p>«Эндорфины красоты» — книга о вдохновении и творческом подходе к выбору ниши, откровенная хроника событий, 18 глав из жизни, сделавших Александра Глушкова, основателя сети салонов МОНЕ и Точка красоты, настоящим визионером.<br> Книга рекомендуется всем, кто ищет новые возможности развития своего бизнеса и готов учиться на лучших примерах из практики. Приятного чтения!
</p>
			<p style="text-align: center; font-size: 16px;"><a href="http://synergyheroes.ru" target="_blank" style="width: 200px; height: 50px; color: #fff;">>>> Перейти к регистрации <<<</a></p>
			<hr style="color: #E5E5E5;">
			<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
	</div>';
}

return $str;