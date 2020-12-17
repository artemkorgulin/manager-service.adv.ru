<?php

$config['ignore']['send_to_user'] = false;

$ExpertSenderSubscriber = '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    <Data xsi:type="Subscriber">
       <Mode>AddAndUpdate</Mode>
       <ListId>110</ListId>
       <Email>' . $lead->email . '</Email>
       <Firstname>' . $lead->name . '</Firstname>
       <Properties>
          <Property>
             <Id>2</Id>
             <Value xsi:type="xs:string">' . $lead->phone . '</Value>
          </Property>
       </Properties>
    </Data>
 </ApiRequest>';

$curl = curl_init("https://api5.esv2.com/v2/Api/Subscribers");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderSubscriber);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$responseEs = curl_exec($curl);
curl_close($curl);

$ExpertSenderMessage = '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    <Data>
        <Receiver>
            <Email>' . $lead->email . '</Email>
        </Receiver>
    </Data>
</ApiRequest>';

$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1142");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($curl);
curl_close($curl);

$default_sendsuccess = "
    <div class='send-success'>
    <p>Спасибо! Ваша заявка отправлена. Вы&nbsp;получите ссылку на&nbsp;трансляцию в&nbsp;день мероприятия.</p>
    </div>
";

$config['user']['sendsuccess'] = $default_sendsuccess;
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_translation_30years.php';