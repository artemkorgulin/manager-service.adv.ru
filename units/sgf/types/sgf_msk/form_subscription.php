<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!
	</p>
</div>
';

$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : $default_grcampaign);