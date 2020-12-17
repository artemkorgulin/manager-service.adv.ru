<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>Мы&nbsp;пришлем вам ссылку на&nbsp;видеозапись вебинара в&nbsp;ближайшее время.</p>
</div>
';

if ( $lead->link == '' ) {
	$config['ignore']['send_to_user'] = false;
}

$config['mail']['smtp']['user']['subject'] = "Ссылка на видеозапись вебинара «{$lead->speaker}: {$lead->program}»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight_spb/popup-get-video.php';