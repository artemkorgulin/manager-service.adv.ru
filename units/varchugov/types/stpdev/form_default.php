<?php

$partner = '';

if (isset($_REQUEST['partner']) && preg_match('([A-Z]{4})', $_REQUEST['partner'])) {
	$partner = $_REQUEST['partner'];
}

$defaultUrl = "http://stpdev.varchugov.dev02.synergy.ru/?name={$lead->name}&email={$lead->email}&phone={$lead->phone}&mergelead={$lead->mergelead}&partner={$partner}&price_scheme=1";

$DefaultEmailMessage = "<a href='".$defaultUrl."' target='_blank'>Ссылка на выбор билетов</a>";

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
</div>
<a href='".$defaultUrl."' target='_blank'>Сюда будет редирект</a>
";

$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] 	= "Ссылка на выбор билетов";
$config['mail']['smtp']['user']['message']  = $DefaultEmailMessage;

?>