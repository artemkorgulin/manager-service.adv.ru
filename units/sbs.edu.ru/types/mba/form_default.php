<?php
#####################
##### MBA ленды #####
#####################
/* Редиректы после отправки сообщения в зависимости от ленда */
	



if (!empty($lead->partner)) {
	$partner = '&partner='.$lead->partner;
}

$RedirectLink = array(
    $link = 'http://sbs.edu.ru/land/mba/thanks.php?'.$partner
	/*

	Теперь одна стр thanks везде, сделано по этой задаче https://sd.synergy.ru/Task/View/41237

	'inter' => 'thanks.php',
	'Mini-MBA' => 'thanks.php',
	'mba-long' => 'thanks.php',
    'minimba' => 'thanks.php',
	'mba-pocket' => 'thanks.php',
	'mba-finance' => 'thanks.php',
	'fitnes-industrii' => 'thanks.php',
	'mba-women' => 'thanks.php',
	'mba-strategiya-liderstva' => 'thanks.php',
	'corporate_programs' => 'thanks.php',
	'tax-consulting' => 'thanks.php',

	'univer-inter' => 'thanks.php',
	'univer-Mini-MBA' => 'thanks.php',
	'univer-mba-long' => 'thanks.php',
	'univer-mba-pocket' => 'thanks.php',
	'univer-mba-finance' => 'thanks.php',
	'univer-mba-women' => 'thanks.php',
	'univer-mba-strategiya-liderstva' => 'thanks.php',
	'univer-corporate_programs' => 'thanks.php',
	'univer-tax-consulting' => 'thanks.php',
	'univer-mba-finance' => 'thanks.php',
	'dubai-short' => 'thanks.php',*/
	);

if ($lead->land == 'synergy-demo-version-emba') {
    $link = 'http://synergy.ru/lp/mba/thanks/thanks.php';
}
if ($lead->land == 'synergymba-demo-version-emba') {
    $link = 'http://sbs.edu.ru/lp/thanks_all/';
}
if ($lead->land == 'synergymba-lp-30') {
    $link = 'http://sbs.edu.ru/lp/thanks_all/';
}

if ($lead->land ==  'synergymba' || $lead->land == 'onlinemba' || $lead->land == 'mba' || $lead->land == 'opendaymba') {
	$link = 'https://synergy.mba/thanks/';
}

if (!empty($RedirectLink[$lead->land])) {
	$link = $RedirectLink[$lead->land];
}
if (!empty($lead->link)) {
	$link = $lead->link;
}
/*
if ($lead->land == 'synergymba' && $lead->form == 'catalog') {
  $link = 'http://synergy.mba/semba/pdf/176841_MBA_Booklet.pdf';
}
*/

if (!empty($link)) {
	$redirect = "<script>setTimeout(function(){location.replace('{$link}')}, 500);</script>";
	// if ($lead->land == 'synergymba') {
	// 	$redirect = "<script>setTimeout(function(){window.open('{$link}', '_blank');}, 1);</script>";
	// }
}
if ($lead->form == 'noredirect') {
	$redirect = "";
}

if ($lead->link == 'empty' ) {
    $link = '';
    $redirect = '';
}

/* Конфигуратор GetResponse */

$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'sub_mba');

/* Конфигуратор UserMail */
$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В&nbsp;ближайшее время наш&nbsp;менеджер свяжется с&nbsp;вами по&nbsp;телефону <b>{$lead->phone}</b>, чтобы ответить на&nbsp;все вопросы.</p>
		{$redirect}
		<script>$('document').ready(function(){Hash.add('send','ok')});</script>
	</div>";


