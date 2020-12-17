<?php
/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = $DefaultSuccessMessage;
$config['ignore']['bitrix24'] 	= false;

/* Конфигуратор MessageForCallCentre */
$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('DRB@synergy.ru'));

$config['mail']['smtp']['cc']['subject'] = "Заявка на сотрудничество из региона";
$config['mail']['smtp']['cc']['message'] = "
<p>Имя: <b>$lead->name</b>
        <br />Телефон: <b>$lead->phone</b>
        <br />Email: <b>$lead->email</b>
        <br />-----
        <br />Город: <b>$lead->city</b>
        <br />Источник: <b>$lead->source</b>
        <br />Адрес страницы: $lead->url
        <br />-----------------------------------------
</p>
<p style='font-size:11px;'>Реферер: $lead->refer</p>
";

/* Адрес и имя для отправки писем */
$config['mail']['smtp']['from']		= "noreply@synergy.ru";
$config['mail']['smtp']['fromname']	= "Сотрудничество Регион";

