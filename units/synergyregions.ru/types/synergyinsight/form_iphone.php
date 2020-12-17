<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Подробности о&nbsp;работе приложения <br>и&nbsp;возможностях его установки <br>мы&nbsp;отправили на&nbsp;Ваш e-mail.</p>
</div>';

$config['mail']['smtp']['user']['subject'] = "Приложение Synergy Friends";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/iphone.php';