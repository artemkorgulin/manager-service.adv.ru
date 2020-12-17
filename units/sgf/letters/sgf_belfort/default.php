<?php
$body = "
<h3>Welcome to Synergy Global Inc.!</h3>
<p>Thank you for subscribing to Jordan Belfort’s Straight Line Sales and Persuasion newsletters.</p>
<p>To confirm your subscription, please click the following button:</p>
<p><a href='https://synergyglobal.com/therealwolf/confirm.php?version=confirmed'>Confirm Subscription</a></p>
<p>You will be able to unsubscribe or change your details at any time.</p>
<p>If you have received this email in error and do not intend to join our list, no further action is required on your part.</p>
<p>You won't be subscribed to any list and you won't receive further information until you confirm your subscription above.</p>
";


if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>Welcome to Synergy Global Inc.!</h3>
	<p>Thank you for subscribing to Jordan Belfort’s Straight Line Sales and Persuasion newsletters.</p>
	<p>To confirm your subscription, please click the following button:</p>
	<p><a href='https://synergyglobal.com/therealwolf/confirm.php?version=confirmed'>Confirm Subscription</a></p>
	<p>You will be able to unsubscribe or change your details at any time.</p>
	<p>If you have received this email in error and do not intend to join our list, no further action is required on your part.</p>
	<p>You won't be subscribed to any list and you won't receive further information until you confirm your subscription above.</p>
	";
}

$letter = include 'template.php';
return $letter;