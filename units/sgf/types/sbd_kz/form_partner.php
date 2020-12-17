<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!
		Мы&nbsp;свяжемся с&nbsp;вами в&nbsp;ближайшее время, чтобы обсудить возможности нашего сотрудничества.
	</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Партнеру Synergy Business Day 2018 в Алматы";

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sbd_kz/partner.php';
