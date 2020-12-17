<?php

$config['user']['sendsuccess'] = "
<div class=\"send-success\">
        <h3>Спасибо, Ваша заявка принята!</h3>
        <p>Мы&nbsp;направили подтверждение регистрации на&nbspВаш email.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
</div>";

if($lead->form == 'registration' or $lead->form == 'footer-form' or $lead->form == "speaker") {
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <p>Мы&nbsp;направили подтверждение регистрации на&nbsp;Ваш email.</p>
      <script>$('document').ready(function(){Hash.add('send','ok');});
        LanderJS.form();
        openTicketsModal();
      </script>
    </div>";
}

if($lead->form == 'call-order') {
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <p>Мы&nbsp;перезвоним Вам в&nbsp;указанное время.</p>
      <script>$('document').ready(function(){Hash.add('send','ok');}); openTicketsModal();</script>
    </div>";
}

if($lead->form == 'stand') {
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <p>Мы свяжемся с вами и ответим на все ваши вопросы.</p>
      <script>$('document').ready(function(){Hash.add('send','ok');}); openTicketsModal();</script>
    </div>";
}

if($lead->form == 'synergy-digital' or $lead->form == 'synergy-digital-mobile') {
  $config['ignore']['send_to_user'] = false;
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <script>$('document').ready(function(){Hash.add('send','ok');openTicketsModal();});</script>
    </div>";
}

if($lead->form == 'synergy-people' or $lead->form == 'become-partner' or $lead->form == 'become-sponsor') {
  $config['ignore']['send_to_user'] = false;
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <p>Мы&nbsp;свяжемся с&nbsp;Вами в&nbsp;ближайшее время.</p>
      <script>$('document').ready(function(){Hash.add('send','ok'); openTicketsModal();});</script>
    </div>";
}

if($lead->form == 'program') {
  $config['ignore']['send_to_user'] = false;
  $config['user']['sendsuccess'] = "
    <div class=\"send-success\">
      <h3>Спасибо, Ваша заявка принята!</h3>
      <p>Мы&nbsp;выслали программу форума на&nbsp;Ваш&nbsp;e-mail.</p>
      <script>$('document').ready(function(){Hash.add('send','ok'); document.getElementById('program-download').click(); openTicketsModal();});</script>
    </div>";
}

if($lead->land == 'synergysmmforum') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;
}

$config['ignore']['getresponse'] = false;

/* ExpertSender - подписка */
$ExpertSenderSubscriber = '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    <Data xsi:type="Subscriber">
       <Mode>AddAndUpdate</Mode>
       <ListId>77</ListId>
       <Email>'.$lead->email.'</Email>
       <Firstname>'.$lead->name.'</Firstname>
       <Properties>
          <Property>
             <Id>2</Id>
             <Value xsi:type="xs:string">'.$lead->phone.'</Value>
          </Property>
       </Properties>
    </Data>
 </ApiRequest>';

/* ExpertSender - лист подписки */
$curl = curl_init("https://api5.esv2.com/v2/Api/Subscribers");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderSubscriber);
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

$curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/713");
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($curl);
curl_close($curl);


/* Конфигуратор UserMail */
$config['ignore']['send_to_user']   = false;
$config['mail']['smtp']['user']['subject'] = "Ваша регистрация на Synergy SMM Forum";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergysmm/synergysmm.php';
