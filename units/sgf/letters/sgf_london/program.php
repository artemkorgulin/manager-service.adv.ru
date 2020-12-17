<?php
$body = "
<h3>Добрый день!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;получение программы {$lead->program}. Скачать программу вы&nbsp;можете, <a href='{$program_file}' target='_blank'>пройдя по&nbsp;ссылке.</a></p>
<p>Успейте зарегистрироваться на&nbsp;{$lead->program} и&nbsp;станьте частью нового бизнес-сообщества!</p>
<p><a href='http://synergyglobal.ru' target='_blank'>Перейти к&nbsp;регистрации >>></a></p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Hello!</h3>
	<p>You have left a&nbsp;request to&nbsp;get the Synergy Global Forum London 2018&nbsp;program. You can download the program <a href='{$program_file}' target='_blank'>by&nbsp;clicking on&nbsp;the link.</a></p>
	<p>Have time to&nbsp;register for Synergy Global Forum London 2018 and become part of&nbsp;a&nbsp;new business community!</p>
	<p><a href='http://synergyglobal.ru' target='_blank'>Go&nbsp;to&nbsp;the registration >>></a></p>
	";
}

$letter = include 'template.php';
return $letter;