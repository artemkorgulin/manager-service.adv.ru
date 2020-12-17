<?php

/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;подробнее расскажет об&nbsp;условиях поступления на&nbsp;онлайн-программы первого высшего образования.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
