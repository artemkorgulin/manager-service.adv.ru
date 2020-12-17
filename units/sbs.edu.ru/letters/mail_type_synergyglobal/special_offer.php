<?php
$body = '
<p>Спасибо, что остаетесь с&nbsp;Synergy Global Forum. Мы&nbsp;гордимся нашей целеустремленной аудиторией, замотивированной на&nbsp;успех. Чтобы еще больше вдохновить вас на&nbsp;движение вперед, мы&nbsp;делимся с&nbsp;вами гигабайтами полезной информации с&nbsp;SGF2015. Смотрите выступления лучших мировых спикеров, фиксируйте ключевые мысли и&nbsp;инсайты.</p>
<p>До&nbsp;встречи на&nbsp;SGF2016!</p>
';

$str_soon = "До встречи!";
$str_sbs_1 = "Команда";
$str_sbs_2 = "Школы Бизнеса «Синергия»";
$str_phone = "тел. ";

if ( $_REQUEST['lang'] == 'en' ) {
	$str_soon = "See you soon!";
	$str_sbs_1 = "";
	$str_sbs_2 = "Synergy business school team";
	$str_phone = "phone ";
}

$str = "
<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
	<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
		<a href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt='' width='174' height='54'></a>
	</div>
	<div style='margin: 0 auto; width: 560px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
		{$body}
		<hr style='color: #E5E5E5;'>
		<p style='color:#505050;'><i>{$str_soon} <br>{$str_sbs_1} <a target='_blank' style='color:#505050;' href='http://sbs.edu.ru?utm_source=tranzmail-synergyglobal'>{$str_sbs_2}</a><br>
			<a target='_blank' style='color:#505050;' href='http://www.sbs.edu.ru'>www.sbs.edu.ru</a> <br>
			{$str_phone} {$partner_phone}
		</i></p>
	</div>
	<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
";

return $str;
