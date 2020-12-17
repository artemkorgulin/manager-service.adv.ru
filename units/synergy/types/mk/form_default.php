<?php
if($lead->land == 'synergylectorium-synthesizing') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо за&nbsp;регистрацию!</h3><!-- DEFAULT -->
        <p>Совсем скоро ты&nbsp;получишь на&nbsp;почту информацию о&nbsp;лекции и&nbsp;ссылку на&nbsp;просмотр.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

// Конфигуратор UserMail
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Мастер-класс: {$lead->program}";
    $config['mail']['smtp']['user']['message'] 	= "
    Здравствуйте, {$lead->name}!<br>
    <br>
    Вы зарегистрировались на {$lead->program}, который состоится {$lead->dater}.<br>
    <br>
    Ждем вас по адресу: г. Москва, м. «Семеновская», ул. Измайловский Вал, д. 2, стр. 1<br>
    <br>
    До встречи!<br>
    С уважением,<br>
    Ваша команда Университета «Синергия»
    ";

    $config['mail']['smtp']['user']['subject'] = "Регистрация на мастер-класс: {$lead->program}";
   $config['mail']['smtp']['user']['message'] = include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/synergy.ru/letters/mail_degtyarev.php';
}

elseif($lead->land == 'synergylectorium-alibasov') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо, ваше сообщение получено!</h3><!-- DEFAULT -->
        <p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";

// Конфигуратор UserMail
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Мастер-класс: {$lead->program}";
    $config['mail']['smtp']['user']['message'] 	= "
    Здравствуйте, {$lead->name}!<br>
    <br>
    Вы зарегистрировались на {$lead->program}, который состоится {$lead->dater}.<br>
    <br>
    Ждем вас по адресу: г. Москва, м. «Семеновская», ул. Измайловский Вал, д. 2, стр. 1<br>
    <br>
    До встречи!<br>
    С уважением,<br>
    Ваша команда Университета «Синергия»
    ";

	$config['mail']['smtp']['user']['subject'] = "Регистрация на мастер-класс: {$lead->program}";
	$config['mail']['smtp']['user']['message'] = include_once $_SERVER['DOCUMENT_ROOT'] . '/lander/alm/synergy.ru/letters/mail_alibasov_sm.php';
}
elseif($lead->land == '	synergy-kak-stat-luchshim-man-aev') {
// Конфигуратор GetResponse
	$config['ignore']['getresponse'] = false;
	$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');
}
elseif($lead->land == 'filmfaculty') {
    $config['ignore']['send_to_user'] = false;
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	    <h3>Заявка успешно отправлена!</h3>
		<p>В ближайшее время с Вами свяжется наш менеджер.</p>
	</div>";
}
else{
// Конфигуратор FormMessages
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Доступ предоставлен!</h3>
		<p>Через мгновение вы попадете на страницу с мастер-классом, если этого не произошло автоматически, нажмите кнопку ниже.</p> <br />
		<a href='{$link}' class='btn-redirect' target='_blank'>Посмотреть мастер-класс »</a>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		{$redirect}
	</div>";
}


if($lead->land == 'synergy-kak-stat-luchshim-man-aev') {
// Конфигуратор GetResponse
	$config['ignore']['getresponse'] = false;
	$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : '');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : '');
}
else {
	// Конфигуратор GetResponse
	$config['ignore']['getresponse'] = true;
	$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_regular_wb');
}
