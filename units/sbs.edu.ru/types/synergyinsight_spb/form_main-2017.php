<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Вы успешно совершили предзаказ. <br>
		На&nbsp;Ваш e-mail отправлено письмо с&nbsp;подтверждением.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Ваш предзаказ билетов на Synergy Insight Forum 2017";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR. '/letters/mail_synergyinsight_spb/forum_2017.php';