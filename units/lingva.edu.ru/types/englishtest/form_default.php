<?php
// Конфигуратор FormMessages
/*
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
*/

$config['user']['sendsuccess'] ="

<div class='send-success' id='send-success'>
	<form  action='http://synergy.ru/lander/alm/lander_new_sms.php?r=landphone_validate&type=englishtest&unit=Lingva ' data-form='smsver'	method='post' class='application' id='formVerify'>

	<h3 class='msg_info'>На Ваш телефон отправлен код подтверждения.</h3>	
<p><input type='text' class='text' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' min='4' reqired autofocus />
	<!-- 	<input type='submit' value='Подтвердить' class='btn bluebtn'> -->
<button name='verifycode' id='verifycode'>Подтвердить</button>
		</p>
		<p><span class='msg_text'>Не пришел код в течение минуты?<br>
			осталось: <span id='timer_inp'>5</span></span>
		</p>
			<input type='hidden' name='type' value='englishtest'>
			<input type='hidden' name='land' value='test-english'>
			<input type='hidden' name='version' value='v2'>
			<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
			<input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />

		</form>

<!--Стереть в рабочей версии -->
<script type='text/javascript'>
$('#testcode').text('{$lead->testcode}')
</script>
<!--Стереть в рабочей версии -->
</div>

";

// Верификация успешна
$config['user']['sendsuccessvalidation'] = "
<div class='send-success'>КОД ПОДТВЕРЖДЕН
<!-- 	<script>$('document').ready(function(){document.location='/free-test-english#/step1';});</script> -->
</div>";

// Верификация провалена
$config['user']['sendfaildvalidation'] = "<div class='send-error'>
	<h3>СМС код не корректный!</h3>
<div class='send-success' id='send-success'>
	<form  action='http://synergy.ru/lander/alm/lander_new_sms.php?r=landphone_validate&type=englishtest&unit=Lingva' data-form='smsver'	method='post' class='application' id='formVerify'>


<p><input type='text' class='text' name='phone_validate' placeholder='Введите ваш код еще раз' id='phone_validate' min='4' reqired autofocus />
	<!-- 	<input type='submit' value='Подтвердить' class='btn bluebtn'> -->
<button name='verifycode' id='verifycode'>Еще раз подтвердить</button>
		</p>
		<p><span class='msg_text'>Не пришел код в течение минуты?<br>
			осталось: <span id='timer_inp'>5</span></span>
		</p>
			<input type='hidden' name='type' value='englishtest'>
			<input type='hidden' name='land' value='test-english'>
			<input type='hidden' name='version' value='v2'>
			<input type='hidden' value='{$lead->phone}' name='phone' />
			<input type='hidden' value='".$_POST['vk']."' name='vk' />

		</form>


<!--Стереть в рабочей версии -->
<script type='text/javascript'>
$('#testcode').text('".decrypt($_POST['vk'])."')
</script>
<!--Стереть в рабочей версии -->
</div>
</div>";

// Неверный номер + смс сервис не доступен
$config['user']['smscfail'] = "
<div class='send-error'>
	<h3>Произошла ошибка!</h3>
	<p>Вы ввели неверный номер мобильного телефона <b>{$lead->phone}</b>, или служба отправки смс недоступна. Пожалуйста, попробуйте позже...</p>
	<script>$('document').ready(function(){Hash.add('send','error');});</script>
</div>";

//Какая то ошибка
$config['user']['senderror'] = "Какая то ошибка";


// Конфигуратор GetResponse
$config['ignore']['getresponse']    = true;
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_proftest');
