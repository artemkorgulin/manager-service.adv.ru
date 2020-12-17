<?php
	if (isset($_REQUEST['merge_deal']) && isset($_REQUEST['product_id']) && isset($_REQUEST['order_amount']) && isset($_REQUEST['deal_currency']) && isset($_REQUEST['deal_amount']) && isset($_REQUEST['order_pay_date'])) {
        $postData = array(
            'merge_deal'     => $_REQUEST['merge_deal'],
            'product_id'     => $_REQUEST['product_id'],
            'order_amount'   => $_REQUEST['order_amount'],
            'deal_currency'  => $_REQUEST['deal_currency'],
            'deal_amount'    => $_REQUEST['deal_amount'],
            'order_pay_date' => $_REQUEST['order_pay_date'],
             'order_comment'  => $_REQUEST['order_comment'],
        );
        $curl = curl_init('https://corp.synergy.ru/api/crm/transform/pay');
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($curl);
        curl_close($curl);
        $json = json_decode($response);
        if (isset($json->message) && $json->message == 'OK') {
            echo "OK";
        } else {
            echo "FAIL";
        }
    }