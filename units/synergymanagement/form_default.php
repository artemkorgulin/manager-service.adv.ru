<?php
	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
	</div>";

	if ($lead->land == 'synergymanagement_audit') {
		$config['user']['sendsuccess'] = "
		<script>
		$.fancybox.open('#popuper');
		$(document).ready(function(){
					setTimeout(function() {
		       location.reload();
		   }, 3000);
		});
		</script>";
	}

  if ($lead->land == 'stratagam') {
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Чемпионат по бизнес-стратегии: подтверждение регистрации";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_stratagam.php';
		$config['mail']['smtp']['fromname'] = "Synergy Management System";
		$sendsuccess = "
			<div class='send-success'>
				<h3>Спасибо!</h3>
				<p>Мы свяжемся с&nbsp;Вами в&nbsp;ближайшее время для&nbsp;обсуждения деталей.</p>
			</div>
		";

		if ($lead->form == 'download') {
			$config['ignore']['send_to_user'] = false;
			$sendsuccess = "
				<div class='send-success'>
					<h3>Спасибо!</h3>
					<p>
						Cейчас начнется скачивание программы.<br>
						Если скачивание не началось, нажмите на эту 
						<a download href=\"Stratagam.pdf\" id=\"download-link\">ссылку</a>
						<script>downloadProgram();</script>
					</p>
				</div>
			";
		}

		$config['user']['sendsuccess'] = $sendsuccess;
  }

	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : '');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : '');
	
	// Не отправлять в Битрикс24 
	$config['ignore']['bitrix24'] = true;
