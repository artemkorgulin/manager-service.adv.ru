<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;вашу заявку!<br>
		Программа форума направлена на&nbsp;ваш электронный адрес.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Программа Synergy Business Day 2018 в Алматы";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sbd_kz/program-bd.php';