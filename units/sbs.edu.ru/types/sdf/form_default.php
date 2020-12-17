<?php

$config['ignore']['send_to_user'] = false;

if ($lead->form == 'regist-bottom') {
    $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
        <h3>Спасибо, ваша заявка принята!</h3>
    </div>";
} else {
    $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
        <script>$('#popup-thanks').fancybox().trigger('click');</script>
    </div>";
}
