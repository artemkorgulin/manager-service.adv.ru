<?php

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Полная программа курса “Топ-10 ошибок на ЕГЭ” отправлена на вашу почту: {$lead->email}</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

// Конфигуратор UserMail
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Регистрация на курс \"Топ-10 ошибок на ЕГЭ\"";
$config['mail']['smtp']['user']['message'] 	= include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/units/egemetr/types/lect/letters/mail_program.php';
