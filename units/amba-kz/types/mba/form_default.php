<?php 
###############################
##### Арсенал #####
###############################

// Конфигуратор FormMessages

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, спасибо за оставленную заявку, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";
		

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = false;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : '');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : ''); // пока пустые


// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «{$lead->program}»";
//$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_arsenal.php';




if($lead->land == 'synergymba-openday-amba-kz'){
	$config['mail']['smtp']['user']['subject'] = "Ваша заявка на день открытых дверей ExecutiveMBA принята!";
	$config['mail']['smtp']['user']['message'] = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<p>Вы успешно зарегистрировались на день открытых дверей Президентской программы Exectutive MBA, который состоится 26 июля 2017 в 20:00.</p>
			<p>Для участия в онлайн-трансляции перейдите по <a target="_blank" href="https://livestream.com/accounts/7155227/events/7111376">ссылке</a>. </p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}

if($lead->land == 'synergymba-amba-kz' || $lead->land == 'inter-amba-kz' || $lead->land == 'mbamini2-amba-kz' || $lead->land == 'minimba-v1-amba-kz' || $lead->land == 'minimba-v2-amba-kz' || $lead->land == 'mba-pocket-amba-kz' || $lead->land == 'sbs-demo-version-emba-amba-kz'){
	$config['mail']['smtp']['user']['subject'] = "Ваша заявка на MBA принята!";
	$config['mail']['smtp']['user']['message'] = '
	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
			<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
		</div>
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
			<h3>Вы сделали правильный выбор! </h3>
			<p>Программы MBA в Школе Бизнеса «Синергия» — это надежные инвестиции в ваше перспективное будущее.</p>
			<p>В ближайшее время с вами свяжется ваш личный менеджер, который поможет подобрать программу, и ответит на все вопросы!</p>
			<p>С уважением, команда <a href="http://synergybusiness.kz/" target="_blank">Школы Бизнеса &laquo;Синергия&raquo;</a></p>
		</div>
		<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2017. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
	</div>
	';
}