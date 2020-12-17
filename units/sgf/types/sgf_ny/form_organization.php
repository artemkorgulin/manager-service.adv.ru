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
			Your request has been received. One of&nbsp;our travel consultants will call you shortly to&nbsp;discuss your travel arrangements.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias!<br>
			Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Mantenga su&nbsp;tel&eacute;fono al&nbsp;alcance de&nbsp;la&nbsp;mano&nbsp;&mdash; le&nbsp;llamaremos para informar en&nbsp;detalle sobre los tr&aacute;mites del viaje.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;