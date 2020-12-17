<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка успешно отправлена.</h3>
        <p>В ближайшее время вам позвонит специалист из приемной комиссии и поможет вам подобрать подходящую программу обучения.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
