<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p class="text-center">
		Спасибо, ваша заявка отправлена!
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p class="text-center">
			Thank you! Your application has been submitted.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;