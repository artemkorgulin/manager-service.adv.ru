<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;заявку!<br>
		<a href="'.$program_file.'" target="_blank" style="text-decoration: underline;">Перейдите по&nbsp;ссылке</a>, чтобы скачать программу Форума.
	</p>
</div>
';

$config['ignore']['send_to_user'] = false;


$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum Москва 2017";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you for your application!<br>
			The forum program has been directed to&nbsp;your email address.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "The program of Synergy Global Forum Москва 2017";
	$config['ignore']['send_to_user'] = true;
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/program.php';
