<?php

// Конфигуратор UserMail
$config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>Ссылку на мастер-класс мы отправили на вашу почту <b>{$lead->email}</b>. Так же вы можете прямо сейчас <a href='{$link}' class='btn-redirect' target='_blank'>посмотреть мастер-класс</a>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

