<?php
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h4>Ваш вопрос успешно отправлен ректору! </h4>
        <p>Ждите ответа на ваш e-mail или по телефону {$lead->phone}</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
