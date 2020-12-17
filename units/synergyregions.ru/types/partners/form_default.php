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
    <p>Вы&nbsp;решили стать партнером Школы Бизнеса &laquo;Синергия&raquo; и&nbsp;получать агентское вознаграждение от&nbsp;15% за&nbsp;продвижение наших образовательных продуктов и&nbsp;главных бизнес-событий страны.</p>
    <p>В&nbsp;ближайшее время с&nbsp;вами свяжется менеджер, который предоставит подробную информацию и&nbsp;будет курировать вас на&nbsp;всех этапах работы.</p>


	<hr />
	<p>С уважением,<br />Школа бизнеса &laquo;Синергия&raquo;,<br />+7 (495) 800-10-01 доб. 3343<br />synergydrb@gmail.com <br />www.synergyregions.ru <br /></p>";
$config['mail']['smtp']['user']['file_send'] = false;
$config['mail']['smtp']['user']['files'] = array('mail_attach/sbs.edu.ru/agent_doc.doc');

// Конфигуратор MessageForCallCentre
$config['ignore']['send_to_cc'] = false;
$config['mail']['smtp']['cc']['emails'] = array(array('synergydrb@gmail.com'));
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