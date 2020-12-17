<?php

$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, [
    'email' => $lead->email,
    'name' => $lead->name,
    'id' => $lead->uuid,
    'land' => $lead->land,
    'ip' => $lead->ip,
    'dateCreated' => time(),
    'listId' => 96
]);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEs = curl_exec($curl);
curl_close($curl);


$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/983");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
  <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
  <Data>
    <Receiver>
      <Email>' . $lead->email . '</Email>
    </Receiver>
  </Data>
</ApiRequest>');
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEsMessage = curl_exec($curl);
curl_close($curl);