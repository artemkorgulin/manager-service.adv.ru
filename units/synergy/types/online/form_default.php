<?php
if (strpos(".synergyonline.ru") === false) {
	$curlSms = curl_init("https://syn.su/smsResponse.php");
	curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
	if ($_REQUEST['land'] != 'police') {
		$responseSms = curl_exec($curlSms);
	}
	curl_close($curlSms);
}
if ('synergyonline.ru' == $lead->land && 'top' == $_REQUEST['form']) {
  $DefaultRedirect = "<script>setTimeout(function(){location.replace(\" http://synergyonline.ru/program_calculator?notsend=yes#program-selection-step-2\"); }, 1);</script>";
} else {
  $DefaultRedirect = "<script>setTimeout(function(){location.replace(\"http://synergyonline.ru/thanks/\"); }, 1000);</script>";  
}



$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_synonline');
 
$config['ignore']['vrf_by_phone'] = false;
$config['user']['sendsuccess'] = "
<div class='send-success'>
        <h3>Спасибо! Ваша заявка отправлена.</h3>
        <p>В ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;подробнее расскажет об&nbsp;условиях поступления на&nbsp;онлайн-программы Университета «Синергия».</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";
// Конфигуратор UserMail
// $config['ignore']['send_to_user'] 	= true;
// $config['mail']['smtp']['user']['subject'] 	= "Synergy Online — учитесь когда и где удобно";
// $config['mail']['smtp']['user']['message'] 	= include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/synergy.ru/letters/synergyonline.php';
