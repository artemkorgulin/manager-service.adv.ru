<?php
####################
##### Synergy Service #####
####################
if($lead->land == 'synergy_resonance') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо, что оставили заявку!</h3>
		<p>Наш менеджер свяжется с вами в ближайшее время.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

    // Конфигуратор UserMail
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Вы участвуете в двухдневном интенсиве по интернет-маркетингу.";
    $config['mail']['smtp']['user']['message'] 	= "
    Здравствуйте, {$lead->name}!<br>
    <br>
    Вы зарегистрировались на {$lead->program}, который состоится {$lead->dater}.<br>
    <br>
    Ждем вас по адресу: г. Москва, м. «Семеновская», ул. Измайловский Вал, д. 2, стр. 1<br>
    <br>
    До встречи!<br>
    С уважением,<br>
    Ваша команда Университета «Синергия»
    ";

// Конфигуратор GetResponse
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sm');

// Конфигуратор UserMail
    $config['mail']['smtp']['user']['subject'] = "Вы участвуете в двухдневном интенсиве по интернет-маркетингу.";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_intensiv.php';
}
else{
// Конфигуратор FormMessages
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо, что оставили заявку!</h3>
		<p>{$lead->name}, наш менеджер свяжется с вами в ближайшее время.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

// Конфигуратор GetResponse
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sm');
    $audience  = (($lead->land=="synergy_aleshin")  ? '410' :'611');
// Конфигуратор UserMail
    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject']  = "Регистрация на семинар: {$lead->program}";

    if (strpos(trim($lead->land), 'lp_ovchinnikov_wb-v1') !== false){

    $config['mail']['smtp']['user']['message']  = include_once UNIT_DIR.'/letters/mail_type_wb_ovchinnikov_wb-kc1.php';
    }
    else {
    $config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_synservice.php';
    }

}

