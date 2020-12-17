<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо! Ваша заявка отправлена.<br>
		В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами и&nbsp;расскажем об&nbsp;условиях аренды выставочных мест на&nbsp;форуме.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application has been submitted! Check your e-mail for the confirmation of&nbsp;registration to&nbsp;the forum. We&rsquo;ll contact you soon to&nbsp;share information on&nbsp;special promotions of&nbsp;your business during the forum and to&nbsp;issue an&nbsp;invoice.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;