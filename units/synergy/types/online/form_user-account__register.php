<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо!</h3>
        <p>Вы успешно зарегистрировались.</p>
        <script>
                $('document').ready(function(){
                        setCookie('user-account', '$lead->email', '30', '/');
                        location.href='http://synergyonline.ru/r/my_demo/index.php';
                });
        </script>
</div>";

