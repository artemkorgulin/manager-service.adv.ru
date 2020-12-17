<?php

require 'api/logger.class.php';
$logger = new logger();


$phpinput = file_get_contents('php://input');
$logger::add($phpinput);

$json = json_decode($phpinput);

if (isset($json->r7k12) && $json->r7k12 != '') {
    if ($json->type == 'deal') {
        sleep(4);
        $response = cURLsend(
            "https://api.r7k12.com/14666f197c79ea10f56232719373575e/addLeads",
            json_encode([[
                "id" => "$json->id",
                "name" => $json->titile,
                "dateCreate" => strtotime($json->dateCreate),
                "status" => "$json->statusId",
                "shop" => " ",
                "r7k12id" => "$json->r7k12",
                "price" => getPriceByProductId($json->productId),
                "clientId" => "$json->contactId",
                "manager" => "$json->responsibleId",
            ]])
        );
        $logger::add($response);
    }
}

function cURLsend($url, $postData)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    if ($postData != false) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

function getPriceByProductId($productId)
{
    $curl = curl_init("https://corp.synergy.ru/api/v2/");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(
        [
            "params" => [
                "v2" => 1,
                "action" => "getProducts"
            ],
            "data" => [
                "id" => $productId
            ]
        ]
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response)->data->PRICE * 1;
}
?>