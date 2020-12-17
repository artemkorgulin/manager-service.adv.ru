<?php
$config['ignore']['send_to_user'] = false;
$ignoreExpertSender = true;

$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('info@synergydigital.ru'), );
$config['mail']['smtp']['cc']['subject'] = "Заявка с сайта synergyglobal.ru";
$config['mail']['smtp']['cc']['message'] = "
<p>
Имя: <b>{$lead->name}</b><br>
Телефон: <b>{$lead->phone}</b><br>
E-mail: <b>{$lead->email}</b><br>
-----------------------------------------
</p>
";

$config['user']['sendsuccess'] = "
<div class='send-success'>
<p>
Спасибо! Ваша заявка отправлена.<br>
</p>
</div>
";
