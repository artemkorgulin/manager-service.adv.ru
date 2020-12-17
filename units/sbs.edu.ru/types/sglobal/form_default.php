<?php
/* Правила для копий и версий ленда */
/* =============================== */

/* Для ленда http://synergyglobal.ru/lite/?partner=hr */
if(isset($_REQUEST['land']) && $_REQUEST['land'] == 'sglobal-lite'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<div class='formtitle'>Отлично, {$lead->name}!</div>
		<p>Скоро мы с вами свяжемся.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

/* Для ленда http://sbs.edu.ru/lp/treisy/cl-v1/?partner=dp2 */
elseif(isset($_REQUEST['land']) && $_REQUEST['land'] == 'Zhestkiye-peregovory') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h4>Ваше участие<br>успешно подтверждено!</h4>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, на вашу почту <b>{$lead->email}</b> придет письмо с дальнейшими инструкциями.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

	$config['ignore']['send_to_user'] = false;
}

/* Правила для основного ленда */
/* ========================== */

/* Для формы быстрой регистрации "Пожалуйста, зарегистрируйтесь" */
elseif(isset($_REQUEST['form']) && $_REQUEST['form'] == 'register-quick'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<div class='formtitle'>Ваше участие успешно подтверждено!</div>
		<p>Проверьте Ваш почтовый ящик {$lead->email}, на&nbsp;который придет письмо с&nbsp;дальнейшими инструкциями.</p>
		<a class='button button1 close-link' href=''>Закрыть окно</a>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

/* Для формы "Скачать программу" */
elseif(isset($_REQUEST['form']) && $_REQUEST['form'] == 'program'){
	/* Для китайской версии */
	if ($_REQUEST['lang'] && $_REQUEST['lang'] == 'cn') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>非常好，{$lead->name}!</div>
			<p><a class='button button1' href='http://synergyglobal.ru/booklet.pdf' target='_blank'>计划</a></p>
			<a class='button button1 close-link' href=''>近</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
	/* Для остальных версий */
	else {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>Отлично, {$lead->name}!</div>
			<p><a class='button button1' href='http://synergyglobal.ru/booklet.pdf' target='_blank'>Посмотреть программу</a></p>
			<a class='button button1 close-link' href=''>Закрыть окно</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
}

/* Для формы "Скачать приложение" */
elseif(isset($_REQUEST['form']) && $_REQUEST['form'] == 'application'){
	/* Для китайской версии */
	if ($_REQUEST['lang'] && $_REQUEST['lang'] == 'cn') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>非常好，{$lead->name}!</div>
			<p>很快我们将通过电子邮件给您发送一个链接到下载应用程序 {$lead->email}</p>
			<a class='button button1 close-link' href=''>接续</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
	/* Для остальных версий */
	else {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>Отлично, {$lead->name}!</div>
			<p>Скоро мы пришлем вам ссылку на скачивание приложения на почту {$lead->email}</p>
			<a class='button button1 close-link' href=''>Продолжить серфинг</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
}

/* Для форм "Стать спонсором" и "Стать партнером" */
elseif(isset($_REQUEST['form']) && ($_REQUEST['form'] == 'register-partner' || $_REQUEST['form'] == 'register-sponsor')){
	/* Для китайской версии */
	if ($_REQUEST['lang'] && $_REQUEST['lang'] == 'cn') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>非常好，{$lead->name}!</div>
			<p>很快我们将通过电子邮件给您发送一个链接到下载应用程序 {$lead->email}</p>
			<a class='button button1 close-link' href=''>接续</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
	/* Для остальных версий */
	else {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<div class='formtitle'>Отлично, {$lead->name}!</div>
			<p>Скоро мы с вами свяжемся.</p>
			<a class='button button1 close-link' href=''>Ок</a>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
	}
}

/* Для формы "Скачать мастер-класс" */
elseif(isset($_REQUEST['form']) && $_REQUEST['form'] == 'download-mc'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<div class='formtitle'>Отлично, {$lead->name}!</div>
		<p>Скоро мы пришлем вам ссылку на скачивание мастер-класса на почту {$lead->email}</p>
		<a class='button button1 close-link' href=''>Продолжить серфинг</a>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

/* Для формы "Получить мастер-класс" Ицхака Адизеса после попапа "Уже уходите?" */
elseif(isset($_REQUEST['form']) && $_REQUEST['form'] == 'mk-adizes'){
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<div class='formtitle'>Отлично, {$lead->name}!</div>
		<p>Мы пришлем вам ссылку на скачивание мастер-класса на почту {$lead->email}</p>
		<a class='button button1 close-link' href=''>Продолжить серфинг</a>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

/* Для общей формы регистрации с оплатой */
else {

	/* Для partner=sglobal-bdl */
	if(isset($_REQUEST['partner']) && $_REQUEST['partner'] == 'sglobal-bdl'){
		$config['ignore']['bitrix24'] 	= true;
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h4>Ваше участие<br>успешно подтверждено!</h4>
			<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, на вашу почту <b>{$lead->email}</b> придет письмо с дальнейшими инструкциями.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";
		/* Конфигуратор MessageForCallCentre */
		$config['ignore']['send_to_cc'] = true;
		$config['mail']['smtp']['cc']['emails'] = array(array('anufriev@ngenium.ru', 'khuraeva@ngnear.ru'));
		$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда SynergyGlobal";
		$config['mail']['smtp']['cc']['message'] = "
		<p>
			Имя: <b>$lead->name</b>
			<br />Телефон: <b>$lead->phone</b>
			<br />Email: <b>$lead->email</b>
			<br />-----
			<br />Город: <b>$lead->city</b>
			<br />Источник: <b>$lead->source</b>
			<br />Адрес страницы: $lead->url
			<br />-----------------------------------------
		</p>
		<p style='font-size:11px;'>Реферер: $lead->refer</p>";
	}

	/* Для partner=spb */
	elseif(isset($_REQUEST['partner']) && $_REQUEST['partner'] == 'spb'){
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h4>Ваше участие<br>успешно подтверждено!</h4>
			<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, на вашу почту <b>{$lead->email}</b> придет письмо с дальнейшими инструкциями.</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";

		/* Конфигуратор UserMail */
		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
		$config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы успешно зарегистрировались на «Synergy Global Forum»</p>
		<p>В ближайшее время с Вами свяжется личный менеджер, чтобы уточнить условия участия и ответить на все ваши вопросы.</p>
		<hr />
		<p>До встречи! <br />Школа бизнеса «Синергия», www.sbs.edu.ru <br />тел. 8 (812) 611-11-48</p>
		";
	}

	/* Для китайской версии */
	elseif ($_REQUEST['lang'] && $_REQUEST['lang'] == 'cn') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h4>您的参与是成功地证实</h4>
			<p>{$lead->name},您已成功注册了一个事件，检查您的邮件<b>{$lead->email}</b>，这将收到一封信，进一步的指示。</p>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";

		/* Конфигуратор UserMail */
		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "您的应用程序已收到！";
		$config['mail']['smtp']['user']['message'] 	= "<h3>您好，尊敬的 {$lead->name}</h3>
		<p>您成功注册了Synergy Global Forum</p>
		<p>私人经理近期联系您以便于明确参与的条件和回答您的问题</p>
		<p>我们提醒您，在任何时候，您可以利用方便系统在线支付您的参与</p>
		<p>您选择了一个价值{$lead->cost}美元的一套{$_POST['pack']}，您可以在下面的链接上支付。</p>
		<p><a href='https://synergy-global-forum.ticketforevent.com/ru/?name={$lead->name}&phone={$lead->phone}&email={$lead->email}' target='_blank'>>>现在支付>></a></p>
		<br/>在支付页面您可以选择12个方便和安全的支付方式之一
		<br>这样您就可以节省时间和精力，而您也不用担心小事情。您将能够专注于主要的事情-获得实际能力。</p>
		<hr />
		<p>待会儿见！ <br />商学院 “Synergy”  www.sbs.edu.ru <br />+7 (495) 545-43-14</p>
		";
	}

	/* Для русской версии */
	else {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h4>Ваше участие<br>успешно подтверждено!</h4>
			<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
			<br>
			<p>Сейчас вы будете перенаправлены на страницу выбора места и online-оплаты, если этого не произошло автоматически, <a href='https://synergy-global-forum.ticketforevent.com/ru/?name={$lead->name}&phone={$lead->phone}&email={$lead->email}' target='_blank'>нажмите здесь</a>.</p>
			<script>setTimeout(function(){ location.replace('https://synergy-global-forum.ticketforevent.com/ru/?name={$lead->name}&phone={$lead->phone}&email={$lead->email}') }, 0);</script>
			<script>$('document').ready(function(){Hash.add('send','ok');});</script>
		</div>";

		/* Конфигуратор UserMail */
		$config['ignore']['send_to_user'] = false;
		$config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
		$config['mail']['smtp']['user']['message'] 	= "<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы успешно зарегистрировались на «Synergy Global Forum»</p>
		<p>В ближайшее время с Вами свяжется личный менеджер, чтобы уточнить условия участия и ответить на все ваши вопросы.</p>
		<p>Напоминаем, что в любой момент вы можете воспользоваться удобной системой online-оплаты вашего участия.</p>
		<p>Вы выбрали пакет {$_POST['pack']} стоимостью {$lead->cost} рублей, оплатить вы можете по ссылке ниже.</p>
		<p><a href='https://synergy-global-forum.ticketforevent.com/ru/?name={$lead->name}&phone={$lead->phone}&email={$lead->email}' target='_blank'>>> Перейти к оплате сейчас >></a></p>
		<br/>На странице оплаты вы можете выбрать один из 12 удобных и безопасных способов проведения платежа, а процесс оплаты займет не более 2 минут.
		<br>Так вы сэкономите силы и время, и вам не придется беспокоиться о мелочах. Вы сможете сосредоточиться на главном — получении актуальных компетенций.</p>
		<hr />
		<p>До встречи! <br />Школа бизнеса «Синергия», www.sbs.edu.ru <br />тел. +7 (495) 545-43-14</p>
		";
	}
}

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sgf');