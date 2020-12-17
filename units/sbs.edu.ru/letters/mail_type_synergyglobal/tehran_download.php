<?php
if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Hello!</h3>
	<p>You have requested for the Synergy Global Forum Tehran 2017 outline. Download the timetable <a href='{$program_file}' target='_blank'>here.</a></p>
	<p>Register now and become a&nbsp;part of&nbsp;the new business community! World-known business speakers will be&nbsp;waiting for you on&nbsp;20-21 of&nbsp;February 2017.</p>
	<p style='margin:40px 0; text-align: center;'><a href='http://synergyglobal.ru/tehran/?utm_source=tranzmail-synergyglobal' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Start registration >>></a></p>
	";
}
else {
	$body = "
	<h3>Добрый день!</h3>
	<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы главного бизнес-события года Synergy Global Forum Тегеран 2017. Скачать программу вы&nbsp;можете, <a href='{$program_file}' target='_blank'>пройдя по&nbsp;ссылке.</a></p>
	<p>Успейте зарегистрироваться на&nbsp;Synergy Global Forum Tehran 2017 и&nbsp;станьте частью нового бизнес-сообщества!</p>
	<p style='margin:40px 0; text-align: center;'><a href='http://synergyglobal.ru/tehran/ru/?utm_source=tranzmail-synergyglobal' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Перейти к&nbsp;регистрации >>></a></p>
	";
}

$letter = include 'template_tehran.php';
return $letter;