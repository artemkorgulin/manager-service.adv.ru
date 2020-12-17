<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!<br>
		Мы&nbsp;рады видеть на&nbsp;форуме HR-специалистов и&nbsp;надеемся, что наше сотрудничество продолжится и&nbsp;в&nbsp;области других проектов бизнес-образования.
	</p>
	<p>
		В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			We&rsquo;ve received your request. One of&nbsp;our account managers will contact you to&nbsp;finalize your purchase and issue an&nbsp;invoice.
		</p>
	</div>
	';
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			&iexcl;Gracias, su&nbsp;solicitud se&nbsp;ha&nbsp;enviado! Estaremos encantados de&nbsp;tener en&nbsp;el&nbsp;F&oacute;rum a&nbsp;especialistas de&nbsp;Recursos Humanos y&nbsp;esperamos seguir colaborando en&nbsp;otros proyectos de&nbsp;formaci&oacute;n empresarial.
		</p>
		<p>
			El&nbsp;gerente de&nbsp;cuentas le&nbsp;llamar&aacute; a&nbsp;la&nbsp;mayor brevedad posible para formalizar la&nbsp;documentaci&oacute;n, reservar un&nbsp;billete a&nbsp;precio especial y&nbsp;emitir una factura.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;