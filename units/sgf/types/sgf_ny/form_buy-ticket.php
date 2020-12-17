<?php
/*
$config['user']['sendsuccess'] = $default_sendsuccess . "<p><a href='' target='_blank'>Перейти к&nbsp;заказу билетов</a></p>";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = $default_sendsuccess . "<p><a href='' target='_blank'>Switch to&nbsp;order tickets</a></p>";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = $default_sendsuccess . "<p><a href='' target='_blank'>Pasar a&nbsp;la&nbsp;reserva de&nbsp;billetes</a></p>";
}
*/

$config['ignore']['send_to_user'] = false;

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<p>
		Спасибо, наш менеджер свяжется с&nbsp;вами и&nbsp;расскажет, как оформить предзаказ.
	</p>
</div>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>
			Your request has been sent!<br>
			We&rsquo;ll follow up&nbsp;by&nbsp;email with details of&nbsp;how to&nbsp;complete your registration (if&nbsp;you don&rsquo;t see the email, check your junk folder).
		</p>
	</div>
	";

	if ( $lead->land == 'sgf2017_en' ) {
		$config['user']['sendsuccess'] = $default_sendsuccess;
	}

	$config['ignore']['send_to_user'] = true;
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>
			&iexcl;Gracias! Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Consulte su&nbsp;email: hemos enviado a&nbsp;su&nbsp;correo la&nbsp;confirmaci&oacute;n de&nbsp;registro en&nbsp;el&nbsp;F&oacute;rum.
		</p>
	</div>
	";
}

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/buy-ticket.php';



//if($_REQUEST['version'] == 'tickets1001' || $_REQUEST['partner'] == 'tickets1001'){
if(true){

	$message = "<div class='send-success'>
			<p>
				Спасибо! Подтверждение вашей регистрации на форум направлено на ваш E-mail. 
				
			</p>
		</div>";

	if($lead->land == 'sgf2017_en_world' || $lead->land == 'sgf2017_en' || $lead->land == 'sgf2017_en_discount'){

		$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.  
				
			</p>
		</div>";

	}

	$config['user']['sendsuccess'] = $message;

}

