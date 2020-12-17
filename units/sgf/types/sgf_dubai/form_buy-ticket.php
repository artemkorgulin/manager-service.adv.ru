<?php
/*
$config['user']['sendsuccess'] = $default_sendsuccess . "<p><a href='' target='_blank'>Перейти к&nbsp;заказу билетов</a></p>";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = $default_sendsuccess . "<p><a href='' target='_blank'>Switch to&nbsp;order tickets</a></p>";
}
*/

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<p>
		Спасибо! Ваша заявка отправлена. <br>
		В&nbsp;ближайшее время с&nbsp;вами свяжется наш менеджер и&nbsp;расскажет, как приобрести билет интересующей вас категории.
	</p>
</div>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>
			Thank you! Your request has been sent successfully.<br>
			We&nbsp;will call you back soon and tell how to&nbsp;purhcase the ticket.
		</p>
	</div>
	";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_dubai/buy-ticket.php';

$config['ignore']['send_to_user'] = false;