<?php
/* Defaults */
$config['mail']['smtp']['user']['subject'] = "Вы прошли регистрацию на предпринимательский форум ТЕРРИТОРИЯ БИЗНЕСА";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/territoriyabiznesa/default.php';

$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = false;

$expertsender_send_letter = true;

if ($lead->land == 'territoriyabiznesa') {
    $config['ignore']['getresponse'] = true;
    $config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'web_business_bridge');
    $config['newsletter']['getresponse']['grtag'] = (!empty($lead->grtag) ? $lead->grtag : 'business_bridge');
}

$tickets_select = '
<a href="#popup-tickets-all" class="form__button button button_tickets fancybox">Перейти к&nbsp;выбору билета</a>
<script>$("[href=\'#popup-tickets-all\']").trigger("fancybox.init").first().trigger("click")</script>
';

$expertsender = [
	'email'       => $lead->email,
	'name'        => $lead->name,
	'id'          => $lead->uuid,
	'land'        => $lead->land,
	'phone'		  => $lead->phone,
	'ip'          => $lead->ip,
	'dateCreated' => time(),
	'listId'      => 69
];

/* ExpertSender - лист подписки */
$curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $expertsender);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEs = curl_exec($curl);
curl_close($curl);


/* Версии */

if ( $lead->version == 'detailed-price' ) {
	$expertsender_send_letter = false;
}

elseif ( $lead->version == 'no-prices' ) {
	$tickets_select = '';
}


/* Формируем ответ с учётом версий */
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо!</h3>
	<p>Ваша заявка отправлена. Наши менеджеры скоро свяжутся с&nbsp;вами.</p>

	{$tickets_select}

</div>
";
