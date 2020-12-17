<?php
if ( $lead->land == 'fedorenko_podpiska') {
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_mk-kodbiznesa.php';
}