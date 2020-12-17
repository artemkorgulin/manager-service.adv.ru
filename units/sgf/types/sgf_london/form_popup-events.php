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
			Thank you!<br>
			Your application has been submitted! Check your e-mail for confirmation of&nbsp;registration to&nbsp;the {$lead->program}.
		</p>
	</div>
	";

	$config['mail']['smtp']['user']['subject'] = "Your Registration to the {$lead->program}";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_london/popup-events.php';