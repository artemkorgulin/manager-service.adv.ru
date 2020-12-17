<?php
$body = '
<h3>Добрый день!</h3>
<p>Приглашаем Вас к&nbsp;сотрудничеству в&nbsp;рамках главного бизнес-события 2016&nbsp;года. 21-22 ноября 2016 года мы&nbsp;организуем SYNERGY GLOBAL FORUM и&nbsp;будем рады видеть Вас в&nbsp;качестве надежного партнера.</p>
<p>Мы&nbsp;аккумулировали опыт лучших конференций мира, чтобы регулярно проводить в&nbsp;Москве бизнес-форумы международного значения. В&nbsp;2015 году состоялся первый SYNERGY GLOBAL FORUM, где собралось 6000&nbsp;участников, чтобы увидеть на&nbsp;одной сцене лучших бизнес-спикеров планеты. 23-24 апреля 2016 года мы&nbsp;так&nbsp;же провели второе наше мероприятие на&nbsp;2000 человек <a href="http://synergyinsight.ru" target="_blank">SYNERGY INSIGHT FORUM</a></p>
<p>21-22 ноября 2016 года на&nbsp;SYNERGY GLOBAL FORUM мы&nbsp;вновь соберем 6000 топ-менеджеров и&nbsp;владельцев бизнеса. Форум проходит в&nbsp;интенсивном формате TED. Участников ждут выступления от&nbsp;ведущих мировых спикеров и&nbsp;панельная дискуссия с&nbsp;бизнес-экспатами&nbsp;&mdash; иностранцами, которые развивают свой бизнес в&nbsp;России.</p>
<p>Спикеры SGF 2016&nbsp;&mdash; Гай Кавасаки, Дэвид Аллен, Кьелл Нордстрем, его святейшество Далай-Лама (онлайн-трансляция), Бодо Шефер, Игорь Манн, Леонид Парфенов, Глеб Архангельский и&nbsp;Радислав Гандапас. Каждый спикер готовит абсолютно новый контент, который не&nbsp;публиковался ранее. В&nbsp;зале&nbsp;&mdash; владельцы успешных бизнесов, главы крупнейших компаний, активные и&nbsp;открытые для нетворкинга представители бизнес-сообщества России и&nbsp;СНГ.<br>Подробнее о&nbsp;SYNERGY GLOBAL FORUM читайте на&nbsp;официальном сайте события: <a href="http://synergyglobal.ru" target="_blank">http://synergyglobal.ru</a></p>
<p>Предлагаем Вам воспользоваться нашей партнерской поддержкой. Держите телефон под рукой: наш менеджер свяжется с&nbsp;Вами, чтобы обсудить возможности партнерства.</p>
';

if ( $_REQUEST['land'] == 'tehran-sglobal' ) {
	$body = "
	<h3>{$lead->name}, congratulations!</h3>
	<p>Thank you for your interest in&nbsp;partnership/sponsorship of&nbsp;the main business-event of&nbsp;the year Synergy Global Forum Tehran. The Forum will take place 19&nbsp;December 2016 in&nbsp;Milad Tehran Tower (Tehran, Iran).</p>
	<p>You will meet 2000&nbsp;associates, among whom there are CEO of&nbsp;the leading brands, businessmen and politicians form Russia and countries of&nbsp;the Near East. Join&nbsp;us, wallow in&nbsp;the strong work atmosphere of&nbsp;the forum and use unique opportunities of&nbsp;international networking. Live communication, highest service level, best conditions for search of&nbsp;business partners and scaling business on&nbsp;the international level&nbsp;&mdash; all this will wait for you 19&nbsp;December.</p>
	<p>Thank you that you have decided to&nbsp;be&nbsp;with&nbsp;us! <br>We&nbsp;will call you back in&nbsp;order to&nbsp;clarify your partnership/sponsorship opportunities.</p>
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
