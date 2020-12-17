<?php
####################
##### Вебинары #####
####################
/* Конфигуратор FormMessages */
if ($_GET['version'] == 'ru')
{
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>- Спасибо за регистрацию!</h3>
    <p>{$lead->name}, дальнейшие инструкции по прохождению вебинара будут высланы Вам на почту <b>{$lead->email}</b>.</p>
    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
  </div>";
}
else
{
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>- Thank you for registering!</h3>
    <p>{$lead->name}, you will get the following instructions on your email address <b>{$lead->email}</b>.</p>
    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
  </div>";
}



/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_dubai'); /* было webinar */


/* Стандартное письмо на все вебинары */
$config['ignore']['send_to_user'] = true;
if ($_GET['version'] == 'ru')
{
  $config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар: {$lead->program}";
  $config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb.php';
}
else
{
  $config['mail']['smtp']['user']['subject'] = "Register for the webinar: {$lead->program}";
  $config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb_en.php';
}
