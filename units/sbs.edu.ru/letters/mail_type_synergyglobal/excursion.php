<?php

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>{$lead->name}, congratulations!</h3>
	<p>You have registered to the main business-event of the year Synergy Global Forum Tehran. The Forum will take place 20-21 February 2017 in Milad Tehran Tower (Tehran, Iran).</p>
	<p>You will meet 2000 associates, among whom there are CEO of the leading brands, businessmen and politicians form Russia and countries of the Near East. Join us, wallow in the strong work atmosphere of the forum and use unique opportunities of international networking. Live communication, highest service level, best conditions for search of business partners and scaling business on the international level – all this will wait for you 20-21 February.</p>
	<p>Thank you that you have decided to be with us!</p>
	<p><b>We will call you back in order to clarify participation conditions, confirm your registration data and book a ticket.</b></p>
	";
}
else {

	$body = "
	<h3>{$lead->name}!</h3>
	<p>Вы успешно зарегистрировались на участие в культурной программе форума. Вас ждет поездка в старинный город Исфахан и вдохновение культурой Ближнего Востока. В ближайшее время с вами свяжется наш специалист, чтобы обсудить детали поездки.</p>";
}

$letter = include 'template_tehran.php';
return $letter;