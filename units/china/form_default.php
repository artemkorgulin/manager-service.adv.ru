<?php
$config['ignore']['bitrix24'] = true;
$config['ignore']['send_to_user'] = false;

$sendsuccess = "
	<div class='send-success'>
		<div class='send-success__title'>Спасибо!</div>
		Ваша заявка была успешно отправлена!
	</div>";

if ($lead->form == 'mainform' || $lead->form == 'footerform') {
  AMOsend("cbf2018-reg", $lead->name, $lead->email, $lead->phone, $lead);
}
if ($lead->form == 'smi') {
  AMOsend("cbf2018-smi", $lead->name . " | " . $_REQUEST['public'], $lead->email, $lead->phone, $lead);
  $sendsuccess = "
    <div class='send-success'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. Наша пресс-служба свяжется с вами в ближайшее время.
    </div>";
}
if ($lead->form == 'regist') {
  AMOsend("cbf2018-partner", $lead->name, $lead->email, $lead->phone, $lead);

}
if ($lead->form == 'expo') {
  AMOsend("cbf2018-stand", $lead->name, $lead->email, $lead->phone, $lead);
  $sendsuccess = "
    <div class='send-success'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. Мы свяжемся с вами и ответим на все ваши вопросы.
    </div>";
}
if ($lead->form == 'participate') {
  AMOsend("cbf2018-reg", $lead->name, $lead->email, $lead->phone, $lead);

  $sendsuccess = "
    <div class='send-success'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. Вы получите подтверждение регистрации на указанный email.
    </div>";
}
if ($lead->form == 'ticket') {
  AMOsend("cbf2018-tickets", $lead->name, $lead->email, $lead->phone, $lead);

  $sendsuccess = "
    <div class='send-success'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. Следите за нашими письмами - в них вы получите всю интересующую информацию.
    </div>";
}
if ($lead->form == 'importance') {
  AMOsend("cbf2018-reg", $lead->name, $lead->email, $lead->phone, $lead);

  $sendsuccess = "
    <div class='send-success'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. Вы получите подтверждение регистрации на указанный email.
    </div>";
}
if ($lead->form != 'price-2018' && $lead->form != 'smi' && $lead->form != 'sp') {
  $utm = [];
  if ($lead->url !== null) {
    $lead->url = htmlspecialchars_decode($lead->url);
    if (strpos($lead->url, "?") !== false) {
      $tmp = substr($lead->url, strpos($lead->url, "?") + 1);
      $tmp = explode("&", $tmp);
      foreach ($tmp as $v) {
        list($key, $var) = explode("=", $v);
        $utm[$key] = $var;
      }
    }
  }
  $sendsuccess .= "<script>location.href='https://synergychinaforum.ru/price/?" . http_build_query($utm) . "'</script>";
}

if ($lead->form == 'sp') {
	$sendsuccess = "
    <div class='send-success text-center'>
      <div class='send-success__title'>Спасибо!</div>
      Ваша заявка отправлена. В ближайшее время мы свяжемся.
    </div>";
}

$config['user']['sendsuccess'] = $sendsuccess;

function AMOsend($idForm, $name, $email, $phone, $lead)
{
  $utm = [];
  if ($lead->url !== null) {
    $lead->url = htmlspecialchars_decode($lead->url);
    if (strpos($lead->url, "?") !== false) {
      $tmp = substr($lead->url, strpos($lead->url, "?") + 1);
      $tmp = explode("&", $tmp);
      foreach ($tmp as $v) {
        list($key, $var) = explode("=", $v);
        $utm[$key] = $var;
      }
    }
  }
  /*$curl = curl_init("https://dimakovpak.com/api.client2crm/");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query(["idForm" => $idForm, "firstname" => $name, "email" => $email, "phone" => $phone]) . '&' . http_build_query($utm));
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;*/
  return true;
}




if ($lead->land == 'china-business-mission' && $lead->form != 'sp') {

  $config['ignore']['send_to_user'] = true;
  $config['mail']['smtp']['user']['subject'] = "Бизнес-миссия в Шанхай. Ваша заявка";
  $default_letter = include_once UNIT_DIR . '/letters/china-business-mission.php';

}






if ($lead->land != 'china-business-mission') {
/* ExpertSender - подписка */
  $ExpertSenderSubscriber = '
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
    <Data xsi:type="Subscriber">
       <Mode>AddAndUpdate</Mode>
       <ListId>107</ListId>
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
            <Email>' . $lead->email . '</Email>
        </Receiver>
    </Data>
</ApiRequest>';

  $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1125");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $ExpertSenderMessage);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($curl);
  curl_close($curl);
}
