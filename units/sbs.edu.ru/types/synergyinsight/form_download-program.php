<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Предварительную информацию о&nbsp;программе Форума мы&nbsp;выслали на&nbsp;Ваш e-mail.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Программа форума SIF 2018";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/download-program.php';