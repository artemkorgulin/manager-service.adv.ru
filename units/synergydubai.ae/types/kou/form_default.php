<?php
###############################
##### Семинары и коучинги #####
###############################
	// Конфигуратор FormMessages
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Your request has been sent successfully!</h3>
		<p>{$lead->name}, you have successfully registered for the event. Check your e-mail  <b>{$lead->email}</b>, there you will find a letter with further instructions.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
	
	// Конфигуратор GetResponse
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_tracy');

	// Конфигуратор UserMail
	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject']  = "Your request has been received!";
	$config['mail']['smtp']['user']['message']  = "<h3>Welcome, {$lead->name}!</h3>
		<p>You have successfully registered for the program  «{$lead->program}».<br>
		We wait for you on  {$lead->dater} at Synergy Business School.<br>
		Speaker — {$lead->speaker}.</p>
		
		<!--<p><b>Если Вы еще не оплатили участие</b> <br>
		Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. Мы используем сервис IntellectMoney. <br>
		<a href='https://Merchant.IntellectMoney.ru/en/index.php?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYEE_PURSE=452781&LMI_PAYMENT_DESC=Оплата+участия+в+семинаре+«{$lead->program}»' target='_blank'>Перейти к оплате >></a></p>
		<p>После проведения платежа мы вышлем подтверждение и автоматически включим вас в список участников. <br>-->
		
		Keep your phone handy. We will call to clarify the conditions of participation and to confirm your registration information!</p>
		<hr />
		<p>See you!<br />
		<a href='http://sbs.edu.ru?utm_source=usermail'>Synergy Business School</a><br />
		tel: +971 4 420 6699 </p>";