if( $_REQUEST['land'] == 'synergymba-new' && $lead->partner != 'spb' ) {

	$im_link - "";
	if (isset($_REQUEST['cost']) && $_REQUEST['cost']>1) {
		$im_link = "<script>
         $.fancybox('http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=434911&price=".$_REQUEST['cost']."&email=".$lead->email."&username=".$lead->name."&form=".$lead->from."&land=".$lead->land."', {type:'iframe'})
         </script>";
	}

	$redirectUrl = '';

	if (isset($link) && $link != '') {
		$redirectUrl = "<script>
							(function(){
								var link = document.createElement('a');
								link.href = 'http://sbs.edu.ru/lp/thanks_all/';
								link.setAttribute('target', '_blank');
								link.click();
								window.focus();
								return false;
							})();
						</script>";
	}

	// $config['user']['sendsuccess'] = "
	// <div class='send-success'>
	// 	<h3>Спасибо за&nbsp;регистрацию!</h3>
	// 	<p>В&nbsp;ближайшее время с&nbsp;вами свяжется наш менеджер и&nbsp;подробно проконсультирует по&nbsp;любым вашим вопросам.</p>
	// </div>
	// {$im_link}
	// {$redirectUrl}
	// ";



		$config['user']['sendsuccess'] = "
		<form id='impay' action='http://synergy.mba/thanks.php' method='POST'>
			<input type='hidden' name='shopId' value='434911'>
			<input type='hidden' name='price' value='".$_REQUEST['cost']."'>
			<input type='hidden' name='email' value='".$lead->email."'>
			<input type='hidden' name='username' value='".$lead->name."'>
			<input type='hidden' name='form' value='".$lead->from."'>
			<input type='hidden' name='land' value='".$lead->land."'>
			<script>document.getElementById('impay').submit();</script>
		</form>";



}


if($lead->land == 'synergymba' || $lead->land == 'onlinemba' || $lead->land == 'mba' || $lead->land == 'opendaymba') {
	/* Конфигуратор UserMail */
	$partnerPhone = '8 800 707 41 77';
	if (isset($_REQUEST['partner_phone']) && $_REQUEST['partner_phone'] != "") {
		$partnerPhone = $_REQUEST['partner_phone'];
	}
	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на программу Synergy Executive MBA";
	$config['mail']['smtp']['user']['message'] = "
		<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
		<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
			<a href='http://sbs.edu.ru?utm_source=tranzmail-mk' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt=' width='174' height='54'></a>
		</div>
		<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Благодарим Вас за&nbsp;интерес к&nbsp;программе Synergy Executive&nbsp;MBA.<br>
			В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;Вами и&nbsp;ответит на&nbsp;все Ваши вопросы.</p>

			<p>Чтобы узнать больше о&nbsp;программе обучения, <a href='http://synergy.mba/semba/pdf/176841_MBA_Booklet.pdf' target='_blank'>скачайте электронную брошюру Synergy Executive&nbsp;MBA</a>.</p>

			<hr style='color: #E5E5E5;'>

			<p style='color:#505050;'><i>С уважением, <br>команда <a style='color:#505050;' href='http://sbs.edu.ru?utm_source=tranzmail-mk'>Школы Бизнеса «Синергия»</a></i><br>".$partnerPhone."</p>
		</div>
	</div>
	";
}


/*
if($lead->land == 'synergymba' && $_REQUEST['currenturl'] == 'online') {

    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша регистрация на программу Synergy Executive MBA";
    $config['mail']['smtp']['user']['message'] = "
        <div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
        <div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
            <a href='http://sbs.edu.ru?utm_source=tranzmail-mk' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt=' width='174' height='54'></a>
        </div>
        <div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
            <h3>Здравствуйте, {$lead->name}!</h3>

            <p>Благодарим Вас за интерес к программе Synergy Online MBA.</p>
        <p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;Вами и&nbsp;ответит на&nbsp;все Ваши вопросы.</p>

        <hr style='color: #E5E5E5;'>

        <p style='color:#505050;'><i>С уважением, <br>команда <a style='color:#505050;' href='http://sbs.edu.ru?utm_source=tranzmail-mk'>Школы Бизнеса «Синергия»</a></i><br>8 800 707 41 77</p>
    </div>
</div>
";
}
*/


if(($lead->land == 'synergymba'  || $lead->land == 'opendaymba' || $lead->land == 'onlinemba' || $lead->land == 'mba') && ($lead->partner == 'spb' || $lead->partner == 'franchising_kursk' )){
	$config['ignore']['send_to_user']   = false;
}

