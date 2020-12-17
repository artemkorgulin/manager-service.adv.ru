<?php
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = $DefaultSuccessMessage;

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Центр размещения студентов";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/living.php';
