<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		Держите телефон под рукой&nbsp;&mdash; мы&nbsp;позвоним вам и&nbsp;подробно проконсультируем по&nbsp;вопросам организации поездки.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application was successful. Keep your phone at&nbsp;hand&nbsp;&mdash; we&rsquo;ll call you to&nbsp;advise in&nbsp;detail on&nbsp;travel arrangements.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;