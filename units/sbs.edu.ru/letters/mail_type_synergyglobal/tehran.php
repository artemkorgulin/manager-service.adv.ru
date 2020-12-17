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
	if ( $payment_link ) {
		$intellectmoney_str = "<p>Оплатить билет на&nbsp;Форум в&nbsp;Тегеране вы&nbsp;можете, <a href='{$payment_link}' target='_blank'>пройдя по&nbsp;ссылке</a>.</p>";
	}

	$body = "
	<h3>{$lead->name}, поздравляем!</h3>
	<p>Вы&nbsp;зарегистрировались на&nbsp;Synergy Global Forum Тегеран. Форум состоится 20-22&nbsp;февраля 2017 года в&nbsp;столице Ирана&nbsp;&mdash; Тегеране, в&nbsp;здании Центральной Телебашни.</p>
	<p>Вас ждут выступления Аллана Пиза, Джона Шоула и&nbsp;других спикеров с&nbsp;мировым именем, а&nbsp;также интенсивный нетворкинг и&nbsp;насыщенная культурная программа.</p>
	{$intellectmoney_str}
	<p>Спасибо, что решили быть с нами!</p>
	<p><b>Держите телефон под рукой: мы&nbsp;позвоним и&nbsp;подробно расскажем вам о&nbsp;том, как забронировать билеты на&nbsp;самолет и&nbsp;оплатить ваше участие в&nbsp;Форуме.</b></p>
	";
}

$letter = include 'template_tehran.php';
return $letter;