<?php

$config['ignore']['bitrix24'] = true;

$config['ignore']['send_to_user'] = false;

// $config['ignore']['getresponse'] = true;
// $config['newsletter']['getresponse']['account'] = 'synergy';
// $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_storm_berlin';

if ($lead->land == 'civilization' && $lead->form != 'application') {
    $config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Спасибо!</h3>
    <p>Ваша заявка отправлена.</p>
    <p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях участия в мероприятии.</p>
</div>
<script>
    $.fancybox.open({
        src : 'https://ticketbox.ru/framewidget/index.html?activityId=9636',
        type : 'iframe',
        opts : {
            iframe : {
                css : {
                    width: '800px'
                },
                attr : {
                    scrolling : 'no'
                }
            }
        }
    });
</script>";
}

if ($lead->land == 'civilization' && $lead->form == 'application') {
    $config['user']['sendsuccess'] = "
<div class='send-success'>
    <h3>Спасибо!</h3>
    <p>Ваша заявка отправлена.</p>
    <p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях участия в мероприятии.</p>
</div>";
}

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
    'listId' => 134
]);
$responseEs = curl_exec($curl);
curl_close($curl);


$message = <<<XML
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
<ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
<Data>
<Receiver>
  <Email>{$lead->email}</Email>
</Receiver>
</Data>
</ApiRequest>
XML;

$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1416");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
$responseEsMessage = curl_exec($curl);
curl_close($curl);
