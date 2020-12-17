<?php
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'start_chain');

	$config['ignore']['bitrix24'] = false;
	$config['ignore']['send_to_user'] = false;

	header('Location: http://synergystartup.ru/lp/first_step/', true, 301 );