<?php
/* https://sd.synergy.ru/Task/View/87811 */
$body = "
<h3>Здравствуйте, {$lead->name}</h3>
<p>Вы&nbsp;оставили заявку на&nbsp;корпоративное участие в&nbsp;Synergy Global Forum. Держите телефон под рукой: наш менеджер свяжется с&nbsp;Вами, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.</p>
<p>На&nbsp;Synergy Global Forum вы&nbsp;найдете 6000&nbsp;единомышленников, среди которых CEO ведущих брендов, руководители и&nbsp;собственники бизнеса из&nbsp;России, Казахстана, Украины, Беларуси, Германии, Польши, Прибалтики, Финляндии и&nbsp;других стран.</p>
<p>Присоединяйтесь к&nbsp;нам, окунитесь в&nbsp;мощную рабочую атмосферу форума и&nbsp;воспользуйтесь уникальными возможностями международного нетворкинга. Живое общение со&nbsp;спикерами и&nbsp;успешными предпринимателями, высочайший уровень сервиса, лучшие условия для поиска деловых партнеров и&nbsp;масштабирования бизнеса&nbsp;&mdash; все это ждет вас 21-22 ноября в&nbsp;Crocus City Hall.</p>
<p style=\"margin:40px 0; text-align: center;\"><a href=\"{$partner_program_file}\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Скачать программу форума >>></a></p>
<p>Спасибо, что решили быть с&nbsp;нами!</p>
";

/* Для http://synergyglobal.ru/en/ */
if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Dear {$lead->name}</h3>
	<p>Your request for corporate participation at&nbsp;Synergy Global Forum is&nbsp;successfully received. Please stand&nbsp;by, we&nbsp;will call you as&nbsp;soon as&nbsp;possible to&nbsp;confirm terms of&nbsp;participation and registration details.</p>
	<p>There you will meet 6000 like-minded individuals, amongst whom are CEOs of&nbsp;leading brands, managers and business entrepreneurs from Russia, Kazakhstan, Ukraine, Belarus, Germany, Poland, the Baltic states, Finland and other countries.</p>
	<p>Join&nbsp;us, immerse yourself in&nbsp;the Forum&rsquo;s intense working atmosphere and discover unique possibilities of&nbsp;international networking. At&nbsp;the Forum you will experience live interactions with speakers and successful entrepreneurs, top grade service and a&nbsp;fantastic opportunity for making new business contacts, all this and more awaits you on&nbsp;21-22 of&nbsp;November.</p>
	<p style=\"margin:40px 0; text-align: center;\"><a href=\"{$partner_program_file}\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Download the Forum&rsquo;s schedule >>></a></p>
	<p>Thank you for choosing&nbsp;us.</p>
	";
}

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
