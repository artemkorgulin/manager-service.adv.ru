<?php
/* Дефолтные параметры */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account']  = 'drb';
$config['newsletter']['getresponse']['campaign'] = 'eevmenenko';

$link_program = '';

$config['ignore']['send_to_user'] = true;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";

if (!isset($_REQUEST['partner_phone']))
  $partner_phone = '+7 (812) 611-11-48';
else {
  $partner_phone = trim($_REQUEST['partner_phone']);
}
if(isset($_GET['link']) && $_GET['link'] != '') {
	$link_program = '<a href="'.$_GET['link'].'" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Скачать программу</a>';
}
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
