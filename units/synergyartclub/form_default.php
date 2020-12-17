<?php

$config['ignore']['bitrix24'] = true;

$config['ignore']['send_to_user'] = false;

$config['ignore']['getresponse'] = false;

$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена!</h3>
			<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
			<p>Через 3 секунды вы будете автоматически перенаправлены на страницу оплаты</p>
			<script>
				setTimeout( function(){

					location.href = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=434911&price={$_REQUEST['cost']}&email={$lead->email}&username={$lead->name}&productName={$lead->program}&land={$lead->land}&phone={$lead->phone}&form={$lead->form}&mergelead={$lead->mergelead}';

				}, 3000);
			</script>
		</div>";



?>