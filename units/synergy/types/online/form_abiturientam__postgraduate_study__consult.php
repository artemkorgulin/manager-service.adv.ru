<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В&nbsp;ближайшее время с&nbsp;вами свяжется специалист приемной комиссии и&nbsp;подробнее расскажет о&nbsp;программах аспирантуры</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

