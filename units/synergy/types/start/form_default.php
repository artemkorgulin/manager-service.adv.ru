<?php
#################################
##### Курсы  #####
#################################
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Спасибо, мы свяжемся с вами в ближайшее время.</p>
    </div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = false;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');

 // Конфигуратор UserMail
$config['ignore']['send_to_user']   = false;
$config['mail']['smtp']['user']['subject']  = "";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail.php';
