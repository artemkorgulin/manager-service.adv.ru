<?php

$sendsuccess = "
<div class='send-success'>
	<p>
		Ваша заявка отправлена.<br>
		В ближайшее время с вами свяжется персональный менеджер.
	</p>
</div>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$sendsuccess = "
	<div class='send-success'>
		<p>
			Your request has been sent.<br>
			In the nearest time personal manager will contact you.
		</p>
	</div>
	";
}

$config['user']['sendsuccess'] = $sendsuccess;

?>