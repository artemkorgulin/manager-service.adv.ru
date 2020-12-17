<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Your request has been sent!
		Мы&nbsp;обязательно учтем ваше мнение при формировании панели спикеров. Следите за&nbsp;нашими рассылками&nbsp;&mdash; мы&nbsp;будем оповещать о&nbsp;появлении новых спикеров.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Your request has been sent!
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;