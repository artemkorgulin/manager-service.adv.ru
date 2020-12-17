<?php 
$curlSms = curl_init("https://syn.su/smsResponse.php");
curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
$responseSms = curl_exec($curlSms);
curl_close($curlSms);
###############################
##### Оплата обучения серез synergyonline.ru/program_reservation  #####
###############################

$im_purse = 434911;
$program = $_REQUEST['program']; 



//$order_id = $lead->land . time();
if ($lead->cost != '') {
  
  $intellectmoney_redirect = "<script>setTimeout(function(){window.open('http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$im_purse}&price={$lead->cost}&email={$lead->email}&productName={$program}&username={$lead->name}&form={$lead->form}', '_blank'); }, 1000);</script>";

} else {
  $intellectmoney_redirect = '';
}



$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена</h3>
	<p>{$lead->name}, вы успешно отправили заявку! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
	{$intellectmoney_redirect}
</div>";


// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_kou'); 

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;

$config['mail']['smtp']['user']['subject'] = "Успешная заявка: " . $program;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_education.php';

