<?php
$body = "
<h3>{$lead->name}, поздравляем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;главное бизнес-событие года Synergy Global Forum. Форум состоится 21-22 ноября 2016 года в&nbsp;CROCUS CITY HALL (г. Москва).</p>
<p>Здесь вы&nbsp;найдете 6000&nbsp;единомышленников, среди которых CEO ведущих брендов, руководители и&nbsp;собственники бизнеса из&nbsp;России, Казахстана, Украины, Беларуси, Германии, Польши, Прибалтики, Финляндии и&nbsp;других стран.</p>
<p>Присоединяйтесь к&nbsp;нам, окунитесь в&nbsp;мощную рабочую атмосферу форума и&nbsp;воспользуйтесь уникальными возможностями международного нетворкинга. Живое общение со&nbsp;спикерами и&nbsp;успешными предпринимателями, высочайший уровень сервиса, лучшие условия для поиска деловых партнеров и&nbsp;масштабирования бизнеса&nbsp;&mdash; все это ждет вас 21-22&nbsp;ноября.</p>
<p style=\"margin:40px 0; text-align: center;\"><a href=\"{$partner_program_file}\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Скачать программу форума >>></a></p>
<p>Спасибо, что решили быть с нами!</p>
<p><b>Держите телефон под рукой: мы&nbsp;позвоним, чтобы уточнить условия участия и&nbsp;подтвердить ваши регистрационные данные.</b></p>
";

/* Для http://synergyglobal.ru/en/ */
if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Dear {$lead->name} <br>Congratulations!</h3>
	<p>You have successfully registered for the main business event of&nbsp;the year Synergy Global Forum. The Forum is&nbsp;due to&nbsp;take place on&nbsp;21-22 of&nbsp;November in&nbsp;Crocus City Hall, Moscow.</p>
	<p>There you will meet 6000 like-minded individuals, amongst whom are CEOs of&nbsp;leading brands, managers and business entrepreneurs from Russia, Kazakhstan, Ukraine, Belarus, Germany, Poland, the Baltic states, Finland and other countries.</p>
	<p>Join&nbsp;us, immerse yourself in&nbsp;the Forum&rsquo;s intense working atmosphere and discover unique possibilities of&nbsp;international networking. At&nbsp;the Forum you will experience live interactions with speakers and successful entrepreneurs, top grade service and a&nbsp;fantastic opportunity for making new business contacts, all this and more awaits you on&nbsp;21-22 of&nbsp;November.</p>
	<p style=\"margin:40px 0; text-align: center;\"><a href=\"{$partner_program_file}\" style=\"border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;\" target=\"_blank\">Download the Forum&rsquo;s schedule &gt;&gt;&gt;</a></p>
	<p>Thank you for choosing&nbsp;us.</p>
	<p><b>Please stand&nbsp;by, we&nbsp;will phone you shortly to&nbsp;confirm terms of&nbsp;participation and registration details.</b></p>
	";
}

/* Для ленда http://www.synergyglobal.ru/videorecording/ */
if(isset($_REQUEST['land']) && $_REQUEST['land'] == 'videorecording-sglobal') {
	$body = "
	<h3>Здравствуйте!</h3>
	<p>Вы&nbsp;оставили заявку на&nbsp;доступ ко&nbsp;всем видеозаписям SYNERGY GLOBAL FORUM&nbsp;2015.</p>
	<p>Чтобы получить видеозаписи, оплатите доступ банковской картой или&nbsp;электронными деньгами. Стоимость 18&nbsp;часов уникального видеоконтента составит {$lead->cost}&nbsp;рублей.</p>
	<p>Онлайн-платежи защищены, а&nbsp;процесс оплаты займет не&nbsp;более 2&nbsp;минут. Мы&nbsp;используем сервис IntellectMoney. Переходя по&nbsp;ссылке онлайн-оплаты, вы&nbsp;соглашаетесь с&nbsp;публичной офертой.</p>
	<p><a href='$lead->link' target='_blank'>Перейти к&nbsp;оплате</a></p>
	<p>После подтверждения платежа мы&nbsp;вышлем ссылку на&nbsp;личный кабинет, индивидуальный логин и&nbsp;пароль для&nbsp;просмотра.</p>
	<br>
	<p>До встречи!</p>
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

/*	(цены действительны до&nbsp;{$lead->dater})*/
