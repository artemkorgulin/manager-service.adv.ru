<?php
##########################################
##### ten-errors-ege, ten-errors-oge #####
##########################################
if($lead->land == 'ten-errors-ege') {
	/* Конфигуратор GetResponse*/
	$config['ignore']['getresponse']    = false;
	// Конфигуратор UserMail
	$config['ignore']['send_to_user'] 	= true;
	$config['mail']['smtp']['user']['subject'] 	= "Synergy Online | ТОП-10 ошибок при сдаче ЕГЭ.";
	$config['mail']['smtp']['user']['message'] 	= "
	<div style=\"font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;\">
  	<div style=\"margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;\">
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Поздравляем! Вы зарегистрировались на&nbsp;бесплатный экспресс- курс <b>ТОП-10 ошибок на&nbsp;ЕГЭ</b>, который будет проходить в&nbsp;апреле и&nbsp;мае 2016&nbsp;года.</p>
			<p>Чтобы начать обучение, пройдите по&nbsp;ссылке: <a href=\"http://my.megacampus.ru/user/restricted\" target=\"_blank\">http://my.megacampus.ru/user/restricted</a>.<br>Введите ваш псевдоним - ETop (на&nbsp;англ.раскладке) и&nbsp;пароль – 2348.</p>
			<p>Успешной Вам подготовки!</p>
			<hr style=\"color: #E5E5E5;\">
			<p style=\"color:#505050;\"><i>С уважением, команда Synergy</i><br>
			Тел. <a href=\"tel:88001001746\">8 (800) 100 17 46</a><br>
			Email: <a href=\"mailto:top10_mat11@synergy.ru\">top10_mat11@synergy.ru</a></p>
   	</div>
  	<div style=\"text-align: center; margin-top: 15px; color:#909090; font-size:11px;\">© 2016. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href=\"tel:+74958001001\">+7 (495) 800 10 01</a></div>
	</div>
	";
}


if($lead->land == 'ten-errors-oge' ) {
	/* Конфигуратор GetResponse*/
	$config['ignore']['getresponse']    = false;
	// Конфигуратор UserMail
	$config['ignore']['send_to_user'] 	= true;
	$config['mail']['smtp']['user']['subject'] 	= "Synergy Online | ТОП-10 ошибок при сдаче ЕГЭ.";
	$config['mail']['smtp']['user']['message'] 	= "
	<div style=\"font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;\">
  	<div style=\"margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;\">
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Поздравляем! Вы зарегистрировались на&nbsp;бесплатный экспресс- курс <b>ТОП-10 ошибок на&nbsp;ОГЭ</b>, который будет проходить в&nbsp;апреле и&nbsp;мае 2016&nbsp;года.</p>
			<p>Чтобы начать обучение, пройдите по&nbsp;ссылке: <a href=\"http://my.megacampus.ru/user/restricted\" target=\"_blank\">http://my.megacampus.ru/user/restricted</a>.<br>Введите ваш псевдоним - OTop (на&nbsp;англ.раскладке) и&nbsp;пароль – 0419.</p>
			<p>Успешной Вам подготовки!</p>
			<hr style=\"color: #E5E5E5;\">
			<p style=\"color:#505050;\"><i>С уважением, команда Synergy</i><br>
			Тел. <a href=\"tel:88001001746\">8 (800) 100 17 46</a><br>
			Email: <a href=\"mailto:top10_mat11@synergy.ru\">top10_mat11@synergy.ru</a></p>
   	</div>
  	<div style=\"text-align: center; margin-top: 15px; color:#909090; font-size:11px;\">© 2016. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href=\"tel:+74958001001\">+7 (495) 800 10 01</a></div>
	</div>
";
}

