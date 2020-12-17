<?php

require_once(USEFUL_DIR . 'payment_transactional_product.php');


$product_id = isset($_REQUEST['product_id']) ? intval($_REQUEST['product_id']) : 0;
$promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';
$tickets_count = isset($_REQUEST['tickets_count']) ? intval($_REQUEST['tickets_count']) : 1;


$json = payment_transactional_product($lead, $product_id, $tickets_count);
$data = json_decode($json, true);


$success = '
	<div class="send-success">
	<h3>Заявка не отправлена!</h3>
	<p>Оплата данного товара пока что не возможна, попробуйте позже</p>
	<!-- ' . $json . ' -->
	</div>
';

if (isset($data['link'])) {
	//$success = '<iframe src="' . $data['link'] . '" style="width:90%%;height:700px;"></iframe>'; // два %% не ошибка
    
    $success = "
    
    <button class='button' data-fancybox data-type='iframe' data-src='" . $data['link'] . "'>Перейти к оплате</button>
    
    <style>
        .fancybox-slide--iframe .fancybox-content {
            background-color: transparent!important;
        }
        .fancybox-content {
            padding: 0!important;
        }
    </style>
    
    <script>
        $.fancybox.open({
            src: '" . $data['link'] . "',
            type: 'iframe'
        })
    </script>
    
    ";
}

$config['user']['sendsuccess'] = $success;
