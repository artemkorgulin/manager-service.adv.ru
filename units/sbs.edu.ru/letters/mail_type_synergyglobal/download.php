<?php
$body = "
<h3>Добрый день!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы главного бизнес-события года Synergy Global Forum 2016. Скачать программу вы&nbsp;можете, <a href=\"{$partner_program_file}\" target=\"_blank\">пройдя по&nbsp;ссылке.</a></p>
<p>Успейте зарегистрироваться на&nbsp;Synergy Global Forum 2016 и&nbsp;станьте частью нового бизнес-сообщества! 21-22 ноября в&nbsp;Crocus City Hall вас ждут выступления Леонида Парфенова, Гая Кавасаки, Кьелла Нордстрема и&nbsp;других ведущих спикеров.</p>
<p style=\"margin:40px 0; text-align: center;\"><a href=\"http://synergyglobal.ru?utm_source=tranzmail-synergyglobal\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Перейти к&nbsp;регистрации >>></a></p>
";

$str_soon = "До встречи!";
$str_sbs_1 = "Команда";
$str_sbs_2 = "Школы Бизнеса «Синергия»";
$str_phone = "тел. ";


/* Для http://synergyglobal.ru/en/ */
if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Hello!</h3>
	<p>You have requested for the Synergy Global Forum 2016 outline. Download the timetable <a href=\"{$partner_program_file}\" target=\"_blank\">here.</a></p>
	<p>Register now and become a&nbsp;part of&nbsp;the new business community! Leonid Parfyonov, Guy Kawasaki, Kjell Nordstrom and other world-known business speakers will be&nbsp;waiting for you on&nbsp;21-22 of&nbsp;November in&nbsp;Crocus City Hall.</p>
	<p style=\"margin:40px 0; text-align: center;\"><a href=\"http://synergyglobal.ru/en/?utm_source=tranzmail-synergyglobal\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Start registration >>></a></p>
	";

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

/*	(цены действительны до&nbsp;{$lead->dater})*/
