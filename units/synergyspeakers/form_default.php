<?php
###############################
### Synergy Speakers Bureau ###
###############################


/* Дефолтный обработчик */
$config['mail']['smtp']['user']['subject'] = "Synergy Speakers Bureau: ваша заявка на консультацию";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_synergyspeakers.php';

$config['ignore']['send_to_user'] = true;
$config['ignore']['getresponse'] = true;


$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо за вашу заявку!</h3>
	<p>Мы свяжемся с&nbsp;вами в&nbsp;ближайшее время, расскажем больше о&nbsp;наших возможностях и&nbsp;ответим на&nbsp;все ваши вопросы.</p>
</div>
";


if( $lead->form == 'themes' ) {
	$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо за вашу заявку!</h3>
			<p>Мы свяжемся с&nbsp;вами в&nbsp;ближайшее время и&nbsp;представим варианты спикеров по&nbsp;выбранной вами тематике.</p>
		</div>
		";
}

?>