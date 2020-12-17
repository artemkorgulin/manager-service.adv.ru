<?php
$config['newsletter']['getresponse']['campaign'] = 'e_mail_digest_sgf';

$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Ваша заявка принята!<br>
		Каждую пятницу вы&nbsp;будете получать эксклюзивное видео выступлений ключевых спикеров прошлых форумов. Следите за&nbsp;нашими рассылками!
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
}

$config['ignore']['send_to_user'] = false;