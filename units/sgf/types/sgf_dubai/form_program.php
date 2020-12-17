<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;вашу заявку!<br>
		Программа форума направлена на&nbsp;ваш электронный адрес.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum Дубай 2017";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you for your application!<br>
			The forum program has been directed to&nbsp;your email address.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "The program of Synergy Global Forum Dubai 2018";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_dubai/program.php';
