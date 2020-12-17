<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, корпоративный заказ принят.<br>
		В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			We&rsquo;ve received your corporate order. One of&nbsp;our account managers will contact you to&nbsp;finalize purchase of&nbsp;your tickets at&nbsp;our special rate.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Gracias, su&nbsp;pedido corporativo se&nbsp;ha&nbsp;aceptado. El&nbsp;gerente de&nbsp;cuentas le&nbsp;llamar&aacute; a&nbsp;la&nbsp;mayor brevedad posible para formalizar la&nbsp;documentaci&oacute;n, reservar un&nbsp;billete a&nbsp;precio especial y&nbsp;emitir una factura.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;