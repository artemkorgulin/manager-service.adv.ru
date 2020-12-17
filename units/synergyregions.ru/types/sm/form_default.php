<?php
###############################
##### Семинары и коучинги #####
###############################

// Конфигуратор FormMessages

$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
	</div>";

// if ($_REQUEST['cost'] > 0) {
//   if ($_REQUEST['shop_id'] != -5) { //https://sd.synergy.ru/Task/View/88761 -5 для регионов
// $config['user']['sendsuccess'] .= "
// 		<script>$(document).ready(function(){
// 			var email_uf = '{$lead->email}';
// 			var shopid_uf =  {$_REQUEST['shop_id']};
// 			var cost = {$_REQUEST['cost']};
// 			var program = '{$_REQUEST['program']}';
//       var name = '{$_REQUEST['name']}';

// 			//var ssulka_uf = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=' + shopid_uf + '&email=' + email_uf + '&LMI_PAYMENT_AMOUNT=' + cost + '&LMI_PAYMENT_DESC=' + program + ' | ' + name + '&preference=bankCard';

//       var ssulka_uf = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}';

//       var a = document.createElement('a');
//       a.href = ssulka_uf;
//       a.setAttribute('target', '_blank');
//       a.click();
// 	});</script>";
//   }
// }

// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было open_program


if($lead->partner == 'tsoy') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Your request has been sent successfully!</h3>
    <p>{$lead->name}, you have successfully registered for the event. Check your e-mail  <b>{$lead->email}</b>, there you will find a letter with further instructions.</p>
  </div>";
}
if($lead->form == 'look') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие.</p>
		{$redirect}
	</div>";
}
if($lead->form == 'yakuba-sm-v1') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие.</p>
	</div>";
}
if($lead->form == 'download-spb') {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Доступ предоставлен!</h3>
		<a href='{$link}' class='btn-redirect' target='_blank'>Посмотреть »</a>
		{$redirect}
	</div>";
}
// Если &form=nolinkpay или &partner не пустой, то письмо приходит без ссылки на оплату
if(($lead->form == 'nolinkpay') or (!empty($lead->partner))) {
   $linkpay ="";
}
else{
  $shopId = $_REQUEST['shop_id'];
  if ($shopId == '') {
    $shopId = '455571';
  }
   $linkpay = "
      <p><b>Если Вы еще не оплатили участие</b> <br>
      Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. <br/> Мы используем сервис IntellectMoney.</p>
      <p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>


		<p style='margin:40px 0; text-align: center;'><a href='https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE={$shopId}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC={$lead->program}&preference=bankCard'
		style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>


      <p>После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.</p>";
}

/*
БЫЛО

	<p style='margin:40px 0; text-align: center;'><a href='http://sbs.edu.ru/pay?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&cost={$lead->cost}&program={$lead->program}'
	style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>

БЫЛО
*/

if($lead->land == 'lp_strelkova'){

	$linkpay = '';

}



// Конфигуратор UserMail
$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «" . trim($lead->program) . "»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_type_sm_kou.php';


// Конфигуратор MessageForCallCentre
if(isset($_REQUEST['partner'])){
    $config['ignore']['send_to_cc'] = true;

    if($_REQUEST['land'] == 'gandapas-kou-v2'){
        $config['mail']['smtp']['cc']['subject'] = "Заявка с ленда - Онлайн-практикум Гандапаса";
        $config['mail']['smtp']['cc']['message'] = "
            <p>
                Имя: <b>$lead->name</b>
                <br />Телефон: <b>$lead->phone</b>
                <br />Email: <b>$lead->email</b>
            </p>";
    }

    if($_REQUEST['land'] == 'peregovoryi-na-million'){
        $config['mail']['smtp']['cc']['subject'] = "Заявка с ленда - Переговоры на миллион";
        $config['mail']['smtp']['cc']['message'] = "
            <p>
                Имя: <b>$lead->name</b>
                <br />Телефон: <b>$lead->phone</b>
                <br />Email: <b>$lead->email</b>
                <br />Способ: <b>$lead->radio</b>
            </p>";
    }

    if($_REQUEST['partner'] == 'krasnova')
        $config['mail']['smtp']['cc']['emails'] = array(array('Ekrasnova@synergy.ru'));
    if($_REQUEST['partner'] == 'neupokoeva')
        $config['mail']['smtp']['cc']['emails'] = array(array('ANeupokoeva@synergy.ru'));
}


if($lead->land == 'marketing-na-360-gradusov') {
  $config['ignore']['send_to_user']   = false;
}

//https://sd.synergy.ru/task/view/84001
if($lead->land == 'naviyki-oratorskogo-masterstva') {
    $config['newsletter']['getresponse']['campaign'] = !empty($lead->grcampaign) ? $lead->grcampaign : 'drutko';
}

if($lead->land == 'lp_strelkova'){

	$linkpay = '';

	if($_REQUEST['redir']){

		$config['user']['sendsuccess'] .= "<script>window.location.href='" . $_REQUEST['redir'] . "'</script>";

	}
	if($_REQUEST['form'] == 'getvideo'){

		$config['ignore']['send_to_user'] = true;
		$config['mail']['smtp']['user']['subject'] = "Видеозапись бесплатного мастер-класса Зои Стрелковой";
		$config['mail']['smtp']['user']['message'] = '
		<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
				<a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
			</div>
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
					<h3>Здравствуйте, '.$lead->name.'!</h3>
					<p>Вы запросили запись вебинара Зои Стрелковой: "Управление дебиторской задолжностью"</p>
					<p>Запись доступна по ссылке: <a href="https://youtu.be/ckQmCBPR-wQ">https://youtu.be/ckQmCBPR-wQ</a></p>
					<p>Смотрите, внедряйте и получайте отличные результаты.</p>
					<p><b>Если вас интересует более глубокое изучение темы управления финансами компании, ждем вас 12-13 Октября на открытой программе Зои Стрелковой: "Финансы для не финансовых менеджеров"</b></p>
					<p><b>Узнать подробнее о программе и зарегистрироваться, можно <a href="http://synergyregions.ru/lp/strelkova/sm-v1/?partner='.$_REQUEST['partner'].'&utm_source=tranzmail-sm">здесь</a></b></p>
					<hr style="color: #E5E5E5;">
					<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
			</div>
			<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. '.$partner_phone.'</div>
		</div>
		';

	}

}