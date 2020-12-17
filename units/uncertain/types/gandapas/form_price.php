<?php

require_once(USEFUL_DIR . 'payment_transactional_product.php');

define('SHOP_ID', 187); // берем из СРМ
 
$product_id = $_REQUEST['product_id'] ?? 0; // если передается
 
$promocode = isset($_REQUEST['promocode']) && $_REQUEST['promocode'] != '' ? $_REQUEST['promocode'] : 'Online10';
$count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;
 
$json = payment_transactional_product($lead, $product_id, $count, $discount, SHOP_ID);
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