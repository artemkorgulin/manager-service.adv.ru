<?php
/* https://sd.synergy.ru/Task/View/101729 */
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо за&nbsp;вашу заявку!</h3>
	<p>Программа форума направлена на&nbsp;указанный электронный адрес.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Программа форума SIF 2018";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/popup-program.php';