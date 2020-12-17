<?php

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Добро пожаловать в Synergy Future!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_synergyfuture-master.php';

$config['user']['sendsuccess'] = "
<div class='send-success'>
<h3>Заявка успешно отправлена!</h3>
<p>Спасибо! Мы свяжемся с вами в ближайшее время.</p>
</div>";