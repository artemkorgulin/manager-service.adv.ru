<?php
// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было base

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Мастер-класс: {$lead->program}";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_mk.php';


/* http://sbs.edu.ru/lp/kravtsov/mk-v1/ : https://sd.synergy.ru/Task/View/84029 */
if ( $lead->land == 'lp_kravtsov_mk-v1' ) {
	$config['mail']['smtp']['user']['subject'] = "Мастер-класс: {$lead->program}. Только 2 октября";
}
if ( $lead->land == 'kodbiznesa') {
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_mk-kodbiznesa.php';
}