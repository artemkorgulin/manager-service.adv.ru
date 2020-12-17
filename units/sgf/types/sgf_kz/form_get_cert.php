<?php

$config['ignore']['send_to_user'] = false;

$fullname = $_REQUEST['name2'] . '%%20' . $_REQUEST['name'] . '%%20' . $_REQUEST['name3'];

$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = 'synergy';
$config['newsletter']['getresponse']['campaign'] = 'reg_almaty';

$config['user']['sendsuccess'] = '
		<div class="send-success">
			<h3>Спасибо!</h3>
			<p>Сертификат будет автоматически скачан в течение 5 секунд...</p>
		</div>
		<script>
			setTimeout(function(){

				$("body").append("<iframe src=\"https://payment.1001tickets.org/?method=getPdfWithUrl&orient=landscape&url=http://synergyglobal.kz/certificate/gen?name='.$fullname.'\" style=\"border:0;width:0;height:0;\"></iframe>");

			}, 3000);
		</script>
	';

?>