<?php

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «Ораторское искусство 2.0»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_gandapas.php';

if($lead->version == 'with-prices') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <p>Спасибо!</p>
    <p>Подтверждение регистрации направлено на ваш email.</p>
    <p class='jq-scroll'><a href='#tickets'>Перейти к выбору билета</a></p>
    </div>";
} else {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <p>Спасибо!</p>
    <p>Подтверждение регистрации направлено на ваш email. Наш менеджер свяжется с вами и подробно расскажет об условиях участия в тренинге.</p>
    <p><a href='#popup_all-tickets' data-fancybox>Перейти к покупке билетов</a></p>
    <script>
    addMergeLead('".$lead->mergelead."');
    $('[href=\"#popup_all-tickets\"]')[0].click();
    </script>
    </div>";
}

if($lead->grtag =='gandapas_live'){
    $config['ignore']['send_to_user'] = false;
    $config['ignore']['getresponse'] = true;
}