<?php 
// Не отправлять в Битрикс24
$config['ignore']['bitrix24'] = false;

// Используется тут https://corp.synergy.ru/test/notcall.php?login=yes
// Конфигуратор UserMail
$config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Отлично!</h3>
        <p>Мы отправили письмо на почту <b>{$lead->email}</b>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : ''); 