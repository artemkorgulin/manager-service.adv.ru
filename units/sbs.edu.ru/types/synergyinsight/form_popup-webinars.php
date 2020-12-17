<?php
/* https://sd.synergy.ru/Task/View/103765 */
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>Мы&nbsp;пришлем вам подтверждение регистрации на&nbsp;указанный e-mail.</p>
</div>
';

if ( $lead->link == '' ) {
	$config['ignore']['send_to_user'] = false;
}

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на вебинар: {$lead->speaker}, {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/popup-webinars.php';