<?php
$body = "
<h3>{$lead->name}, здравствуйте!</h3>
<p>Вы&nbsp;зарегистрировались&nbsp;на {$lead->program}</p>
<p>В&nbsp;настоящее время мы&nbsp;формируем панель спикеров и&nbsp;программу мероприятия.</p>
<p>Ждите следующего письма, чтобы узнать больше о&nbsp;предстоящем Synergy Global Forum.</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Dear {$lead->name},</h3>
	<p>Thank you for your interest in&nbsp;{$lead->program}!</p>
	<p>We&rsquo;re currently putting together a&nbsp;program for the event, and assembling an&nbsp;extraordinary group of&nbsp;speakers.</p>
	<p>We&rsquo;ll be&nbsp;in&nbsp;touch with more details about who&rsquo;s speaking, as&nbsp;well as&nbsp;details about purchasing tickets. From time to&nbsp;time we&rsquo;ll share some great content from previous Forum events, to&nbsp;give you a&nbsp;taste of&nbsp;what to&nbsp;expect.</p>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>¡{$lead->name}, buenas tardes!</h3>
	<p>Se&nbsp;ha&nbsp;registrado en&nbsp;el&nbsp;{$lead->program}.</p>
	<p>De&nbsp;momento estamos elaborando la&nbsp;lista de&nbsp;ponentes y&nbsp;el&nbsp;programa del F&oacute;rum. </p>
	Espere al&nbsp;siguiente correo para saber m&aacute;s sobre la&nbsp;pr&oacute;xima edici&oacute;n de&nbsp;Synergy Global <p>Forum.</p>
	";
}

$letter = include 'template.php';
return $letter;