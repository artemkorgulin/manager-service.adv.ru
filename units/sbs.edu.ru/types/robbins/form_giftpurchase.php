<?php
$config['ignore']['bitrix24'] = false;
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Главный урок курса Ицхака Пинтосевича «Новый Я»";
$config['mail']['smtp']['user']['message'] = '<p>Здравствуйте, ' . $lead->name . '</p>
<p>Вот ваша ссылка на Главный урок курса Ицхака Пинтосевича «Новый Я» http://www.info.sbs.edu.ru/landing/bonusnewme</p>
<br>
<br>
<p>С уважением,<br>
Школа Бизнеса | Университет Синергия</p>';

$config['user']['sendsuccess'] = "1";
?>