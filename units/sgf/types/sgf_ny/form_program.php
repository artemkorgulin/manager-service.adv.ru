<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо за&nbsp;вашу заявку!<br>
		Программа форума направлена на&nbsp;ваш электронный адрес.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Ваша программа Synergy Global Forum New York 2017";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thanks!<br>
			Check your email for your copy of&nbsp;the Forum program.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Your Synergy Global Forum Program";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias por su&nbsp;solicitud!<br>
			El&nbsp;programa del F&oacute;rum se&nbsp;ha&nbsp;enviado a&nbsp;su&nbsp;correo electr&oacute;nico.
		</p>
	</div>
	';

	$config['mail']['smtp']['user']['subject'] = "Programa de Synergy Global Forum New York 2017";
}


$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/program.php';
