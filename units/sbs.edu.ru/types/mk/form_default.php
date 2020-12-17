<?php
$config['user']['sendsuccess'] = "
<div class='send-success'>
	<h3>Доступ предоставлен!</h3>
	<p>Через мгновение вы попадете на страницу с мастер-классом, если этого не произошло автоматически, нажмите кнопку ниже.</p> <br />
	<a href='{$link}' class='btn-redirect' target='_blank'>Посмотреть мастер-класс »</a>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	{$redirect}
</div>";


/* http://sbs.edu.ru/lp/kravtsov/mk-v1/ : https://sd.synergy.ru/Task/View/84029 */
if ( $lead->land == 'lp_kravtsov_mk-v1' ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Ваша заявка отправлена!</h3>
		<p>Ссылка на&nbsp;просмотр мастер-класса отправлена на&nbsp;ваш e-mail. Запись будет доступна только 2&nbsp;октября.</p>
	</div>";
}
/* http://sbs.edu.ru/lp/avetov/mk-v1/ : https://sd.synergy.ru/Task/View/113691 */
if ( stripos($lead->land, 'lp_avetov_mk-v1') !== false ) {
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Доступ предоставлен!</h3>
		<p>Нажмите кнопку ниже.</p> <br />
		<a href='{$link}' class='btn-redirect' target='_blank'>Посмотреть мастер-класс »</a>
		<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>";
}

if ( $lead->land == 'kodbiznesa' ) {
  $Redirect = '<script>(function(){Redirect();})();</script>';
  $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<p>Доступ к онлайн-курсу отправлен на вашу почту, если что-то пошло не так - свяжитесь с нами по номеру телефона {$_REQUEST['phonenumber']}!</p>
	</div>" . $Redirect;
}

if ( $lead->land == 'kodlidera' ) {
	
	define('SHOP_ID', 43); // берем из СРМ

	require_once(USEFUL_DIR . 'payment_transactional_product.php');
	
	$product_id = $_REQUEST['product_id'] ?? 0; // если передается
	
	$promocode = isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '' ? $_REQUEST['promocode'] : 'Online10';
	$count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;
	 
	switch ($promocode) {
	case 'Online10':
		$discount = 10;
		break;
	default:
		$discount = 0;
	}
	 
	$json = payment_transactional_product($lead, $product_id, $count, $discount, SHOP_ID);
	$data = json_decode($json, true);
	
	$success = '
		<div class="send-success">
		<h3>Заявка не отправлена!</h3>
		<p>Оплата данного товара пока что не возможна, попробуйте позже</p>
		<!-- ' . $json . ' -->
		</div>';
	 
	if (isset($data['link'])) {
		$success = '<iframe src="' . $data['link'] . '" frameborder="0" style="width:90%%;height:700px;"></iframe>'; // два %% не ошибка
	}
	 
	$config['user']['sendsuccess'] = $success;
}
