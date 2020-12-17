<?php

// Конфигуратор UserMail
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «Ораторское искусство 2.0»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_gandapas.php';

if ($lead->version == 'with-prices') {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <p>Спасибо!</p>
    <p>Подтверждение регистрации направлено на ваш email.</p>
    <p class='jq-scroll'><a href='#tickets'>Перейти к выбору билета</a></p>
    </div>";


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
        'listId' => 160
    ]);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);


    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1680");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
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
}
// else {
//     $config['user']['sendsuccess'] = "
//     <div class='send-success'>
//     <h3>Заявка успешно отправлена!</h3>
//     <p>Спасибо!</p>
//     <p>Подтверждение регистрации направлено на ваш email. Наш менеджер свяжется с вами и подробно расскажет об условиях участия в тренинге.</p>
//     <p><a href='#popup_all-tickets' data-fancybox>Перейти к покупке билетов</a></p>
//     <script>
//     addMergeLead('" . $lead->mergelead . "');
//     $('[href=\"#popup_all-tickets\"]')[0].click();
//     </script>
//     </div>";
// }

if ($lead->land == 'gandapas-cross') {
//  $config['mail']['smtp']['user']['subject'] = "Регистрация на тренинг «{$_REQUEST['program']}»";
//  $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_gandapas_cross.php';

    $config['user']['sendsuccess'] = "
      <div class='send-success'>
      <h3>Заявка успешно отправлена!</h3>
      <p>Спасибо!</p>
      <p>Подтверждение регистрации направлено на ваш email. Наш менеджер свяжется с вами и подробно расскажет об условиях участия в тренинге.</p>
      <p><a href='#price'>Перейти к покупке билетов</a></p>
      </div>";
  
    $config['ignore']['send_to_user'] = false;
    
    /* ExpertSender - лист подписки */
    $ExpertSender = [
            'email'       => $lead->email,
            'name'        => $lead->name,
            'id'          => $lead->uuid,
            'land'        => $lead->land,
            'ip'          => $lead->ip,
            'dateCreated' => time(),
            'listId'      => 212
    ];

    $curl = curl_init('https://syn.su/worker/daemon-expertsender.php');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSender);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $responseEs = curl_exec($curl);
    curl_close($curl);
    
    /* ExpertSender - письмо */
    $ExpertSenderMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
            <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
            <Data>
                    <Receiver>
                            <Email>'.$lead->email.'</Email>
                    </Receiver>
            </Data>
    </ApiRequest>';

    $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/2497");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($curl);
    curl_close($curl);
}

if ($lead->grtag == 'gandapas_live') {
    $config['ignore']['send_to_user'] = false;
    $config['ignore']['getresponse'] = true;
}

if ($lead->land == 'gandapas-keynote') {
  $config['ignore']['send_to_user'] = false;
}