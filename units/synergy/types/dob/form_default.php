<?php 
#################################
##### День открытых дверей  #####
#################################
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на День открытых дверей, ссылку для участия вы получите на вашу почту {$lead->email}.</p>
	</div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');

 // Конфигуратор UserMail
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Ваша регистрация на День открытых дверей";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_dod.php';

