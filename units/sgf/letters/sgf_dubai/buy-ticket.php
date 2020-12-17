<?php
$body = "
<h3>{$lead->name}, поздравляем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;<a href='http://synergyglobal.ru' target='_blank'>{$lead->program}</a>. Форум состоится 11-12 декабря 2017&nbsp;года.</p>
<p>Вас ждут выступления спикеров с мировым именем, панельная дискуссия, интенсивный нетворкинг и насыщенная культурная программа. Спасибо, что решили быть с нами!</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>{$lead->name}, congratulations!</h3>
	<p>You have successfully registered to&nbsp;the <a href='http://synergyglobal.ru' target='_blank'>Synergy Global Forum Dubai 2017</a>. The Forum will be&nbsp;held 20-21 November 2017 in&nbsp;CROCUS CITY HALL.</p>
	<p>Meetings with world-famous speakers, panel discussion on&nbsp;the&nbsp;US business abilities in&nbsp;the modern world, networking and intense culture program are scheduled for you as&nbsp;well. Thank you for being with&nbsp;us!</p>
	<p>If&nbsp;you haven&rsquo;t bought a&nbsp;ticket yet, you can do&nbsp;it&nbsp;<a href='' target='_blank'>following the link</a>.</p>
	";
}

$letter = include 'template.php';
return $letter;