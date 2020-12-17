<?php

/* ЕВМЕНЕНКО *** */

if($lead->land == 'sbs-intensive'){

	$config['newsletter']['getresponse']['campaign'] = '7day';
	$config['ignore']['send_to_user'] = false;

}
else if($lead->land == 'sbs-demo-version-emba'){

	$config['newsletter']['getresponse']['campaign'] = 'demomba';
	$config['ignore']['send_to_user'] = false;

}

$imIdRegions = "";

switch ($lead->partner) {
	case 'chelyabinsk':
		$imIdRegions = ' | 293000';
		break;
	case 'ekb':
		$imIdRegions = ' | 288000';
		break;
	
	case 'kg':
		$imIdRegions = ' | drb-kaliningrad';
		break;
	
	case 'krasnoyarsk':
		$imIdRegions = ' | 290000';
		break;
	
	case 'krdr':
		$imIdRegions = ' | 290500';
		break;

	case 'nn':
		$imIdRegions = ' | 289000';
		break;
	
	case 'novosibirskbo':
		$imIdRegions = ' | 287500';
		break;
	
	case 'omsk':
		$imIdRegions = ' | drb-omsk';
		break;

	case 'samara':
		$imIdRegions = ' | 292500';
		break;

	case 'spb':
		$imIdRegions = ' | 291500';
		break;

	case 'sta':
		$imIdRegions = ' | 291000';
		break;

	case 'rnd':
		$imIdRegions = ' | 293500';
		break;

	case 'kazan':
		$imIdRegions = ' | drb-kazan';
		break;

	case 'ufa':
		$imIdRegions = ' | 288500';
		break;

	case 'orenburg':
		$imIdRegions = ' | 289500';
		break;

	case 'tomsk':
		$imIdRegions = ' | drb-tomsk';
		break;

	default:
		$imIdRegions = ' | drb';
		break;
}

if(($lead->form == 'nolinkpay') or (!empty($lead->partner))) {
   $linkpay ="";
}
else{
  $shopId = $_REQUEST['shop_id'];
  if ($shopId == '') {
    $shopId = '455815';
  }
   $linkpay = "
      <p><b>Если Вы еще не оплатили участие</b> <br>
      Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. <br/> Мы используем сервис IntellectMoney.</p>
      <p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>


		<p style='margin:40px 0; text-align: center;'><a href='https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE={$shopId}&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC={$lead->program} | {$_REQUEST['name']} {$imIdRegions}&preference=bankCard'
		style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>


      <p>После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.</p>";
}

//№113307 - убрали ссылку на ИМ из ответа лендера
if ($lead->land != 'biznes-zavtrak-«peregovoryi-na-vashix-usloviyax') {
  if ($_REQUEST['cost'] > 0) {
    if ($_REQUEST['shop_id'] != -5) { //https://sd.synergy.ru/Task/View/88761 -5 для регионов
    $config['user']['sendsuccess'] .= "
  		<script>$(document).ready(function(){
  			var email_uf = '{$lead->email}';
  			var shopid_uf =  '{$_REQUEST['shop_id']}';
  			var cost = '{$_REQUEST['cost']}';
  			var program = '{$_REQUEST['program']}';
        var name = '{$_REQUEST['name']}';
  
  			//var ssulka_uf = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=' + shopid_uf + '&email=' + email_uf + '&LMI_PAYMENT_AMOUNT=' + cost + '&LMI_PAYMENT_DESC=' + program + ' | ' + name + '{$imIdRegions}&preference=bankCard';
  
        var ssulka_uf = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}';
  
        var a = document.createElement('a');
        a.href = ssulka_uf;
        a.setAttribute('target', '_blank');
        a.click();
  	});</script>";
    }
  }
}

/* ЕВМЕНЕНКО *** */

/* https://sd.synergy.ru/Task/View/128661  Мицеля Геннадий Георгиевич просил отключить редирект на http://synergyregions.ru/lp/thanks_all/ с http://synergyregions.ru/lp/yakuba/sm-v1/ */
if ($lead->land != 'yakuba-sm-v1') {
	require_once '/var/www/mfpa.ru/public/lander/alm/units/redirect_thanks_all.php';
}

?>