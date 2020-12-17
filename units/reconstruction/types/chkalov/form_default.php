<?php

$config['ignore']['bitrix24'] = true;

$config['ignore']['send_to_user'] = true;

$config['ignore']['getresponse'] = false;
//$config['newsletter']['getresponse']['account']  = 'synergy';
//$config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_storm_berlin';

$hiddenForm = "<script>$('div.popup__title, div.popup__about').remove();</script>";

$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3 class='popup__title'>Спасибо! <br>ваша заявка отправлена</h3>
			<p class='popup__about'>Наш менеджер свяжется с&nbsp;вами в&nbsp;ближайшее время.</p>
		</div>{$hiddenForm}";

switch($_REQUEST['form']){

	case 'ticket':

	$config['mail']['smtp']['user']['subject'] 	= "Спасибо за регистрацию на авиашоу «Чкалов»!";
	$config['mail']['smtp']['user']['message'] 	= "<h3>Поздравляем!</h3>
			<p>Вы&nbsp;успешно зарегистрировались на&nbsp;Авиационный фестиваль &laquo;Чкалов&raquo;, который пройдет 23&nbsp;сентября 2017 года на&nbsp;военном аэродроме &laquo;Кубинка&raquo;. В&nbsp;ближайшее время с&nbsp;вами свяжется наш менеджер и&nbsp;расскажет обо всех условиях участия в&nbsp;мероприятии.</p><br>
			<b>На&nbsp;авиашоу вы&nbsp;увидите:</b><br>
			<ul>
				<li>Турнир &laquo;Авиаслалом&raquo;&nbsp;&mdash; первое в&nbsp;России соревнование по&nbsp;авиаслалому с&nbsp;выполнением фигур высшего пилотажа</li>
				<li>Показательные полеты &laquo;Аэроклуба ветеранов военной службы&raquo; и&nbsp;авиагрупп &laquo;Стрижи&raquo; и&nbsp;&laquo;Русские Витязи&raquo;</li>
				<li>Воздушный бой исторических самолетов от&nbsp;чешской авиагруппы Pterodactyl Flights</li>
				<li>Авиамодельное шоу самолетов Великой Отечественной войны</li>
				<li>Концерт с&nbsp;участием заслуженных артистов РФ </li>
			</ul><br>
			<b>А&nbsp;также сможете посетить интерактивные площадки:</b>
			<ul>
				<li>Выставка самолётов (от&nbsp;моделей Первой мировой войны и&nbsp;до&nbsp;новейших образцов)</li>
				<li>Авиационные тренажеры для обучения будущих пилотов</li>
				<li>Воздушный бой реплик самолетов Первой мировой войны</li>
				<li>Школа воздушных асов</li>
				<li>Курс молодого парашютиста</li>
			</ul>
			<hr>
			<p>С&nbsp;уважением,<br>
			команда Авиационного фестиваля &laquo;Чкалов&raquo;</p>";

	break;

	case 'ticket-cost':

	$redirectLink = 'about:blank';

	$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3 class='popup__title'>Спасибо! <br>ваша заявка отправлена</h3>
			<p class='popup__about'>Через 5 секунд вы будете автоматически перенаправлены на страницу оплаты. Если этого не произошло, перейдите по ссылке: <br><a href='{$redirectLink}' target='_blank'>Перейти к оплате</a></p>
		</div>{$hiddenForm}
		<script>
			setTimeout( function(){ window.open('{$redirectLink}') }, 5000);
		</script>";

	break;

	case 'presentation':

		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3 class='popup__title'>Спасибо! <br>ваша заявка отправлена</h3>
			<p class='popup__about'>Пожалуйста, проверьте свою электронную почту&nbsp;&mdash; мы&nbsp;направили на&nbsp;неё ссылку на&nbsp;подробную презентацию авиационного фестиваля.</p>
		</div>{$hiddenForm}";

		$config['mail']['smtp']['user']['subject'] 	= "Презентация шоу-программы авиационного фестиваля Чкалов";
		$config['mail']['smtp']['user']['message'] 	= "<h3>Добрый день!</h3>
			<p>Вы&nbsp;оставляли заявку на&nbsp;получение презентации Авиационного фестиваля &laquo;Чкалов&raquo; Скачать презентацию вы&nbsp;можете, пройдя по&nbsp;ссылке: <a href='http://чкаловфест.рф/img/present.pdf' target='_blank'>Скачать презентацию</a></p>
			<p>
			<hr>
			<p>С&nbsp;уважением,<br>
			команда Авиационного фестиваля &laquo;Чкалов&raquo;</p>";


	break;	

}

?>