<?php
/* Defaults */
$config['user']['sendsuccess'] = "
<div class='send-success'>
<h3>Заявка успешно отправлена!</h3>
<p>Cпасибо, мы&nbsp;свяжемся с&nbsp;вами в&nbsp;ближайшее время.</p>
</div>
";

$config['ignore']['send_to_user'] = false;


/* Ленды */
/* https://synergyglobal.ru/lp/tyson/ */
if ($lead->land == 'tyson') {
	/*$config['mail']['smtp']['user']['subject'] = 'Вы успешно зарегистрировались на конкурс "Выиграй билет на программу Майка Тайсона"';
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/sgf_competition/mail_tyson.php';*/
}

/* Заготовка для следующих лендов */
elseif ($lead->land == 'pupkin') {
	/*$config['mail']['smtp']['user']['subject'] = 'Вы успешно зарегистрировались на конкурс "Выиграй билет на программу Васи Пупкина"';
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/sgf_competition/mail_pupkin.php';*/
}

