<?php
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;нее подтверждение вашей регистрации на&nbsp;{$lead->program}
	</p>
</div>
";

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на {$lead->program}";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>
			Your request has been sent!<br>
			We&rsquo;ll follow up&nbsp;by&nbsp;email with details of&nbsp;how to&nbsp;complete your registration (if&nbsp;you don&rsquo;t see the email, check your junk folder).
		</p>
	</div>
	";

	$config['mail']['smtp']['user']['subject'] = "{$lead->program} – Thanks for your interest";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>
			&iexcl;Gracias! Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Consulte su&nbsp;email, hemos enviado a&nbsp;su&nbsp;correo la&nbsp;confirmaci&oacute;n de&nbsp;registro en&nbsp;{$lead->program}.
		</p>
	</div>
	";

	$config['mail']['smtp']['user']['subject'] = "Su registro en el {$lead->program}";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/popup-events.php';