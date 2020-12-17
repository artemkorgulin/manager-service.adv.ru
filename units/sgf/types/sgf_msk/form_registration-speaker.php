<?php
if ( $_REQUEST['lang'] == 'en' ) {}
else {
    $config['user']['sendsuccess'] = '
    <div class="send-success">
    	<p>
    		Спасибо за вашу заявку! Мы направили подтверждение регистрации на вашу электронную почту.
    	</p>
    </div>
    ';
}