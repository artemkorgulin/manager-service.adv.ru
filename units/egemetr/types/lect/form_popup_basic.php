<?php

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>В ближайшее время вы получите письмо с подробностями перехода на новый уровень обучения, а наш менеджер свяжется с вами и ответит на все вопросы.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

// Конфигуратор UserMail
/*$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Регистрация на курс \"Топ-10 ошибок на ЕГЭ\"";
$config['mail']['smtp']['user']['message'] 	= include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/units/egemetr/types/lect/letters/mail_default.php';*/
