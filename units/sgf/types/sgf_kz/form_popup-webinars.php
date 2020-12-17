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
			Your application was successfully submitted. Check your email: we&nbsp;have send you the confirmation of&nbsp;registration for the webinar.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Registation for the webinar: {$lead->speaker} “{$lead->program}”";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_kz/popup-webinars.php';

$config['newsletter']['getresponse']['campaign'] = 'webinarny';
