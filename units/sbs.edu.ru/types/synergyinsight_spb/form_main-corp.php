<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Спасибо!</h3>
	<p>Корпоративный заказ принят. В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.</p>
</div>
';

/* http://synergyglobal.ru/en/ : https://sd.synergy.ru/Task/View/85626 */
if ( $_REQUEST['lang'] == 'en' ) {
	$config['user']['sendsuccess'] = '
	<div class="send-success">
		<h3>Thank you!</h3>
		<p>The corporate order is&nbsp;accepted. In&nbsp;the near future will call you account Manager to&nbsp;execute all documents, to&nbsp;book tickets at&nbsp;a&nbsp;special price and invoice.</p>
		<div class="form-pop-close">Close</div><br><br>
	</div>
	';
}
