<?php
if ($_REQUEST['t'] != '') {
$curl = curl_init("https://my.synergy.ru/api/synergybase/v2/authorize/");
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");   
curl_setopt($curl, CURLOPT_FOLLOWLOCATION  ,1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded",
    "authorization: dCOD4iGzjePn6rHtcpO6"
]);
curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
    'userToken' => $_REQUEST['t']
]));
$response = curl_exec($curl);
//echo $response;

header("Location: https://synergybase.ru/login/?userToken=".$_REQUEST['t']);
curl_close($curl);
} else {
    header("Location: https://synergybase.ru/");
}


?>