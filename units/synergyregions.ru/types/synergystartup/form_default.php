<?php
###############################
##### Synergy Акселератор #####
###############################

// Конфигуратор FormMessages
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
</div>
";

if($_REQUEST['land'] == 'synergyakselerator' || $_REQUEST['land'] == 'synergystartup' || $_REQUEST['land'] == 'synergystartup-v3') {
	if($_REQUEST['form'] == 'callme'){
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>В ближайшее время, мы вам перезвоним!</p>
		</div>";
	} else if($_REQUEST['partner'] == 'oberezina'){
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
		</div>";
	}	else {
		if ($_REQUEST['form'] == 'popup-1-step2'){
			$config['ignore']['bitrix24']  = false;

			$config['user']['sendsuccess'] = "
			<div class='send-success'>
				<h3>Заявка успешно отправлена!</h3>
				<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
			</div>
			<script>
				$.fancybox('#popup-1-step3');
			</script>
			";
		} else {
			$config['user']['sendsuccess'] = "
			<script>
				/* $.fancybox('#popup-1-step2'); */
				$('#popup-1-step2 form').append('<input type=\"hidden\" name=\"name\" value=\"{$lead->name}\"><input type=\"hidden\" name=\"email\" value=\"{$lead->email}\"><input type=\"hidden\" name=\"phone\" value=\"{$lead->phone}\">');
			</script>
			";
			if($_REQUEST["partner"] || $_REQUEST["version"] == 'students'){
				$config['user']['sendsuccess'] .= "
				<script>
					$('#popup-1-step3 a').css('display', 'none');
          $.fancybox('#popup-1-step3');
				</script>
				";
			}
			else{
				$config['user']['sendsuccess'] .= "
				<script>
					$('#popup-1-step3 a').attr('href', 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE={$shop_id}&graccount=sbsedu&grcampaign=start_clients&email={$lead->email}&subscriber={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC={$payment_name}&preference=bankCard&LMI_RESULT_URL=http://synergy.ru/lander/alm/intellectmoney.php');
          $.fancybox('#popup-1-step3');
				</script>
				";
			}

		}
	}

	/* https://sd.synergy.ru/task/view/99246
	Для
	http://synergystartup.ru/lp/first_step/
	http://synergystartup.ru/lp/your_business/
	http://synergystartup.ru/lp/you_can/
	*/
	if($lead->version == 'first_step' || $lead->version == 'your_business' || $lead->version == 'you_can'){
		$config['user']['sendsuccess'] = "{$intellectmoney_redirect}".$config['user']['sendsuccess'];
	}

}
else{
	if($_REQUEST["partner"]) {
		$config['user']['sendsuccess'] .= "{$intellectmoney_redirect}";
	}
}

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было base

// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;

if($_REQUEST['land'] == 'synergyakselerator') {
	if($_REQUEST['form'] != 'callme') {
		$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу Synergy Акселератор";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_aksel.php';
	}
}
if($_REQUEST['land'] == 'lukashenko-sm-v3') {
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу ТАЙМ-МЕНЕДЖМЕНТ ДЛЯ ДЕТЕЙ (8–15 ЛЕТ)";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_lukashenko.php';

}
elseif($_REQUEST['land'] == 'synergystartup' || $_REQUEST['land'] == 'synergystartup_miniland'){
	if($_REQUEST['form'] != 'callme') {
		$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на программу {$_REQUEST['program']}";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_startup.php';
	}
	if($_REQUEST['form'] == 'popup-1-step2'){
		$config['ignore']['send_to_user']  = false;
	}
}
elseif($_REQUEST['land'] == 'synergymbapresident'){
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на Executive MBA «Президентская программа»";
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_president.php';
}
elseif($_REQUEST['land'] == 'belochkina'){
	$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на онлайн-практикум Анастасии Белочкиной";
	if($_REQUEST['partner'] == 'oberezina') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>{$lead->name}, вы успешно зарегистрировались на программу! Проверьте вашу почту, куда мы отправили письмо-подтверждение.</p>
		</div>";
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_belochkina_nopay.php';
	} else {
		$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_aksel/mail_belochkina.php';
	}
}
elseif($_REQUEST['land'] == 'drb_free_startup'){
	$config['ignore']['send_to_user']   = false;
}