<?php
####################
##### Вебинары #####
####################

if ( $lead->link != '' AND $lead->land != 'synergy_webinars_kak-prodavat-v-bolshie-kompanii' ) {
	$redirect = "<script>location.href = '" . $lead->link . "';</script>";
}

/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Заявка успешно отправлена!</h3>
	<p>{$lead->name}, вы успешно зарегистрировались на вебинар, ссылку для участия вы получите на вашу почту <b>{$lead->email}</b>.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	{$redirect}
</div>";

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); /* было webinar */


/* Стандартное письмо на все вебинары */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар: {$lead->program}";
$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb.php';
/* Платный вебинар */
if ($lead->version == 'paid'){
	/* Конфигуратор UserMail */
	$config['mail']['smtp']['user']['subject'] = "Ваша заявка получена!";
	$config['mail']['smtp']['user']['message'] = "<h3>Здравствуйте, {$lead->name}!</h3>
	<p><b>Вы зарегистрировались на живой вебинар {$lead->program}.</b></p>
	<p>Вебинар начнется {$lead->dater}. Рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
	<p><b>Обратите внимание: этот вебинар платный. Стоимость онлайн-участия — {$lead->cost} рублей. Ссылку на трансляцию и код доступа мы пришлем после оплаты.</b></p>
	<p>Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. Мы используем сервис IntellectMoney.</p>
	<p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>
	<p style='margin:40px 0; text-align: center;'><a href='https://Merchant.IntellectMoney.ru/ru/index.php?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYEE_PURSE={$_REQUEST['shop_id']}&LMI_PAYMENT_DESC=Оплата+участия+в+программе+«{$lead->program}»' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>
	<p>После проведения платежа мы вышлем подтверждение и включим вас в список участников. </p>
	<p><b>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</b></p>
	<hr />
	<p>
		До встречи!<br />
		<a href='http://synergyregions.ru/?utm_source=tranzmail-wb'>Школа бизнеса «Синергия»</a>,<br />
		Телефон: {$partner_phone}
	</p>";
}

/* http://sbs.edu.ru/lp/glushkov/wb-v1/ : https://sd.synergy.ru/task/view/78478 */
elseif ($lead->land == 'glushkov_wb'){
	$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_glushkov_wb.php';

	if($lead->form == 'download') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Спасибо, ваша заявка успешно отправлена.</h3>
			<p>Проверьте указанный email, мы выслали на него программу форума.</p>
		</div>";

		$config['mail']['smtp']['user']['subject'] = "Ваша программа Предпринимательского форума «Герои российского бизнеса»";
	}

	if($lead->form == 'demo') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена.</h3>
			<p>Проверьте свой email, мы выслали на него ссылку на скачивание демо-версии книги.</p>
		</div>";
	}

	if($lead->form == 'buybook') {
		$config['user']['sendsuccess'] = "
		<div class='send-success'>
			<h3>Заявка успешно отправлена.</h3>
			<p>Проверьте свой email, мы выслали на него ссылку на предзаказ книги.</p>
		</div>";
	}

}

/* http://sbs.edu.ru/lp/kravtsov/wb-v1/ : https://sd.synergy.ru/Task/View/81194 */
elseif ($lead->land == 'lp_kravtsov_wb-v1') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>Письмо с&nbsp;дальнейшими инструкциями направлено на&nbsp;ваш e-mail.</p>
	</div>";
}
elseif (strpos(trim($lead->land), 'lp_ovchinnikov_wb-v1') !== false){

	$config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар: {$lead->program}";
	$config['mail']['smtp']['user']['message'] 	= include_once UNIT_DIR.'/letters/mail_type_wb_ovchinnikov_wb-v1.php';
}