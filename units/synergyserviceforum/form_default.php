<?php
/* Дефолтные параметры */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount)  ? $lead->graccount  : 'drb');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'ssf2016');

$config['ignore']['send_to_user'] = true;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
	<script>location.replace('http://synergyserviceforum.ru/thanks/');</script>
</div>
";

$partner_phone = '+7 (812) 611-11-48';

$config['mail']['smtp']['user']['subject'] = "SSF-2016 – Успешная регистрация!";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/default.php';


if ( $lead->form == 'john-tschohl' ) {
	$config['mail']['smtp']['user']['subject'] = "Выступление Джона Шоула – SSF-2016";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/john-tschohl.php';
}

elseif ( $lead->form == 'program' ) {
	$config['mail']['smtp']['user']['subject'] = "Программа SSF-2016";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/program.php';
}

elseif ( $lead->form == 'catalog' ) {
	$config['mail']['smtp']['user']['subject'] = "Каталог программ Школы Бизнеса «Синергия»";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/catalog.php';
}

elseif ( $lead->form == 'become-sponsor' || $lead->form == 'become-agent' || $lead->form == 'become-partner' ) {
	$config['mail']['smtp']['user']['subject'] = "Партнерство с SSF-2016";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/partner.php';
}
