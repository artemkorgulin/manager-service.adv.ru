<?php
$body = "
<h3>{$lead->name}, поздравляем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;<a href='http://sgf2017.com' target='_blank'>Synergy Global Forum New York 2017</a>. Форум состоится 27-28 октября 2017 года<!-- в&nbsp;Madison Square Theater-->.</p>
<p>Вас ждут выступления спикеров с&nbsp;мировым именем, панельная дискуссия о&nbsp;бизнес-возможностях в&nbsp;США, интенсивный нетворкинг и&nbsp;насыщенная культурная программа. Спасибо, что решили быть с&nbsp;нами!</p>
<p>Если вы&nbsp;еще не&nbsp;оплатили билет, вы&nbsp;можете сделать это, <a href='' target='_blank'>пройдя по&nbsp;ссылке</a>.</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Dear {$lead->name},</h3>
	<p>Thank you for your interest in&nbsp;Synergy Global Forum New York 2017, on&nbsp;October 27-28, 2017, in&nbsp;the Theater at&nbsp;Madison Square Garden.</p>
	<p>The Forum is&nbsp;a&nbsp;once-in-a-lifetime opportunity to&nbsp;see world-renowned speakers and lively panel discussions, network with business leaders, and enjoy the cultural riches of&nbsp;New York City.</p>
	<p>We&rsquo;ll call you to&nbsp;explain how to&nbsp;purchase your tickets and secure your place at&nbsp;the Forum. And if&nbsp;you need any assistance with travel plans, we&rsquo;d be&nbsp;happy to&nbsp;help.</p>
	<p>Ticket numbers are limited and prices will rise, so&nbsp;don&rsquo;t wait to&nbsp;complete your registration!</p>
	<p>Looking forward to&nbsp;speaking soon.</p>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>¡{$lead->name}, felicidades!</h3>
	<p>Se&nbsp;ha&nbsp;registrado en&nbsp;<a href='http://sgf2017.com' target='_blank'>Synergy Global Forum New York 2017</a>. El&nbsp;F&oacute;rum se&nbsp;celebrar&aacute; el&nbsp;27-28&nbsp;de octubre de&nbsp;2017&nbsp;en Madison Square Theater.</p>
	<p>Le&nbsp;esperan discursos de&nbsp;ponentes mundialmente conocidos, un&nbsp;panel de&nbsp;discusi&oacute;n sobre oportunidades empresariales de&nbsp;los EEUU, un&nbsp;intensivo networking y&nbsp;un&nbsp;denso programa cultural. &iexcl;Gracias por su&nbsp;decisi&oacute;n de&nbsp;estar con nosotros!</p>
	<p>Si&nbsp;no&nbsp;ha&nbsp;pagado su&nbsp;billete todav&iacute;a, puede hacerlo pulsando el&nbsp;enlace.</p>
	";
}

$letter = include 'template.php';
return $letter;