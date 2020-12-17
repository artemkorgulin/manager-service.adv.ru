<?php
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Вы успешно подписаны на рассылку.</h3>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

