<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, ваша заявка отправлена!
		В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами и&nbsp;расскажем об&nbsp;условиях аренды выставочных мест на&nbsp;форуме.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			Your application has been submitted! We&rsquo;ll contact you soon to&nbsp;discuss the cooperation.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;