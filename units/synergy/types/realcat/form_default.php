<?php
{
	$order_id = $lead->land . time();
	$config['ignore']['bitrix24'] 	= true;

	$payment_link = "http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=456108&email={$lead->email}&price=1500&phone={$lead->phone}&productName=Реальный кот | Практический курс по воспитанию и уходу&username={$lead->name}&land={$lead->land}&httpreferer={$lead->url}";
	$payment_message = "";

	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<!--<p>Наш менеджер свяжется с&nbsp;вами.</p>-->
		<p>Вы будете перенаправлены на&nbsp;страницу оплаты.</p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); setTimeout(function(){ location.href = '{$payment_link}' }, 1000); });</script>
	</div>
	";
	$config['user']['sendduplicate'] = "
	<div class='send-duplicate'>
		<h3>Вы уже отправляли сообщение!</h3>
		<p>Если вам не&nbsp;ответили или не&nbsp;перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой номер</a> телефона. Или позвоните по&nbsp;номеру: +7 (495) 532 52&nbsp;90</p>
		<script>$('document').ready(function(){Hash.add('send','duplicate');});</script>
	</div>
	";

	$config['ignore']['send_to_user'] = true;

	if ( $lead->version == 'v2' ) {
		$config['ignore']['send_to_user'] = false;

		$config['user']['sendsuccess'] .= "
		<p>Вы будете перенаправлены на&nbsp;страницу оплаты.</p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); setTimeout(function(){ location.href = '{$payment_link}' }, 1000); });</script>
		";

		/*
		$payment_message = "
		<p>Оплатить участие можно, кликнув на кнопку ниже:</p>
		<p style='padding:20px 0; text-align: center;'><a style='font-size:15px; color:#701070; text-decoration:none; font-weight:bold; border:2px solid #701070; padding:10px 20px;' href='{$payment_link}'>Оплатить</a></p>
		";
		*/
	}

	$config['mail']['smtp']['from'] = "notice@реальныйкот.рф";
	$config['mail']['smtp']['fromname']	= "реальныйкот.рф";
	$config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
	$config['mail']['smtp']['user']['message'] 	= "
	<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
		<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
			<h3>Поздравляю!</h3>
			<p>
				Вы&nbsp;только что зарегистрировались на&nbsp;онлайн-курс &laquo;Реальный кот&raquo;.<br>
				Наш менеджер свяжется с&nbsp;вами.
			</p>

			{$payment_message}

			<p>Бонус&nbsp;&mdash; мой первый собственный кот. И&nbsp;мы&nbsp;вместе пройдём этапы его становления: от&nbsp;сложных и&nbsp;требующих терпения до&nbsp;радостных и&nbsp;приносящих счастье.</p>
			<hr>
			<p>Автор и&nbsp;ведущая курса,<br> Ангелина Тычинина</p>
		</div>
	</div>
	";
}
