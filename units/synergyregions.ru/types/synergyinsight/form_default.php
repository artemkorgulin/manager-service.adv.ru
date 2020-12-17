<?php
if($lead->form == 'main-popup'
	|| $lead->form == 'mainFirst'
	|| $lead->form == 'mainFooter'
	|| $lead->form == 'price'
	|| $lead->form == 'price-onl'
	|| $lead->form == 'main-corp'
	|| $lead->form == 'mobile'
	|| $lead->form == 'blogFirst'
	|| $lead->form == 'blogFooter'
	)
{
	$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на Synergy Insight Forum 2017";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/synergyinsight.php';
}

$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;

$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sif');

$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Отлично!</h3>
	<p>Наши специалисты свяжутся с&nbsp;вами в&nbsp;ближайшее время.</p>
</div>
';
