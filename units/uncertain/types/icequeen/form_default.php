<?php

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = false;

$config['mail']['smtp']['user']['subject'] = "";
$config['mail']['smtp']['user']['message'] = "<p>Здравствуйте!</p> <p>Спасибо за вашу заявку!</p>";

$sendsuccess = "
<div class='send-success'>
<h3>Заявка успешно отправлена!</h3>
<p>Спасибо! Мы свяжемся с вами в ближайшее время.</p>
</div>";

$config['user']['sendsuccess'] = $sendsuccess;