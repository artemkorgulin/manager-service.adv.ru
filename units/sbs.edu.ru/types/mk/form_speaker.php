<?php
// Конфигуратор UserMail
$config['user']['sendsuccess'] = "
    <div class='send-success speak-send-success'>
        <h3>Ваше сообщение отправлено!</h3>
        <p>Чтобы посмотреть мастер-класс прямо сейчас, перейдите
        <br>по <a href='{$link}' class='btn-redirect' target='_blank'>ссылке</a>.</p>
        <div class=\"speaker_return\">Вернуться к описанию</div>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
