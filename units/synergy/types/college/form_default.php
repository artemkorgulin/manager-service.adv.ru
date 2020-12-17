<?php

$excludeLandSMS = [
    'privilege-club'
];

$land = $_REQUEST['land'] ?? '';

if (!in_array($land, $excludeLandSMS)) {
    $curlSms = curl_init("https://syn.su/smsResponse.php");
    curl_setopt($curlSms, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curlSms, CURLOPT_POSTFIELDS, ["token" => "155f2ebf66e79d248cce9f9da4abda54", "type" => "synergy", "phone" => $lead->phone]);
    $responseSms = curl_exec($curlSms);
    curl_close($curlSms);
}

/* Конфигуратор FormMessages */
$config['user']['sendsuccess'] = $DefaultSuccessMessage . $redirect;

/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = true;
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_college');

###################
#### lp/card/ #####
###################
if ($_REQUEST['form'] == 'activation_card') {
    // Конфигуратор UserMail
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша Карта привилегий активирована!";
    $config['mail']['smtp']['user']['message'] = "<p>Поздравляем! Вы стали участником закрытого Клуба привилегий Университета «Синергия».</p>
        <p>Ваши возможности с&nbsp;Картой привилегий: <br>
        - Поступление в&nbsp;Университет «Синергия» вне конкурса первым потоком
        - Скидки от&nbsp;20%&nbsp;на&nbsp;обучение
        - Скидка 30%&nbsp;на&nbsp;весь период обучения обладателям дипломов с&nbsp;отличием
        - Бонусы от&nbsp;компаний-партнеров Университета
        - Безлимитная подписка на&nbsp;Базу Знаний и&nbsp;многое другое</p>
        <p>Поступите в&nbsp;наш Университет уже сегодня и&nbsp;получайте высшее образование на&nbsp;особых условиях! Вам доступны более чем 100&nbsp;программ обучения, <a href='http://synergy.ru/abiturientam/programmyi_obucheniya/' target='_blank'>узнайте о&nbsp;них все</a> и&nbsp;выберите ту, которая интересна именно вам.</p>
        <p>Желаем хорошего дня! <br>
        Команда Университета «Синергия»</p>";
}

//https://sd.synergy.ru/Task/View/326915
if ($_REQUEST['land'] == 'synergycollege.ru') {
    $DefaultSuccessMessage = "
  <div class='send-success'>
    <h3>Спасибо, ваше сообщение получено!</h3>
    <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
</div>";
}

//https://sd.synergy.ru/Task/View/326915
if ($lead->land == 'synergycollege.ru' || $lead->land == 'college_economics' || $lead->land == 'college_economics_bakalavriat') {
    $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Спасибо, ваша заявка принята.</h3>
    <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
</div>";
}