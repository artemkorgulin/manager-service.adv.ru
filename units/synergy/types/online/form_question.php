<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваш вопрос отправлен в&nbsp;приемную комиссию.</h3>
        <p>Наш консультант подготовит ответ и&nbsp;свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
