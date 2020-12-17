<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<p>
		Спасибо, корпоративный заказ принят.<br>
		В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.
	</p>
</div>
';

if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<p>
			Thank you!<br>
			The corporate order is&nbsp;accepted. The account-manager will contact you soon to&nbsp;execute documents, book a&nbsp;ticket at&nbsp;a&nbsp;special price and issue an&nbsp;invoice.
		</p>
	</div>
	';
}

$config['ignore']['send_to_user'] = false;