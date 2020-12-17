<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		В&nbsp;ближайшее время мы&nbsp;пришлем вам ссылку на&nbsp;просмотр видео.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Смотрите лучшие фрагменты видео {$lead->speaker} на СГФ2016";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application has been submitted! We&rsquo;ll send you link to&nbsp;the video soon.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_dubai/popup-full-video.php';
