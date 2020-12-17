<?php

$config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Спасибо, ваше сообщение получено!</h3>
    <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
    {$redirect}
</div>";

?>