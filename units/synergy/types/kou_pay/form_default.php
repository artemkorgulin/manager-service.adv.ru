<?php
###############################
##### Коучинг с авто-переходом на страницу оплаты  #####
###############################

$im_purse = 434911;
$program = ''; // костыль, пока  $_REQUEST['program'] приходит пустой. Потом подставлять $_REQUEST['program']

if (isset($_REQUEST['land']) && $_REQUEST['land'] == 'tatunashvili-kou-v1_synergyru') {
  $program = 'Офигенный маркетинг';

} elseif(isset($_REQUEST['land']) && $_REQUEST['land'] == 'employment_v1'){
	$program = 'Трудоустройство ALL INCLUSIVE';
} elseif(isset($_REQUEST['land']) && $_REQUEST['land'] == 'employment_v2pay'){
	$program = 'Трудоустройство ALL INCLUSIVE';
}


$order_id = $lead->land . time();

$intellectmoney_redirect = "<script>setTimeout(function(){window.open('https://merchant.intellectmoney.ru/?eshopId={$im_purse}&user_email={$lead->email}&recipientAmount={$lead->cost}&serviceName={$program}&userName={$lead->name}&OrderId={$order_id}&recipientCurrency=RUR&preference=bankCard', '_blank'); }, 1000);</script>";


/* С перенаправлением на видео после оплаты через IM  */
if (isset($_REQUEST['land']) && $_REQUEST['land'] == 'employment_v2pay') {
  //$im_purse = 434338; // тестовый
  $intellectmoney_redirect = "<script>setTimeout(function(){window.open('https://merchant.intellectmoney.ru/?eshopId={$im_purse}&user_email={$lead->email}&recipientAmount={$lead->cost}&serviceName={$program}&userName={$lead->name}&OrderId={$order_id}&recipientCurrency=RUB&preference=bankCard&successUrl=http://synergy.ru/lp/employment/?secret={$lead->mergelead}', '_blank'); }, 1000);</script>";
} elseif(isset($_REQUEST['land']) && $_REQUEST['land'] == 'employment' && isset($_GET['version']) && $_GET['version'] == 'version_free'){
	$intellectmoney_redirect = '';
}



$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
	{$intellectmoney_redirect}
</div>";


// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_kou');

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;

$config['mail']['smtp']['user']['subject'] = "Успешная регистрация: " . $program;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_kou_pay.php';

