<?php

	// Конфигуратор UserMail
	$config['ignore']['send_to_user']   = false;

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Thank you!</h3>
		<p>Request is successfully placed!</p>
		<script>
			setTimeout(function(){
				window.location.href='http://synergy.university/lp/thanks/';
			}, 3000);
		</script>
	</div>";
	
	// Конфигуратор GetResponse
    $config['ignore']['getresponse']    = true;
    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_dubai');

    if($_REQUEST['lang'] == 'ru'){

    	$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо!</h3>
			<p>Ваша заявка отправлена!</p>
		</div>
		<script>
			setTimeout(function(){
				window.location.href='http://synergy.university/lp/thanks_ru/';
			}, 3000);
		</script>";

    }

?>