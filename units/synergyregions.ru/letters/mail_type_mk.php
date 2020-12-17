<?php
$text_speaker = "<p>Мастер-класс <b>«{$lead->program}»</b> ведет эксперт <b>{$lead->speaker}</b>.</p>";
$button = "<p style=\"margin:40px 0; text-align: center;\"><a href=\"{$lead->link}\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Смотреть мастер-класс »</a></p>";

/* http://sbs.edu.ru/lp/kravtsov/mk-v1/ : https://sd.synergy.ru/Task/View/84029 */
if ( $lead->land == 'lp_kravtsov_mk-v1' ) {
	$text_speaker = "Мастер-класс &laquo;Правила долгого успеха&raquo; ведет наш эксперт, создатель бренда &laquo;Экспедиция&raquo; Александр Кравцов. Запись мастер-класса будет доступна к&nbsp;просмотру <b>только 2&nbsp;октября</b>.";
}
else if($lead->land == 'programms_master-class_moskva_upravlenie-personalom-v-usloviyax-novoj-normalnosti'){
	$text_speaker = "Мастер-класс &laquo;Управление персоналом в&nbsp;условиях &laquo;новой нормальности&raquo; ведет эксперт Евгений Доценко. Мы&nbsp;пришлем вам мастер-класс 9&nbsp;декабря&nbsp;&mdash; не&nbsp;пропускайте наши рассылки.";
	$button = "";
}


$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergyregions.ru/?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Благодарим вас за&nbsp;интерес к&nbsp;мастер-классам Школы Бизнеса &laquo;Синергия&raquo;. Мы&nbsp;регулярно проводим бесплатные <a style="color:#003677;" href='http://synergyregions.ru/webinars?utm_source=tranzmail-mk' title="Посмотреть расписание вебинаров">вебинары</a>, а&nbsp;также открытые <a style="color:#003677;" href='http://synergyregions.ru/timetable/?utm_source=tranzmail-mk' title="Посмотреть расписание семинаров и тренингов">семинары и&nbsp;тренинги</a> ведущих бизнес-спикеров. Часть программ проходит в&nbsp;онлайн-формате.</p>
		{$text_speaker}
		{$button}
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru/?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;