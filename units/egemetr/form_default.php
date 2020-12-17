<?php

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success' id='send-success'>
<form action='http://synergy.ru/lander/alm/lander_new_sms.php?r=landphone_validate&type=ege' data-form='smsver' method='post' class='application'>
<h3 class='msg_info'>На ваш телефон отправлен код подтверждения!</h3>
<p><input type='text' class='text' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' min='4' reqired autofocus />
<input type='submit' value='Подтвердить' class='btn bluebtn'></p>
<p><span class='msg_text'>Не пришел код в течение 2-ух минут?</span> <input type='button' class='btn' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landresendsms\");' value='Выслать еще раз'></p>
<input type='hidden' name='type' value='proftest'>
<input type='hidden' name='version' value='v2'>
<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
<input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />
</form>";

// Верификация успешна
$config['user']['sendsuccessvalidation'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Подробные инструкции для участия в курсе “Топ-10 ошибок на ЕГЭ” вы получите на вашу почту {$lead->email}, а наш менеджер свяжется с Вами в ближайшее время, и ответит на все вопросы.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

// Верификация провалена
$config['user']['sendfaildvalidation'] = "
<div class='send-error'>
	<h3>СМС код не корректный!</h3>
	<p>Попробуйте <a href='3' onclick='startAjax(\"http://synergy.ru/lander/alm/lander_new_sms.php?r=landphone_retry&type=proftest\"); return false;'>еще раз</a>.</p>

</div>";

// Неверный номер + смс сервис не доступен
$config['user']['smscfail'] = "
<div class='send-error' id='send-success'>
    <h3>Произошла ошибка!</h3>
    <p>Вы ввели неверный номер мобильного телефона <b>{$lead->phone}</b>, или служба отправки смс недоступна. Пожалуйста, попробуйте позже.</p>

</div>";

// Конфигуратор UserMail
$config['ignore']['send_to_user']       = true;
$config['mail']['smtp']['user']['subject']      = "Регистрация на курс \"Топ-10 ошибок на ЕГЭ\"";
$config['mail']['smtp']['user']['message']      = include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/units/egemetr/types/lect/letters/mail_default.php';
