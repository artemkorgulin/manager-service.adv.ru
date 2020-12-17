<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
<p class="text-center">
Спасибо, ваша заявка отправлена!
</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
	<p class="text-center">
	Thank you! Your application has been submitted.
	</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;

$config['ignore']['send_to_cc'] = true;
$config['mail']['smtp']['cc']['emails'] = array(array('MKulikov@synergyglobal.com'));
$config['mail']['smtp']['cc']['subject'] = 'Request Blogger Accreditation';
$message = "
<p>
<br>Name: <b>$lead->name</b>
<br>Phone: <b>$lead->phone</b>
<br>Email: <b>$lead->email</b>
<br>Additional: <b>$lead->comments</b>
<br>---------------
<br>URL: $lead->url
</p>
";
if ( $lead->refer ) {
	$message .= "<p style='font-size:11px;'>Referer: $lead->refer</p>";
}
$config['mail']['smtp']['cc']['message'] = $message;
