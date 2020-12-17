<?php
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";


	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_bp');
	
	if($lead->form == 'partner' || $lead->form == 'info-partner' || $lead->form == 'sponsor') {
		$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Спасибо, ваша заявка успешно отправлена!</h3>
				<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
			</div>";
	}
	else if($lead->form == 'presentation') {
		$config['ignore']['send_to_user'] 	= true;
		$config['mail']['smtp']['user']['subject'] 	= "Презентация военно-исторического шоу «Брусиловский прорыв»";
		$config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте!</h3>
			<p>Скачать презентацию шоу «Брусиловский прорыв» вы можете, пройдя по ссылке <a href='http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/presentation.pdf' target='_blank'>Скачать презентацию</a>.</p>
			<p>Регистрируйтесь на мероприятие на сайте <a href='http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/' target='_blank'>брусиловскийпрорыв.рф</a></p>
			<p>Участие бесплатное!</p>
			<hr>
			<p>С уважением, <br>
			команда организаторов шоу «Брусиловский прорыв»</p>";
	}
	else {
		$config['ignore']['send_to_user'] 	= true;
		$config['mail']['smtp']['user']['subject'] 	= "Регистрация на историческое шоу «Брусиловский прорыв»";
		$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_brusilov.php';
	}