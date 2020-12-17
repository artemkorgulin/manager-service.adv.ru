<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Наш менеджер Вам позвонит и расскажет подробнее о лагере.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

/* Конфигуратор MessageForCallCentre */
$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('ESidorocheva@synergy.ru', 'VNishcheret@lingva.edu.ru', 'ESafonova@lingva.edu.ru'),);
$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда $lead->land [$lead->source]";
$config['mail']['smtp']['cc']['message'] = "
<p>Имя: <b>$lead->name</b>
        <br />Телефон: <b>$lead->phone</b>
        <br />Email: <b>$lead->email</b>
        <!--br />Вариант: <b>$lead->radio</b-->
        <br />-----
        <br />Город: <b>$lead->city</b>
        <br />Источник: <b>$lead->source</b>
        <br />Адрес страницы: $lead->url
        <br />-----------------------------------------</p>
        <p style='font-size:11px;'>Реферер: $lead->refer</p>";
        /* Конфигуратор UserMail */
        $config['ignore']['send_to_user'] 	= true;
        $config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
        $config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_default.php';