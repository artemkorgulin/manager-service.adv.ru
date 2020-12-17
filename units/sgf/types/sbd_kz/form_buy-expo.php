<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;нее подтверждение вашей регистрации на&nbsp;форум. В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами, расскажем о&nbsp;специальных возможностях продвижения бизнеса на&nbsp;форуме и&nbsp;выставим счет на&nbsp;оплату.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Размещение стенда на Synergy Business Day 2018 в Алматы";

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sbd_kz/buy-expo.php';
