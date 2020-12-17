<?php

$email_msg = '';
if(isset($lead->email) && $lead->email != '') {
  $email_msg = "<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>";
}


if (strpos(".synergyonline.ru") === false) {
	$curlSms = curl_init("https://syn.su/smsResponse.php");
	curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
	if ($_REQUEST['land'] != 'police') {
		$responseSms = curl_exec($curlSms);
	}
	curl_close($curlSms);
}
if (in_array($lead->version, array('entrants', 'speciality', 'main-page', 'faculties', 'about', 'popup-postupit', 'first-high'))) {
	// Конфигуратор FormMessages
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		{$email_msg}
		{$DefaultRedirect}
	</div>";
}


###################
##### Условия #####
###################

echo  "<div style='display:none;'>LEADFEED {$lead->form}|{$lead->version}</div>";
if ($lead->version == 'feedback') {
	echo  "<div style='display:none;''>ДОЛЖЕН БЫТЬ (Ваше сообщение успешно отправлено! )</div>";
	// Конфигуратор FormMessages
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Ваше сообщение успешно отправлено! </h3>
		<p>Скоро с вами свяжется наш менеджер.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		{$DefaultRedirect}
	</div>";
}

if($lead->land == 'crm') {
	// Конфигуратор UserMail
	$config['ignore']['send_to_user'] 	= true;
	$config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
	$config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте, {$lead->name}!</h3>
	<p>Вы зарегистрировались на бесплатный семинар с онлайн-трансляцией «{$lead->program}», который состоится {$lead->dater} по адресу: м. «Семеновская», ул. Измайловский Вал, д. 2, стр. 1, аудитория 305.</p>
	<p>Семинар ведет эксперт, спикер факультета Интернета Университета «Синергия» {$lead->speaker}.</p>
	<p>Для участия онлайн мы рекомендуем подключиться к трансляции за 10-15 минут до начала.</p>
	<p><a href='http://geiti.adobeconnect.com/do/' target='_blank'>>> Ссылка на участие >></a></p>
	<hr />
	<p>До встречи!<br />С уважением, Ваша команда Университета «Синергия»<br /> Телефон: 8 (800) 100 00 11</p>";
}

if ($lead->land == 'englishtest') {
		$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>";
		    // проверка на наличие комментария о попытке повтор.прохождения теста
        if(mb_strpos($lead->comments, 'повтор') == false) {
		      $config['user']['sendsuccess'] .= "<script>setTimeout(function(){location.replace(\"http://lingva.edu.ru/lp/english-test/test-manual.php?class={$_REQUEST['class']}&mergelead={$_REQUEST['mergelead']}\"); }, 1000);</script>";
        }
	  $config['user']['sendsuccess'] .= 
	"</div>";
}
