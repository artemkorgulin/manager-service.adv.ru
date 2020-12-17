<?php

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success' id='send-success'>
<form action='http://synergy.ru/lander/alm/lander.php?r=landphone_validate&type=egemetr' data-form='smsver' method='post' class='application'>
<h3 class='msg_info'>На ваш телефон отправлен код подтверждения!</h3>
<p><input type='text' class='text' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' min='4' reqired autofocus />
<input type='submit' value='Подтвердить' class='btn bluebtn'></p>
<p><span class='msg_text'>Не пришел код в течение 2-ух минут?</span> <input type='button' class='btn' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landresendsms\");' value='Выслать еще раз'></p>
<input type='hidden' name='type' value='proftest'>
<input type='hidden' name='version' value='{$lead->version}'>
<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
<input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />
<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />
<input type=\"hidden\"  name=\"comments\" value=\"лид из смс-формы\">
</form>";


// Верификация успешна
$config['user']['sendsuccessvalidation'] = "
<div class='send-success'>
	<h3>Проверка пройдена!</h3>
	<p>Доступ предоставлен.</p>
	<script>$(function(){ localStorage.setItem('verification', 'success'); $('body').trigger('init-test'); });</script>
</div>";

// Верификация провалена
$config['user']['sendfaildvalidation'] = "
<div class='send-error'>
	<h3>СМС код не корректный!</h3>
	<p>Попробуйте <a href='#' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landphone_retry&type=proftest\"); return false;'>еще раз</a>.</p>

</div>";

// Неверный номер + смс сервис не доступен
$config['user']['smscfail'] = "
<div class='send-error' id='send-success'>
    <h3>Произошла ошибка!</h3>
    <p>Вы ввели неверный номер мобильного телефона <b>{$lead->phone}</b>, или служба отправки смс недоступна. Пожалуйста, попробуйте позже.</p>

</div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_proftest');

