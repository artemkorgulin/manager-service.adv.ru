<?php
{
	// Конфигуратор FormMessages
	$shop_id = '455502';
	if (isset($_REQUEST['shop_id']) && $_REQUEST['shop_id'] !=''){
		$shop_id = $_REQUEST['shop_id'];
	}
	$intellectmoney_redirect = "<script>setTimeout(function(){window.open('https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE={$shop_id}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC={$payment_name}&preference=bankCard', '_blank'); }, 1000);</script>";


	$config['user']['sendsuccess'] = "
	<div class=\"send-success\">
		<h3>Заявка успешно отправлена!</h3>
		{$intellectmoney_redirect}
	</div>
	";



	$config['ignore']['bitrix24'] 	= false;

	// Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('extreme@synergy.ru'));

	$config['mail']['smtp']['cc']['subject'] = "Заявка с Synergy Extreme Center";
	$config['mail']['smtp']['cc']['message'] = "
	<p>Имя: <b>$lead->name</b>
		<br />Телефон: <b>$lead->phone</b>
		<br />Email: <b>$lead->email</b>
		<br />Кому сертификат: <b>$_REQUEST[fio]</b>
		<br />-----
		<br />Заказ: <b>$_REQUEST[price]</b>
		<br />Оплата: <b>$_REQUEST[payment]</b>
		";
	// Адрес и имя для отправки писем
		$config['mail']['smtp']['from']		= "noreply@synergy.ru";
		$config['mail']['smtp']['fromname']	= "Synergy Extreme Center";
	}