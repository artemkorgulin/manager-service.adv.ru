<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;нее подтверждение вашей регистрации на&nbsp;вебинар.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Вы зарегистрированы на вебинар «{$lead->speaker}: {$lead->program}»";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			You&rsquo;re registered for the webinar. We&rsquo;ve sent a&nbsp;confirmation to&nbsp;the email address you provided.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Registration for webinar with {$lead->speaker}";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			¡Gracias!<br>
			Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Consulte su&nbsp;email, hemos enviado a&nbsp;su&nbsp;correo la&nbsp;confirmaci&oacute;n de&nbsp;su&nbsp;registro en&nbsp;el&nbsp;webinar.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Registro en el webinar: {$lead->speaker} «{$lead->program}»";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/popup-webinars.php';

$config['newsletter']['getresponse']['campaign'] = 'webinarny';
