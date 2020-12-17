<?php
/* Конфигуратор отправки в Битрикс24 */
$config['ignore']['bitrix24'] = false;

/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : '');

/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с дальнейшими инструкциями.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";