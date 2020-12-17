<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		Проверьте свою электронную почту, мы&nbsp;направили на&nbsp;нее подтверждение вашей регистрации на&nbsp;форум. В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами, расскажем о&nbsp;специальных возможностях продвижения бизнеса на&nbsp;форуме и&nbsp;выставим счет на&nbsp;оплату.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			We&rsquo;ve received your request. One of&nbsp;our account managers will contact you to&nbsp;finalize your purchase, issue an&nbsp;invoice, and answer any questions you may have about our promotional packages.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias! Su&nbsp;solicitud se&nbsp;ha&nbsp;enviado. Consulte su&nbsp;email: hemos enviado a&nbsp;su&nbsp;correo la&nbsp;confirmaci&oacute;n de&nbsp;registro en&nbsp;el&nbsp;F&oacute;rum. Nos pondremos en&nbsp;contacto con Usted a&nbsp;la&nbsp;mayor brevedad posible para informar sobre oportunidades especiales de&nbsp;promover su&nbsp;negocio en&nbsp;el&nbsp;F&oacute;rum y&nbsp;emitir una factura.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;