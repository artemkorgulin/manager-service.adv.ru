<?php

$sendsuccess = "<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
</div>";

$KEY = '7e0b3381bbd44489a57f8d008a1ff852';
$CRM = array(
        'r7k12id' => $_REQUEST['r7k12_si'] != '' ? $_REQUEST['r7k12_si'] : null,
        'type' => 'Form',
        'name' => $lead->name,
        'email' => $lead->email,
        'phone' => $lead->phone,
);
$context = stream_context_create(array(
        'http' => array(
                'method' => 'POST',
                'content' => json_encode($CRM),
        ),
));

file_get_contents("https://r7k12.ru/" . $KEY . "/crm/", false, $context);

$config['user']['sendsuccess'] = $sendsuccess;

if ($lead->land == 'china-business-mission') {

  $config['ignore']['send_to_user'] = true;
  $config['mail']['smtp']['user']['subject'] = "Бизнес-миссия в Шанхай. Ваша заявка";
  $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/china-business-mission.php';

}