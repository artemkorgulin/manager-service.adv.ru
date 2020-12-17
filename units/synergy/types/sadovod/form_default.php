<?php
$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Спасибо! Ваша заявка отправлена.</h3>
		<p>В ближайшее время с&nbsp;вами свяжется наш консультант и&nbsp;подробнее расскажет об&nbsp;условиях поступления.</p>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";

if (isset($lead->cost) && $lead->cost > 0) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<script>location.href='http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName={$lead->program}&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}&land={$lead->land}&promo={$_REQUEST['promo']}'</script>
	</div>";
}

// Конфигуратор GetResponse
$config['ignore']['getresponse']    = false;

$config['ignore']['send_to_user'] 	= true;
$config['mail']['smtp']['user']['subject'] 	= "заявка в Университете садоводов";
$config['mail']['smtp']['user']['message'] 	= "
	<div style=\"font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;\">
  	<div style=\"margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;\">
			<h3>Здравствуйте, {$lead->name}!</h3>
			<p>Мы получили вашу заявку на&nbsp;сайте Университета Садоводов. <br>
			В&nbsp;ближайшее время с&nbsp;вами свяжется наш менежер, чтобы проконсультировать по&nbsp;всем интересующим вопросам.</p>
			<hr style=\"color: #E5E5E5;\">
			<p style=\"color:#505050;\"><i>Университет Садоводов.</i><br>
			Тел. <a href=\"tel:+74957850496 \">+7 (495) 785 04 96 </a><br>
			Email: <a href=\"mailto:info@universitetsadovodov.ru\">info@universitetsadovodov.ru</a><br>
			Сайт: <a href=\"http://xn--80adbaibdayc5ctbbvqcqbk.xn--p1ai/\" target=\"_blank\">университетсадоводов.рф</a>
			</p>
   	</div>
  	<div style=\"text-align: center; margin-top: 15px; color:#909090; font-size:11px;\">© 2016. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href=\"tel:+74958001001\">+7 (495) 800 10 01</a></div>
	</div>
	";
if (isset($lead->cost) && $lead->cost > 0) {
	$config['ignore']['send_to_user'] 	= false;
}