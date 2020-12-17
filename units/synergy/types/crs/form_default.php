<?php 
// Конфигуратор UserMail
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['fromname'] = "Центр размещения студентов";
$config['mail']['smtp']['user']['subject'] 	= "Центр размещения студентов";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_crs.php';
