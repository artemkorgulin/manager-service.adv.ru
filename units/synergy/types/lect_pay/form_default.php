<?php
###############################
##### Лекция с авто-переходом на страницу оплаты  #####
###############################

$im_purse = 434911;
$program = $lead->program;

$order_id = $lead->land . time();
/*$intellectmoney_redirect = "<script>setTimeout(function(){window.open('https://merchant.intellectmoney.ru/?eshopId={$im_purse}&user_email={$lead->email}&recipientAmount={$lead->cost}&serviceName={$program}&userName={$lead->name}&OrderId={$order_id}&recipientCurrency=RUR&preference=bankCard', '_blank'); }, 1000);</script>";*/

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
	{$intellectmoney_redirect}
</div>";

/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на лекцию: {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_lect_pay.php';

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sm');



/* http://synergylectorium.ru/lp/hitrov/kou-v1/ : https://sd.synergy.ru/Task/View/75976 */
if($lead->land == 'lectorium_hitrov_kou-v1'){
	$config['mail']['smtp']['user']['subject'] = "Заявка на платный курс от Виталия Хитрова - исполнительного директора крупнейшего в России агрегатора событий KudaGo";
}
