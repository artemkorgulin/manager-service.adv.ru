<?php

$config['ignore']['bitrix24'] = true;

$config['ignore']['send_to_user'] = false;

$config['ignore']['getresponse'] = false;

$lead->program = "билет";

$comments = 1;

if (isset($_REQUEST['tiket']) && preg_match('/^\+?\d+$/', $_REQUEST['tiket'])) {
	$comments = $_REQUEST['tiket'];
} 

$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена!</h3>
			<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
			<p>Через 3 секунды вы будете автоматически перенаправлены на страницу оплаты</p>
			<script>
				setTimeout( function(){

					location.href = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=456173&price={$_REQUEST['cost']}&email={$lead->email}&username={$lead->name}&productName={$lead->program}&land={$lead->land}&phone={$lead->phone}&form={$lead->form}&mergelead={$lead->mergelead}&comments={$comments}&httpreferer={$lead->url}';

				}, 3000);
			</script>
		</div>";



?>