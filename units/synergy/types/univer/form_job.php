<?php
// Конфигуратор GetResponse
$config['ignore']['getresponse']    = false;
$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('spolenova@synergy.ru'));
$config['mail']['smtp']['cc']['subject'] = "Отклик на вакансию $lead->program";
$config['mail']['smtp']['cc']['message'] = "
<p>Имя: <b>$lead->name</b>
        <br />Телефон: <b>$lead->phone</b>
        <br />E-mail: <b>$lead->email</b>
        <br />Сообщение: <b>$lead->comments</b>
        <br />-----
        <br />Город: <b>$lead->city</b>
        <br />Источник: <b>$lead->source</b>
        <br />Адрес страницы: $lead->url
        <br />-----------------------------------------</p>
        <p style='font-size:11px;'>Реферер: $lead->refer</p>";
