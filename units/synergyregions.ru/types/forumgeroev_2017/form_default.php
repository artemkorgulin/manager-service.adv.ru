<?php
###############################
########## Форум Героев #######
###############################

$payment_redirect = '';

if( !empty($lead->cost) ){
	/*$intellectmoney_redirect = "<script>setTimeout(function(){location.href = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=455445&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC=Форум Героев&preference=bankCard'}, 1000);</script>";*/
	$payment_redirect = '<p><a href="https://shkola-biznesa-sine.timepad.ru/event/377993/" data-twf-placeholder="yes">Перейти к заказу билетов</a><script type="text/javascript" defer="defer" charset="UTF-8" data-timepad-customized="16277" data-timepad-widget-v2="event_register" src="https://timepad.ru/js/tpwf/loader/min/loader.js">(function(){return {"event":{"id":"377993"},"hidePreloading":true,"initialRoute":"button","buttonSettings":{"text":"Купить билет"}}; })();</script></p>';
}


$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Спасибо, ваша заявка успешно отправлена.</h3>
	<p>Проверьте электронную почту, куда мы&nbsp;направили письмо с&nbsp;дальнейшими инструкциями.</p>
</div>
";


/* Дефолтный обработчик */
/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = false;
/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на предпринимательский форум «Герои российского бизнеса 2017»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_forumgeroev_2017.php';