<?php

$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('do@synergy.ru'),);
$config['mail']['smtp']['cc']['subject'] = "Обращение в администрацию";
$config['mail']['smtp']['cc']['message'] = "
        <p>Имя: <b>$lead->name</b>
        <br />Телефон: <b>$lead->phone</b>
        <br />Email: <b>$lead->email</b>
        <br />Сообщение: <b>$lead->comments</b>
        <br />-----
        <br />Город: <b>$lead->city</b>
        <br />Источник: <b>$lead->source</b>
        <br />Адрес страницы: $lead->url
        <br />-----------------------------------------</p>
        <p style='font-size:11px;'>Реферер: $lead->refer</p>";
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваше обращение отправлено.</h3>
        <p>Мы ответим вам в ближайшее время.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";
