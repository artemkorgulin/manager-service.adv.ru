<?php
// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;

switch ($_REQUEST['lang']) {
  case 'ru':
    // Конфигуратор UserMail
    $config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_land_sic_ru.php';

    $config['user']['sendsuccess'] = '
    <div class="send-success">
        <h3>Спасибо, ваше сообщение получено!</h3>
        <p>Проверьте вашу почту <b>' . $lead->email . '</b>, на которую придет письмо с дальнейшими инструкциями.</p>
    </div>';

  case 'en':
    // GET RESPONSE OFF
    $config['ignore']['getresponse'] = false;
    $config['newsletter']['getresponse']['account'] = '';
    $config['newsletter']['getresponse']['campaign'] = '';
    
    // Конфигуратор UserMail
    $config['mail']['smtp']['user']['subject'] = "Welcome to Synergy University!";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_land_sic.php';

    $config['user']['sendsuccess'] = '
    <div class="send-success">
        <h3>Thanks, your message is received!</h3>
        <p>Check your email <b>' . $lead->email . '</b>, for a letter with further instructions.</p>
    </div>';
    
    $redirect = '';
    $DefaultRedirect = '';

  break;
}