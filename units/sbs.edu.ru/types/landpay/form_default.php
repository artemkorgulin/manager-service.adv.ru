<?php

// Конфигуратор FormMessages
$config['ignore']['bitrix24'] = false;
$config['ignore']['getresponse'] = false;
$config['ignore']['send_to_user'] = true;

if($_REQUEST['land'] == 'synergyzavod'){
	$config['mail']['smtp']['user']['subject'] = "БИЗНЕС-ЗАВОД | Успешная оплата";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_zavodPay.php';
}
