<?php
###########################
##### Подписные ленды #####
###########################
// Конфигуратор GetResponse
$config['ignore']['getresponse'] = $lead->graccount && $lead->grcampaign;
$config['ignore']['bitrix24'] = false;
$config['newsletter']['getresponse']['account']  = $lead->graccount;
$config['newsletter']['getresponse']['campaign'] = $lead->grcampaign;

$config['user']['sendsuccess'] = "ok";