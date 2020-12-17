<?php
$body = "
<h3>Добрый день!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы Synergy Global Forum New York 2017. Скачать программу вы&nbsp;можете, <a href='{$program_file}' target='_blank'>пройдя по&nbsp;ссылке.</a></p>
<p>Успейте зарегистрироваться на&nbsp;Synergy Global Forum New York 2017 и&nbsp;станьте частью нового бизнес-сообщества!</p>
<p><a href='http://synergyglobal.ru/newyork/ru/' target='_blank'>Перейти к&nbsp;регистрации >>></a></p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Hello!</h3>
	<p>Thanks for requesting the program for the 2017 Synergy Global Forum in&nbsp;New York.</p>
	<p>You can download the program <a href='{$program_file}' target='_blank'>here</a>.<br>If&nbsp;you like what you see, check the ticket availability and become a&nbsp;part of&nbsp;this incredible event!</p>
	<p><a href='http://synergyglobal.com/?click={a[href=%22%23compare-packages%22]}' target='_blank'>Find out more >>></a></p>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>Buenas tardes:</h3>
	<p>Usted ha&nbsp;enviado una solicitud del programa de&nbsp;Synergy Global Forum New York 2017. Puede descargar el&nbsp;programa <a href='{$program_file}' target='_blank'>pulsando el&nbsp;enlace</a>.</p>
	<p>Apres&uacute;rese para registrarse en&nbsp;Synergy Global Forum New York 2017&nbsp;y forme parte de&nbsp;una nueva comunidad empresarial.</p>
	<p><a href='http://sgf2017.com/es/' target='_blank'>Pasar al&nbsp;registro >>></a></p>
	";
}

$letter = include 'template.php';
return $letter;