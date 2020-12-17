<?php

require_once(USEFUL_DIR . 'payment_products_for_partner.php');

/* Конфигуратор FormMessages */

$config['user']['sendsuccess'] = "
<div class='send-success'>
  <h3>Заявка успешно отправлена!</h3>
  <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
</div>";


/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было open_program


/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «" . trim($lead->program) . "»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_type_sm_kou.php';


if ($lead->land == 'transform_v2' && !isset($_REQUEST['megafon'])) {

  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = true;
  $config['newsletter']['getresponse']['account'] = 'synergy';
  $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_transm';


	if (!isset($_REQUEST['version'])) {
		$success = '
			<script>
			location.href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/'
			. '?name='. $_REQUEST['name'] . '&discount=' . $_REQUEST['discount'] . '&email=' . $_REQUEST['email'] . '";
			</script>
			';
	} else switch ($_REQUEST['version']) {
	case '7v':
		$success = '
			<script>
			location.href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/index-7.php'
			. '?name='. $_REQUEST['name'] . '&discount=' . $_REQUEST['discount'] . '&email=' . $_REQUEST['email'] . '";
			</script>
			';
		break;
	case 'kz':
		$success = '
			<script>
			location.href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/choice-of-participation/'
			. '?version=kz&name='. $_REQUEST['name'] . '&email=' . $_REQUEST['email']
			. '&discount=' . $_REQUEST['discount'] . '&m=' . $_REQUEST['mergelead'] . '";
			</script>
			';
		break;
	case 'christmas':
		$success = '
			<script>
			location.href="choice-of-participation/?version=christmas'
			. '&name='. $_REQUEST['name'] . '&email=' . $_REQUEST['email']
			. '&discount=' . $_REQUEST['discount'] . '&m=' . $_REQUEST['mergelead'] . '";
			</script>
			';
		break;
	case 'rec':
		$success = '
			<script>
			location.href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/index-month.php'
			. '?name='. $_REQUEST['name'] . '&discount=' . $_REQUEST['discount'] . '&email=' . $_REQUEST['email'] . '";
			</script>
			';
		break;
	}

	$config['user']['sendsuccess'] = $success;



  switch ($lead->form) {
    case 'partner':
      $str = 'и&nbsp;расскажет о&nbsp;партнерских возможностях';
      break;
    case 'stab':
      $str = 'и&nbsp;расскажет, как стать руководителем регионального штаба';
      break;
    case 'ambassador':
      $str = 'и&nbsp;расскажет, как стать амбассадором';
      break;
    case 'instrument':
      $str = 'и&nbsp;расскажет подробнее о выбранном инструменте';
      break;
    default:
      $str = '';
  }

  if ($lead->form == 'partner' || $lead->form == 'stab' || $lead->form == 'ambassador' || $lead->form == 'instrument') {
    $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Спасибо, ваша заявка отправлена!</h3>
        <p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами {$str}</p>
      </div>
      <script>setTimeout(function() { location.href = 'http://synergy.ru/lp/thanks/?utm_source=thanks'; }, 0);</script>
    ";

    $config['ignore']['send_to_user'] = false;
  }
}

if ($lead->land == 'transform2' && $lead->partner == 'franchising_kursk') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;
}

if ($lead->land == 'transform2' || (isset($_REQUEST['megafon']) && $_REQUEST['megafon'] == true)) {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;

  if ($lead->form == 'show-more') {
    $config['user']['sendsuccess'] = "
        <div class='send-success'>
          <h3>Спасибо!</h3>
                 <p>В ближайшее время наши менеджеры свяжутся с вами.</p>
        </div>
      ";
  } else {

    $_payment_message = "Оплата трансформация";

    $config['user']['sendsuccess'] = "
        <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
        <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
        <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
        <button class='variables-button' type='submit' >Принять участие</button>

         <script>
         $.fancybox.open({ src: 'https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "' , type: 'iframe'});
         </script>";

    if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') {
      $discount = 0;
      if (isset($_REQUEST['discount']) && $_REQUEST['discount'] != '') {
        $discount = $_REQUEST['discount'];
      }
      $config['user']['sendsuccess'] = "
          <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
          <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
          <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
          <button class='variables-button' type='submit' >Принять участие</button>
          <script>
          $.fancybox.open({ src: 'https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "&discount=" . $discount . "&productId=" . $_REQUEST['product_id'] . "&recurrent=off', type: 'iframe'});
          </script>";
    }

  }

  if (isset($_REQUEST['step1'])) {

    $config['user']['sendsuccess'] = "<script>
      	$(window).trigger('getstep:paymenttype');
      	$('[name=\"name\"]').val('{$lead->name}');
      	$('[name=\"phone\"]').val('{$lead->phone}');
      	$('[name=\"email\"]').val('{$lead->email}');
      	</script>";

  }

  if (isset($_REQUEST['payment-invoice'])) {

    $config['user']['sendsuccess'] = "<script>$(window).trigger('getstep:company');</script>";

  }

  if (isset($_REQUEST['company'])) {

    $products = array(

      '3584689' => 'Базовый',
      '3694787' => 'Продвинутый',
      '3694799' => 'Продвинутый+Куратор',
      '36947866' => 'Персональный тренер'

    );

    $config['user']['sendsuccess'] = "<h3>Спасибо!</h3><p>Сформированный счет для оплаты будет скачан автоматически в течение 3 секунд...</p><script>$('body').append('<iframe src=\"https://payment.1001tickets.org/sgf/transform_marafon/invoice.php?summ={$_REQUEST['price']}&company={$_REQUEST['company']}&package={$products[$_REQUEST['product_id']]}\" style=\"display:none\" frameborder=\"0\"></iframe>')</script>";

  }
}

if ($lead->land == 'transform' && $lead->form == 'register-popup-marafon') {

  $config['user']['sendsuccess'] = "
  <script>
  $(document).ready(function(){
    setTimeout(function() {
     window.location.href = 'http://трансформация.рф/'
   }, 100);
 });
 </script>
 ";

}

if ($lead->land == 'transform' && $lead->form == 'sub') {

  $config['ignore']['send_to_user'] = false;

  $config['ignore']['getresponse'] = true;
  $config['newsletter']['getresponse']['account'] = 'synergy';
  $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_subtrance';

  $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>Видеозаписи форума вы получите на указанный e-mail.</p>
      </div>
    ";

}


if ($lead->land == 'transform' && $lead->form == 'transformation-download') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Спасибо.</h3>
    <p>Скоро на вашу почту придет письмо с видео. </p>
  </div>";
}


if ($lead->form == 'megafon' && $lead->land == 'transform_v2') {
	$shop_id = 108;
	$product_id = intval($_REQUEST['product_id']);
	$count = intval($_REQUEST['count'] ?? 1);
	$partner = $_REQUEST['partner'] ?? '';

	$json = payment_products_for_partner($lead, $product_id, $count, 0, $shop_id, $partner);
	$data = json_decode($json, true);

	$success = '
		<div class="send-success">
		<h3>Заявка не отправлена!</h3>
		<p>Оплата данного товара пока что не возможна, попробуйте позже</p>
		<!-- ' . $json . ' -->
		</div>
	';

	if (isset($data['link'])) {
		$success = '<iframe src="' . $data['link'] . '" frameborder="0" style="width:90%%;height:700px;"></iframe>'; // два %% не ошибка
	}

	$config['user']['sendsuccess'] = $success;
}
