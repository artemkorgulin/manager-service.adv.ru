<?php
$sendsuccess = <<<HTML
<div class="send-success">
	<p>
Спасибо, корпоративный заказ принят.<br>
В&nbsp;ближайшее время вам перезвонит аккаунт-менеджер, чтобы оформить все документы, забронировать билет по&nbsp;специальной цене и&nbsp;выставить счет.
	</p>
</div>
HTML;

if ($_REQUEST['lang'] == 'en') $sendsuccess = <<<HTML
<div class="send-success">
	<p>
Thank you!<br>
The corporate order is&nbsp;accepted. The account-manager will contact you soon to&nbsp;execute documents, book a&nbsp;ticket at&nbsp;a&nbsp;special price and issue an&nbsp;invoice.
	</p>
</div>
HTML;


$package = trim($_REQUEST['package']);

switch ($package) {
case "hipe":
	$category = 131;
	$product_id = 5868308;
	break;
case "optimum":
	$category = 132;
	$product_id = 5868735;
	break;
case "standard":
	$category = 133;
	$product_id = 5868834;
	break;
case "business":
	$category = 134;
	$product_id = 5869490;
	break;
case "vip":
	$category = 135;
	$product_id = 5869984;
	break;
case "premium":
	$category = 138;
	$product_id = 5870110;
	break;
case "synchro":
	$category = 136;
	$product_id = 6700510;
	break;
}


$ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? intval($_REQUEST['tickets_count']) : 1;

$priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? intval($_REQUEST['price_variant']) : null;

switch (true) {
case ($ticketsCount < 5): break;
case ($ticketsCount <= 10): $promocode = "landSkidka15"; break;
case ($ticketsCount <= 20): $promocode = "landSkidka20"; break;
case ($ticketsCount <= 30): $promocode = "landSkidka25"; break;
case ($ticketsCount <= 40): $promocode = "landSkidka30"; break;
case ($ticketsCount <= 50): $promocode = "landSkidka40"; break;
default /* $tickets > 50 */: $promocode = "landSkidka50"; break;
}


$text = <<<HTML
Если у&nbsp;вас появились вопросы, <br>
вы&nbsp;можете связаться с&nbsp;нами по&nbsp;телефону:<br>
<br>
<b>8 (800) <span class="font-xbold">707-41-77</span></b>
HTML;

if ($_REQUEST['lang'] == 'en') $text = <<<HTML
For any questions feel free to&nbsp;contact&nbsp;us <br>
<b>8 (800) <span class="font-xbold">707-41-77</span></b>
HTML;

$popup_form_footer_text = $text;


$title = ($_REQUEST['lang'] != 'en') ? 'Выберите способ оплаты' : 'Choose payment method';
$button_text = ($_REQUEST['lang'] != 'en') ? 'Оплата банковской картой' : 'Check out with a Credit Card';

if ($priceVariant != 63) {
	$text = ($_REQUEST['lang'] != 'en') ? 'Выставить счет на оплату' : 'Get Invoice';
	$invoice_button = '<button class="button button6" name="payment-type-invoice">' . $text . '</button>';
}

$sendsuccess = <<<HTML
<div class="HTML-title" style="text-align:center;">$title</div>
<input name="name" value="$lead->name" type="hidden">
<input name="phone" value="$lead->phone" type="hidden">
<input name="email" value="$lead->email" type="hidden">
<input name="package" value="$package" type="hidden">
<input name="promocode" value="$promocode" type="hidden">
<input name="tickets_count" value="$ticketsCount" type="hidden">
<input name="price_variant" value="$priceVariant" type="hidden">
<input name="mergelead" value="$lead->mergelead" type="hidden">
<input name="payment-type" value="1" type="hidden">
<input name="form" value="buy-ticket" type="hidden">
<button class="button button6" name="payment-type-online">$button_text</button>
<br><br>
$invoice_button
<div class="popup__form-footer-text text-center" style="margin:30px auto 0;display: block;max-width:350px">
	$popup_form_footer_text
</div>
HTML;

$config['user']['sendsuccess'] = $sendsuccess . '<script>$.fancybox.update()</script>';
$config['ignore']['send_to_user'] = false;
