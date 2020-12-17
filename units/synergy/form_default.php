<?php

$link = "";
$redirect = "";
if (!empty($lead->link)) {
    $link = $lead->link;
}
/*{$DefaultRedirect}  */
if (!empty($link)) {
    $redirect = "<script type='text/javascript'>setTimeout(function(){ location.replace(\"{$link}\"); }, 5000);</script>";
}
if (isset($_REQUEST['partner']) && strlen(trim($_REQUEST['partner']))){
    $partner = 'partner='.$_REQUEST['partner'].'&';
}
$DefaultRedirect = "<script>setTimeout(function(){location.replace(\"http://synergy.ru/lp/thanks/\"); }, 1000);</script>";

if ($lead->land == 'dist-edu-v1' && isset($_GET['version']) && $_GET['version'] == 'demo') {
  $DefaultRedirect = "<script>setTimeout(function(){location.replace(\"http://synergyonline.ru/r/my_demo/index.php\"); }, 1000);</script>";
}

if ($_GET['thanks'] == 'fi' || $_GET['type'] == 'internet' || $lead->grcampaign == 'e_mail_chain_fi') {
  $DefaultRedirect = "<script>setTimeout(function(){location.replace(\"http://synergy.ru/lp/thanks/?version=fi\"); }, 1000);</script>";
}

$email_msg = '';
if(isset($lead->email) && $lead->email != '') {
  $email_msg = "<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>";
}



$DefaultSuccessMessage = "
<div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    {$email_msg}
    {$DefaultRedirect}
</div>";


//https://sd.synergy.ru/Task/View/105743
if($_REQUEST['land'] == 'scollege') {
  $DefaultSuccessMessage = "
  <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    {$email_msg}
</div>";
}

if($_REQUEST['land'] == 'cap-v2') {
  $DefaultSuccessMessage = "
  <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    {$email_msg}
</div>";
}

//https://sd.synergy.ru/Task/View/326915
if($_REQUEST['land'] == 'synergycollege_manakov') {
    $DefaultSuccessMessage = "
  <div class='send-success'>
       <h3>Спасибо, ваше сообщение получено!</h3>
       <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
</div>";
}



###############################
##### Сайт + по умолчанию #####
###############################
/* Конфигуратор GetResponse */
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_vpo');


/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Спасибо, ваше сообщение получено!</h3>
    {$email_msg}
    {$redirect}
</div>";

if($lead->land == 'synergycollege_manakov') {
    $config['user']['sendsuccess'] = "
  <div class='send-success'>
        <h3>Спасибо, Ваша заявка принята в работу</h3>       
</div>";
}