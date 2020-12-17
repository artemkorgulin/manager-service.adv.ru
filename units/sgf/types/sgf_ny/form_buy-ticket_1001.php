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
				<br><a href='#' class='open1001'><u>Выбрать билеты</u></a>
			</p>
		</div>";

	if($lead->land == 'sgf2017_en_world' || $lead->land == 'sgf2017_en' || $lead->land == 'sgf2017_en_discount'){

		$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.  
				<br>Redirecting to <a href='#' class='open1001'><u>payment system...</u></a>
			</p>
		</div>";

	}

	$promocodes = Array(
			'd78b5826989b28eed9e8c4f7322fd77c'=>'PARTNER5SGF0',
			'72450851ac3dfc234d3485722c117188'=>'PARTNER4SGF0',
			'3baa2ae608d27ae19412a21516d530ca'=>'PARTNER3SGF0',
			'bc6ec72a28a01d75ba925d014945e822'=>'PARTNER2SGF0',
			'563bb3f02e0eb79b465a7faad2cc8739'=>'PARTNER1SGF0',
			'6e3e4635e4248f891f16c93c8de64deb'=>'PARTNERSG3F5',
			'0d7e19e5d30d03b1d7d472691199f8a9'=>'PARTNERSG5F0',
			'741baaf2e81500c95d86b8274c79422a'=>'PARTNERSG3F0',
			'89374hgkjfdh897hkjdfhf34987hkjdf'=>'sgfstudent350',
			'kdfjng8974nfksjfdnweklfn4w33trnl'=>'sgfstudent450',
			'dlfjgnlkweruqpdv23235fgdsg3kqppb'=>'sgfstudent300',
			'sdljfni43unf9usdfnkjwnn23n098jfj'=>'sgfstudent400',
			'lgtjkoieuw3891ofij0pqojpp134u0f8'=>'sgfstudent200',
			'f77be014ce1122d477d2b483f1f4a024'=>'univer_50_all',
			'2a2783caa7667d4b98c0eb6fef3d7fd2'=>'goalcas5t0',
			'17f566a6faf3f79063db7f1ff4a9dae0'=>'lvgpartner50',
			'5470735a136f36e33aac8d38efe9edd7'=>'belford400',
			'3abf8f9a84893b0d7492cb297325603a'=>'belford60p',
			'0d2bc64bf0e302ea682f1333969d74c2'=>'belford200'
		);

	$promocode = $_REQUEST["hash"] ? $promocodes[$_REQUEST["hash"]] : '';

	$promocode = $promocode ? ", promocode: '{$promocodes[$_REQUEST["hash"]]}'" : '';

	$config['user']['sendsuccess'] = "
		$message
		<script>
		$.extend(true, window.api1001_params, {

			defaults: {

				name: '{$lead->name}',
				phone: '{$lead->phone}',
				email: '{$lead->email}',
				comment: 'test'{$promocode}

			},
			additionally: {

				mergelead: {
					name: 'mergelead',
					value: '{$lead->mergelead}'
				},
				land: {
					name: 'land',
					value: '{$lead->land}'
				}

			}

		});
		$('.open1001').first().trigger('click');
		</script>
	";

}

