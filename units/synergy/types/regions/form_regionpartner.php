<?php
$config['mail']['smtp']['cc']['emails'] = array(array('DRB@synergy.ru'),);
$config['mail']['smtp']['cc']['subject'] = "Заявка на открытие регионального представительства";

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
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Наш менеджер скоро с вами свяжется</h3>
</div>";

