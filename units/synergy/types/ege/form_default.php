<?php
########################
##### Ленды по ЕГЭ #####
########################
// Конфигуратор FormMessages
$config['user']['sendsuccess'] = $DefaultSuccessMessage;

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = false;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'egemetr');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : '???');

// Адрес и имя для отправки писем
$config['mail']['smtp']['from']		= "notice@egemetr.ru";
$config['mail']['smtp']['fromname']	= "Egemetr.ru";