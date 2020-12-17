<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>Мы&nbsp;пришлем вам подтверждение регистрации на&nbsp;указанный e-mail.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight_spb/popup-events.php';