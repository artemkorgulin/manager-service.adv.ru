<?php 

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
	</div>
";

/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['from']		= "notice@sbs.edu.ru";
$config['mail']['smtp']['fromname']	= "Команда Synergy Art Forum";
$config['mail']['smtp']['user']['subject'] = "Аукцион на Synergy Art Forum";
$config['mail']['smtp']['user']['message'] = "
  <h3>Здравствуйте, {$lead->name}!</h3>  
  <p>Не упустите шанс лично встретиться со спикером Synergy Art Forum!</p>
  <p>Synergy Art Forum совместно с Meet For Charity разыгрывает возможность встретиться с одним из спикеров Synergy Art Forum.</p>
  <p>Победители благотворительного аукциона смогут лично узнать из первых уст всё про современное искусство и просто хорошо провести время за чашкой кофе.</p>
  <p><a href='https://meetforcharity.today/lots/5af998d37a86d3354a4142e1'>Перейдите по ссылке, чтобы сделать ставку</a></p>
  ";

?>