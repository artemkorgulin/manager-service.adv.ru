<?php
###########################
##### Подписные ленды #####
###########################
// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'total_subscription');

if ($lead->land == 'sbs-intensive') {
    // Конфигуратор UserMail
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Остался один шаг!</h3>
        <p>Пожалуйста, подтвердите подписку, перейдя по ссылке в письме, которое мы отправили на почту <b>{$lead->email}</b>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
}
else{
    // Конфигуратор UserMail
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Пожалуйста, подтвердите ваш адрес электронной почты.</h3>
        <p>Письмо подтверждения мы отправили на вашу почту <b>{$lead->email}</b>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
}
    
// Не отправлять в Битрикс24 если содержит только мыло
$config['ignore']['bitrix24'] = (!empty($lead->phone)  ? true : false);