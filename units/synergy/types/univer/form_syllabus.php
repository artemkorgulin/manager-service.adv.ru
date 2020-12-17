<?php

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо!</h3>
        <p>Полный учебный план отправлен на вашу почту {$lead->email}.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

// Конфигуратор UserMail
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Ваш учебный план";
$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/download_syllabus.php';

