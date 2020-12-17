<?php 

$config['mail']['smtp']['user']['subject'] = "Ваш билет на Семинар Джона Кехо «Подсознание может всё!»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/sgf_kehoe/ticket.php';
mail("tickets@synergyglobal.kz", "Ваш билет на Семинар Джона Кехо «Подсознание может всё!»", $config['mail']['smtp']['user']['message'], "Content-Type: text/html; charset=UTF-8\r\n");