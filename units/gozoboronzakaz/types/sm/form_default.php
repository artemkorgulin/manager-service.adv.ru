<?php

	$payment_link = "http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=456386&email={$lead->email}&price={$lead->cost}&phone={$lead->phone}&productName=ДПО Гособоронзаказ&username={$lead->name}&land={$lead->land}&httpreferer={$lead->url}";

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Благодарим за оформление заявки!</h3>
		<p>Наши менеджеры свяжутся с вами в ближайшее время</p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); });</script>
	</div>
	";


if( isset($_POST['radio']) && $_POST['radio'] == 'Физическое лицо' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Благодарим за оформление заявки!</h3>
		<p>Наши менеджеры свяжутся с вами в ближайшее время</p>
		<br>
		<p>У Вас есть возможность оплатить курс прямо сейчас!</p>
		<p><a href='{$payment_link}' class='button'>Перейти к оплате</a></p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); });</script>
	</div>
	";
}


if($lead->form == 'question') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Благодарим за оформление заявки!</h3>
		<p>Наши менеджеры свяжутся с вами в ближайшее время</p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); });</script>
	</div>
	";
}


if($lead->form == 'program') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>Пожалуйста, проверьте свою электронную почту&nbsp;&ndash; мы направили на нее ссылку на подробную программу курса.</p>
		<script>$('document').ready(function(){ Hash.add('send','ok'); });</script>
	</div>
	";


	$config['ignore']['send_to_user'] = true;
	$config['mail']['smtp']['from'] = "noreply@gozoboronzakaz.ru";
	$config['mail']['smtp']['fromname']	= "ГосОборонЗаказ";
	$config['mail']['smtp']['user']['subject'] 	= "Полная программа курса";
	$config['mail']['smtp']['user']['message'] 	= "
	<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
		<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
			<a href='http://synergy.ru' title='Перейти на сайт Университета'><img src='http://synergy.ru/lp/box/logo/logo.png' alt=' width='240' height='35'></a>
		</div>
		<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Скачать программу по <a href='http://gozoboronzakaz.ru/upload/gozoboronzakaz.rar'>ссылке</a></p>
			<hr style='color: #E5E5E5;'>
    	<p style='color:#505050;'>До встречи!<br>Университет «Синергия», <br> <a href='http://synergy.ru '>www.synergy.ru</a></p>
		</div>
	</div>"
	;
}