/*
if ($lead->land == 'synergymba' && $lead->form == 'opendoors') {


	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject'] = "Регистрация на День открытых дверей Synergy Executive MBA";
	$config['mail']['smtp']['user']['message'] = "
		<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
		<div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
			<a href='http://sbs.edu.ru?utm_source=tranzmail-mk' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt=' width='174' height='54'></a>
		</div>
		<div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Вы зарегистрировались на День открытых дверей программы Synergy Executive MBA.</p>
			<p>Мероприятие состоится 29 марта в 19:00. Модератор Дня открытых дверей - ректор Школы Бизнеса «Синергия» Григорий Аветов.</p>
			<p>Онлайн-трансляция будет доступна по ссылке: <a href='https://livestream.com/accounts/7155227/events/7985310'>https://livestream.com/accounts/7155227/events/7985310</a></p>
			<p>Живое участие: ул. Измайловский Вал, д.2 стр. 1, Школа Бизнеса «Синергия»</p>
			<p>8 800 707 41 77</p>

			<hr style='color: #E5E5E5;'>
			<p style='color:#505050;'>До встречи!</p>
			<p style='color:#505050;'><i>С уважением, команда <a style='color:#505050;' href='http://sbs.edu.ru?utm_source=tranzmail-mk'>Школы Бизнеса «Синергия»</a></i></p>
		</div>
		<div style='text-align: center; margin-top: 15px; color:#909090; font-size:11px;'>© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. 8 800 707 41 77</div>
	</div>
	";
}
*/

/* Конфигуратор ExpertSender */

$list_id = 166;
$letter_id = null;

switch ($lead->land) {
    case 'opendaymba':      //https://synergy.mba/open_day.php
        $letter_id = 1766;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'mba':             //https://synergy.mba/semba/
        $letter_id = 1767;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'premiummba':      //https://synergy.mba/premiummba
        $letter_id = 1768;
        $config['ignore']['send_to_user'] = false;
        break;
    case 'onlinemba':       //https://synergy.mba/online
        $letter_id = 1769;
        $config['ignore']['send_to_user'] = false;
        break;
    default:
        break;
}


if( ($lead->land == 'synergymba'  || $lead->land == 'opendaymba' || $lead->land == 'onlinemba' || $lead->land == 'mba') && ($lead->partner == 'franchising_kursk' )) {
	$config['ignore']['getresponse'] = false;
}
	else {
		/* ExpertSender - лист подписки */
		if($letter_id > 0) {
			$ExpertSender = [
					'email'       => $lead->email,
					'name'        => $lead->name,
					'id'          => $lead->uuid,
					'land'        => $lead->land,
					'ip'          => $lead->ip,
					'dateCreated' => time(),
					'listId'      => $list_id
			];

			$curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$responseEs = curl_exec($curl);
			curl_close($curl);
		}

		/* ExpertSender - письмо */
		if($letter_id > 0) {
			$ExpertSenderMessage = '
			<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
					<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
					<Data>
							<Receiver>
									<Email>'.$lead->email.'</Email>
							</Receiver>
					</Data>
			</ApiRequest>';

			$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/".$letter_id);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			$response = curl_exec($curl);
			curl_close($curl);
		}
	}


if($lead->land == 'mbastart') {
  if ($lead->form == 'popup') {
    $config['user']['sendsuccess'] = "
	  <script>initPopupSuccess('#popup_success')</script>
	";
  } else {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>В&nbsp;ближайшее время наш&nbsp;менеджер свяжется с&nbsp;вами по&nbsp;телефону <b>{$lead->phone}</b>, чтобы ответить на&nbsp;все вопросы.</p>
		<script>$('document').ready(function(){Hash.add('send','ok')});</script>
	</div>";
  }

  $config['ignore']['send_to_user']   = true;
  $config['mail']['smtp']['user']['subject'] = "Успешная регистрация на интенсив MBA:Start";
  $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_mbastart.php';
}
