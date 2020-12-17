<?php
$siteurl = 'c-pp.ru';

$config['ignore']['bitrix24'] = false;
$config['ignore']['send_to_cc'] = true;

$config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

$config['mail']['smtp']['from'] = 'notice@c-pp.ru';
$config['mail']['smtp']['cc']['emails'] = array(array('EOreshok@synergy.ru','akoloskova@synergy.ru'));

$subject = 'Получено обращение с сайта '.$siteurl;
include_once UNIT_DIR.'/letters/mail_cc_default.php';

switch ($lead->form) {
    case 'training':
        include_once UNIT_DIR.'/letters/mail_user_training.php'; // письмо для пользоателя
        $config['ignore']['send_to_user'] = true;

        include_once UNIT_DIR.'/letters/mail_сс_training.php'; // письмо для нашего сотрудника
        break;
    case 'conference':
        include_once UNIT_DIR.'/letters/mail_user_conference.php'; // письмо для пользоателя
        $config['ignore']['send_to_user'] = true;

        include_once UNIT_DIR.'/letters/mail_сс_conference.php'; // письмо для нашего сотрудника
        break;
    case 'rightform':
        include_once UNIT_DIR.'/letters/mail_сс_default.php'; // письмо для нашего сотрудника
        break;
}

$config['mail']['smtp']['user']['subject'] = $subject;
$config['mail']['smtp']['user']['message'] 	= $str;

$config['mail']['smtp']['cc']['subject'] = $subject;
$config['mail']['smtp']['cc']['message'] = $str_cc;

$lead->name = $_REQUEST['surname'] . ' ' . $_REQUEST['name'];
