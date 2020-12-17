<?php
/* Если на ленде есть &link=, то подставлять ссылку оттуда, а не с массива выше */
$link = "";
$redirect = "<script>setTimeout(function(){ location.replace(\"http://lingva.edu.ru/lp/thanks-leto/\"); }, 3000);</script>";
if (!empty($lead->link)) {
        $link = $lead->link;

        if (strpos($link, 'http://lingva.edu.ru/lp/thanks') === false ) $link = 'http://lingva.edu.ru/lp/thanks-leto/'; /* Если на ленде есть link и он не http://lingva.edu.ru/lp/thanks, принудительно редиректим на http://lingva.edu.ru/lp/thanks-leto/ */
        $redirect = "<script>setTimeout(function(){ location.replace(\"{$link}\"); }, 3000);</script>";
}


/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с дальнейшими инструкциями.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$redirect}
</div>";
/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
$config['mail']['smtp']['user']['message'] 	= include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/sbs.edu.ru/letters/mail_default.php';

/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_engblend');