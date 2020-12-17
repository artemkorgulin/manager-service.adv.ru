<?php
##################
##### Лекции #####
##################

/* Пример - http://synergylectorium.ru/mk-serga/ */


/* Дефолтные значения */
/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы&nbsp;успешно зарегистрировались на&nbsp;лекцию, ссылку для&nbsp;участия вы&nbsp;получите на&nbsp;вашу почту <b>{$lead->email}</b>.</p>
</div>
";

/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на лекцию: {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_lect.php';

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sm');


/* Переопределения для лендов */
if($lead->land == 'synergylectorium-kou-boomstarter'){
	$config['mail']['smtp']['user']['subject'] = "Заявка на платный курс от экспертов Boomstarter";
}

elseif($lead->land == 'synergylectorium-mk-hleb'){
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_hleb.php';
}

elseif ($lead->land == 'kou-blackstar') {
	$config['mail']['smtp']['user']['subject'] = "Заявка на платный курс Black Star";
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно оставили заявку на участие в платном курсе Мечта.Цель.Результат от Black Star inc. Подтверждение отправлено на вашу почту <b>{$lead->email}</b>.</p>
	</div>
	";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_blackstar.php';
}

elseif ($lead->land == 'lectorium_sopelnik_kou-v1') {
	$config['mail']['smtp']['user']['subject'] = "Заявка на платный курс Артура Сопельник";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_sopelnik.php';
}
elseif ($lead->land == 'lp_oge__'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами для уточнения деталей обучения и&nbsp;с&nbsp;удовольствием ответит на&nbsp;все возникшие вопросы!</p>
	</div>
	";
	$config['mail']['smtp']['user']['subject'] = "Регистрация на подготовительные курсы \"ОГЭ без барьеров\"";
	$config['mail']['smtp']['user']['message'] = "<p>Спасибо за регистрацию на программу!</p><p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами для уточнения деталей обучения и&nbsp;с&nbsp;удовольствием ответит на&nbsp;все возникшие вопросы!</p>";
}

elseif ($lead->land == 'acting'){
	$config['mail']['smtp']['user']['subject'] = "Артур Сопельник приглашает на курсы Актерского Мастерства.";
	$config['mail']['smtp']['user']['message'] = "<p>Спасибо за&nbsp;проявленный интерес!</p>
	<p>Артур Сопельник продолжает набор на&nbsp;курсы актерского мастерства.</p>
	<p>Хочешь стать актёром и&nbsp;освоить методики Щепкинского училища за&nbsp;2&nbsp;месяца?</p>
	<p><a href='http://synergylectorium.ru/lp/acting/' target='_blank'>>>>Присоединяйся<<<</a></p>
	<hr>
	<p>С уважением, <br>
	команда Synergy Lectorium.</p>";
	if($lead->form == 'middle') {
		$config['mail']['smtp']['user']['subject'] = "Спасибо за ваш вопрос! ";
		$config['mail']['smtp']['user']['message'] = "<p>Мы обязательно передадим Ваш вопрос Артуру! <br>Вероятно, именно вы станете победителем!</p>
		<hr>
		<p>С уважением, <br>
		команда Synergy Lectorium.</p>";
	} elseif ($lead->form == 'acting') {
		$config['mail']['smtp']['user']['subject'] = "Регистрация на открытую лекцию Артура Сопельник";
		$config['mail']['smtp']['user']['message'] = "<p>Ура!</p>
		<p>Теперь вы участник бесплатной лекции проекта Synergy Lectorium.</p>
		<p><b>{$lead->dater}</b>, звезда театра и&nbsp;кино ждёт вас в&nbsp;гости!</p>
		<p>Не пропусти!</p>
		<p><b>Время:</b> " . $_POST['time'] . " <br>
		<b>Место:</b> м.&nbsp;«Семеновская», ул.&nbsp;Измайловский Вал, д.&nbsp;2, стр.&nbsp;1 (конференц-зал)</p>
		<p>Не&nbsp;можешь присутствовать лично? Подключайся к&nbsp;онлайн-трансляции. <br>
		<a href='http://synergylectorium.ru/lp/acting/' target='_blank'>Ссылка</a></p>
		<hr>
		<p>С уважением, <br>
		команда Synergy Lectorium.</p>";
	}
}