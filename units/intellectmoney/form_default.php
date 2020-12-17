<?php
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_kou');

$config['ignore']['send_to_user'] = false;
$config['ignore']['bitrix24'] = false;
$config['ignore']['getresponse'] = true;