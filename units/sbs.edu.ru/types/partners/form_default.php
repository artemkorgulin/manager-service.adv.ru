<?php
###################################
##### Партнерское предложение #####
###################################

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
$config['mail']['smtp']['user']['message'] 	= "<h3>{$lead->name}, поздравляем!</h3>
    <p>Вы&nbsp;решили стать партнером Школы Бизнеса &laquo;Синергия&raquo; и&nbsp;получать агентское вознаграждение от&nbsp;25% за&nbsp;продвижение наших образовательных продуктов и&nbsp;главных бизнес-событий страны.</p>
    <p>В&nbsp;ближайшее время с&nbsp;вами свяжется менеджер, который предоставит подробную информацию и&nbsp;будет курировать вас на&nbsp;всех этапах работы.</p>
<!--	<p><b>Вы стали партнером Synergy Global Forum — самого крупного бизнес-события 2015 года на территории РФ. Вместе мы сделаем Форум мирового масштаба, где соберется более 6000 единомышленников, заинтересованных в качественном бизнес-образовании, расширении деловых контактов и масштабировании своего бизнеса.</b></p>
<p>25 мая в 11:00 мы ждем вас на специальном вебинаре для партнеров, где мы обсудим все организационные вопросы. Ссылка для участия в вебинаре:
	<br> <a href='https://geiti.adobeconnect.com/business_synergy'> >> Участвовать >> </a></p>
	<p><b>Ваш уникальный код</b><br>Для учета клиентов, которые пришли от Вас, мы используем привязку к cookie клиента. Мы уже сгенерировали для Вас уникальный код, который будем использовать для учета траффика с ваших ресурсов.</p>
	<p><b>Ваш уникальный код партнера: $new_utm_mark</b></p>
	<p>Ваша ссылка на Synergy Global Forum будет выглядеть так: http://www.synergyglobal.ru/?partner=$new_utm_mark</p> -->
<!--	<p>Пожалуйста, прочитайте <a href='http://synergy.ru/lander/alm/worker/mail_attach/sbs.edu.ru/agent_doc.doc'>договор</a> для юридических лиц, который мы планируем с вами заключить. Если возникли вопросы, задайте их вашему куратору:<br>
	Ангелина Арутюнян <br>
	+7(495) 545-43-14, доб. 1206 <br>
	AArutyunyan@synergy.ru </p>-->
	<hr />
	<p>С уважением,<br />отдел по работе с агентами,<br />+7 (495) 545-43-14<br />agents@synergy.ru <br />www.sbs.edu.ru <br />.</p>";
$config['mail']['smtp']['user']['file_send'] = false;
$config['mail']['smtp']['user']['files'] = array('mail_attach/sbs.edu.ru/agent_doc.doc');

// Конфигуратор MessageForCallCentre
$config['ignore']['send_to_cc'] = false;
$config['mail']['smtp']['cc']['emails'] = array(array('AArutyunyan@synergy.ru'));
$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда $lead->land [$lead->source]";
$config['mail']['smtp']['cc']['message'] = "
			<p>Имя: <b>$lead->name</b>
			<br />Телефон: <b>$lead->phone</b>
			<br />Email: <b>$lead->email</b>
			<br />Компания: <b>$lead->company</b>
			<br />-----
			<br />Город: <b>$lead->city</b>
			<br />Источник: <b>$lead->source</b>
			<br />Адрес страницы: $lead->url
			<br />-----------------------------------------</p>
			<p style='font-size:11px;'>Реферер: $lead->refer</p>";