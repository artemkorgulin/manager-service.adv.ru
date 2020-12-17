<?php
/* https://sd.synergy.ru/Task/View/98946 */
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sif');

$config['ignore']['send_to_user'] = false;

$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>Следите за&nbsp;нашими рассылками&nbsp;&mdash; мы&nbsp;вышлем вам лучшие выступления SIF2017</p>
</div>
';
