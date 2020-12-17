<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;вашу заявку!<br>
		Программа форума направлена на&nbsp;ваш электронный адрес.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Программа Synergy Global Forum 2017 в Алматы";

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_kz/program.php';
