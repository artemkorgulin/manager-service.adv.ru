<?php
	/* Конфигуратор FormMessages */
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо!</h3>
		<p>Заявка успешно отправлена.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";


	// Конфигуратор MessageForCallCentre
	$config['mail']['smtp']['from']		= "noreply@synergy.film";
	$config['mail']['smtp']['fromname']	= "Всероссийский конкурс молодежных короткометражных фильмов";

	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject'] 	= "Подтверждение заявки на участие";
	$config['mail']['smtp']['user']['message']  = "
		<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
			<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
				<h3>Здравствуйте, {$lead->name}!</h3>
				<p>Ваша заявка на участие во Всероссийском конкурсе молодежных короткометражных фильмов «Молодежь в ответе за будущее планеты» принята!</p>
				<p>Конкурс формируется до 31 октября 2017 года. </p>
				<p>В случае отбора вашего фильма в Конкурс, с вами свяжутся по указанным контактам. </p>

				<hr style='color: #E5E5E5;'>
				<p style='color:#505050;'><i>С&nbsp;уважением, оргкомитет.</p>
				<p><a href='mailto:film@synergy.ru'>film@synergy.ru</a></p>
			</div>
		</div>
	";