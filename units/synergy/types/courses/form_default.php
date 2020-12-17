<?php 
#################################
##### Курсы  #####
#################################
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придёт информационное письмо.</p>
    </div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');

 // Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject']  = "Изучите фарси и откройте новые возможности для работы и отдыха в Иране";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_courses.php';

