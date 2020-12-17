<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		В&nbsp;ближайшее время мы&nbsp;пришлем вам ссылку на&nbsp;просмотр видео.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Смотрите лучшие фрагменты видео выступления спикеров СГФ 2016";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['mail']['smtp']['user']['subject'] = "Watch some of the most unforgettable moments from presentations at the Forum in 2016";

	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thanks!<br>
			We&rsquo;ll email you a&nbsp;link to&nbsp;the video shortly.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias! Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. En&nbsp;los pr&oacute;ximos d&iacute;as pondremos a&nbsp;su&nbsp;disposici&oacute;n un&nbsp;enlace para ver el&nbsp;v&iacute;deo.
		</p>
	</div>
	';
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/popup-full-video.php';
