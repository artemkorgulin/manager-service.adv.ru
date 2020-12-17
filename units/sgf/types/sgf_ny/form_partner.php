<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!
		Мы&nbsp;свяжемся с&nbsp;вами в&nbsp;ближайшее время, чтобы обсудить возможности нашего сотрудничества.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application has been submitted! We&rsquo;ll contact you soon to&nbsp;discuss the cooperation.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias! Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Nos pondremos en&nbsp;contacto con Usted para estudiar nuestras posibilidades de&nbsp;colaboraci&oacute;n.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;