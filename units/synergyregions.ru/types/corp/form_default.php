<?php
/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо, ваше сообщение получено!</h3>
        <p>Скоро мы с вами свяжемся по телефону <b>{$lead->phone}</b>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'corp_chain');