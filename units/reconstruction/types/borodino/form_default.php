<?php

$config['ignore']['bitrix24'] = true;
$config['ignore']['send_to_user'] = true;

$config['ignore']['getresponse'] = false;
// $config['newsletter']['getresponse']['account']  = 'synergy';
// $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_borodino';

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо, ваша заявка успешно отправлена!</h3>
		<p>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
	</div>";

$config['mail']['smtp']['user']['subject'] = "Регистрация на военно-историческую реконструкцию Бородино 1812";
$config['mail']['smtp']['user']['message'] = "<h3>Добрый день!</h3>
	<br>
	<p>Вы зарегистрировались на Историческое шоу Олега Соколова, который состоится 19 мая в КСК «БИТЦА». Спасибо за регистрацию!</p>
	<p>Вас ждет незабываемое зрелище:</p>
	<p>
		<ul>
			<li>Сотни пехотинцев в форме 1812 года</li>
			<li>Десятки гусар и кирасиров</li>
			<li>Масса взрывов пиротехники</li>
			<li>Работа каскадеров</li>
			<li>Интерактивные площадки</li>
		</ul>
	</p>
	<br><br>
	<p>С уважением,<br>
	Команда организаторов Исторического шоу Олега Соколова. </p>";

?>