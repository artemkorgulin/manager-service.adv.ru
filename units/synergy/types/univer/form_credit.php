<?php
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = $DefaultSuccessMessage;

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Ваша заявка на обучение в кредит";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/credit.php';

