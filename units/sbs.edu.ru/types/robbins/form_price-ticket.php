<?php
 
require_once(USEFUL_DIR . 'curl_json_post.php'); 

$product_id = $_REQUEST['product_id'] ?? 0; // если передается
 
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$tickets_count = isset($_REQUEST['tickets_count']) ? $_REQUEST['tickets_count'] : 1;
 
$api = 'https://payment.1001tickets.org:3000/api/transactionsproducts';
 
$product = array(
    'id' => $product_id,
    'count' => $tickets_count,
);
 
$post_fields = array(
    'email' => $lead->email,
    'mergelead' => $lead->mergelead,
    'transactionsTypeId' => 4,
    'products' => array($product),
    'discount' => $promocode,
);
 
$json = curl_json_post($api, $post_fields);
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