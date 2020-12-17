<?php
	if (isset($_REQUEST['merge_deal']) && isset($_REQUEST['unsubscribe'])) {
        $postData = array(
            'merge_deal'     => $_REQUEST['merge_deal'],
            'unsubscribe'    => $_REQUEST['unsubscribe']
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