<?php 
// Конфигуратор UserMail
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Ваша регистрация на День открытых дверей";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_dod.php';
