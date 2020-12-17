<?php
#########################
##### Мастер-классы #####
#########################

// Конфигуратор UserMail
$config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main');

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject']  = "Ваша заявка принята!";
$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_card.php';