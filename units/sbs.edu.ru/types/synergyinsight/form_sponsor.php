<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Спасибо за&nbsp;вашу заявку, мы&nbsp;свяжемся с&nbsp;вами в&nbsp;ближайшее время, чтобы обсудить возможности сотрудничества.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Спонсору Synergy Insight Forum 2018";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/sponsor.php';