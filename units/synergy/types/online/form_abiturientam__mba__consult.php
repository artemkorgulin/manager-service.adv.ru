<?php

/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется специалист приемной комиссии, подробнее расскажет об&nbsp;онлайн-программах бизнес-образования и&nbsp;ответит на&nbsp;все ваши вопросы.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
