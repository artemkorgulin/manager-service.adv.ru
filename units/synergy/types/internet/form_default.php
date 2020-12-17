<?php

if($lead->land == 'internet-sub-v1') {
    $DefaultSuccessMessage = "
	    <div class='send-success'>
	        <p><b>ПОЖАЛУЙСТА, ПОДТВЕРДИТЕ АДРЕС ЭЛЕКТРОННОЙ ПОЧТЫ</b></p><!-- DEFAULT -->
	        <p>Проверьте вашу почту <b>{$lead->email}</b>и подтвердите регистрацию, кликнув по ссылке в письме.</p>
	    </div>";
 }

if($_REQUEST['version'] == 'frii'){
    /* Конфигуратор FormMessages */
    $config['user']['sendsuccess'] = '<div class="send-success"><h3>Заявка успешно отправлена!</h3></div>';
}
else{
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sub');

    /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = $DefaultSuccessMessage;
}
