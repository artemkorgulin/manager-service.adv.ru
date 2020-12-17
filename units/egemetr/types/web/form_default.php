<?php

	$config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

	// Конфигуратор UserMail
	$config['ignore']['send_to_user'] 	= true;
	$config['mail']['smtp']['from']		= "notice@xn--c1ad7e.xn--p1ai";
	$config['mail']['smtp']['fromname']	= "ЕГЭ.РФ";
	$config['mail']['smtp']['user']['subject'] = "Добро пожаловать на марафон профессий 2017";
	$config['mail']['smtp']['user']['message'] = '

	<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

			<h3>Поздравляем!</h3>

			<p>Ты&nbsp;участник марафона профессий, который даст тебе ответ на&nbsp;главный вопрос: <b>на&nbsp;кого пойти учиться сегодня&nbsp;&mdash; чтобы быть востребованным завтра.</b></p>

			<p>Мы&nbsp;пригласим в&nbsp;нашу студию самых успешных представителей своих направлений, которые на&nbsp;личном опыте расскажут все аспекты удачной карьеры.</p>

			<h3>Профессии будущего</h3>
			<p>Ты&nbsp;узнаешь какие специалисты станут востребованными через несколько лет.</p>

			<h3>Секреты крупных работодателей</h3>
			<p>Наши эксперты не&nbsp;только расскажут про самые перспективные на&nbsp;рынке компании, но&nbsp;и&nbsp;раскроют некоторые секреты успешного трудоустройства.</p>			

			<h3>Интерактивный формат</h3>
			<p>Задавай вопросы онлайн, и&nbsp;получай ответы в&nbsp;прямом эфире!</p>			

			<hr style="color: #E5E5E5;">

			<p><strong>Начало марафона: '.$lead->dater.'</strong></p>
			<p>Ждём тебя: <a href="https://events.webinar.ru/2344632/431849" target="_blank">>>> Перейти <<<</a></p>

			<p><i>А&nbsp;13&nbsp;мая, за&nbsp;день до&nbsp;вебинара, ты&nbsp;получишь полный список профессий будущего.</i></p>

			<hr style="color: #E5E5E5;">
			<p>С&nbsp;уважением, команда ЕГЭ. рф</p>

		</div>
	</div>';

?>