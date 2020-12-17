<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка успешно отправлена.</h3>
        <p>В ближайшее время вам перезвонит наш специалист по дополнительному образованию и поможет подобрать подходящий онлайн-курс.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

