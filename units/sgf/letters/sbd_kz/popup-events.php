<?php
$body = "
<h3>{$lead->name}, здравствуйте!</h3>
<p>Вы&nbsp;зарегистрировались&nbsp;на {$lead->program}</p>
<p>В&nbsp;настоящее время мы&nbsp;формируем панель спикеров и&nbsp;программу мероприятия.</p>
<p>Ждите следующего письма, чтобы узнать больше о&nbsp;предстоящем Synergy Global Forum.</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>{$lead->name}, hello!</h3>
	<p>You&rsquo;ve been registered to&nbsp;the {$lead->program}.</p>
	<p>Currently we&rsquo;re working on&nbsp;a&nbsp;panel of&nbsp;speakers and the event agenda.</p>
	<p>Please, wait for the next letter to&nbsp;get more details on&nbsp;the Synergy Global Forum.</p>
	";
}

$letter = include 'template.php';
return $letter;