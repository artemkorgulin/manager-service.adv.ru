<?php
###############################
##### Семинары и коучинги #####
###############################

/* Конфигуратор FormMessages */

$config['user']['sendsuccess'] = "
<div class='send-success'>
  <h3>Заявка успешно отправлена!</h3>
  <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
</div>";

if ($_REQUEST['cost'] > 0) {
  if ($_REQUEST['shop_id'] != -5) { //https://sd.synergy.ru/Task/View/88761 -5 для регионов
    $config['user']['sendsuccess'] .= "
	<script>$(document).ready(function(){
		var email_uf = '{$lead->email}';
		var shopid_uf =  {$_REQUEST['shop_id']};
		var cost = {$_REQUEST['cost']};
		var program = '{$_REQUEST['program']}';
		var name = '{$_REQUEST['name']}';

		//var ssulka_uf = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=' + shopid_uf + '&email=' + email_uf + '&LMI_PAYMENT_AMOUNT=' + cost + '&LMI_PAYMENT_DESC=' + program + ' | ' + name + '&preference=bankCard';
		var ssulka_uf = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}';

		var a = document.createElement('a');
		a.href = ssulka_uf;
		a.setAttribute('target', '_blank');
		a.click();
	});</script>";
  }
}

if ($lead->land == 'voroninpay') {
  $config['user']['sendsuccess'] .= "
    <script>$(document).ready(function(){
      var email_uf = '{$lead->email}';
      var shopid_uf =  {$_REQUEST['shop_id']};
      var cost = {$_REQUEST['cost']};
      var program = '{$_REQUEST['program']}';
      var name = '{$_REQUEST['name']}';

      //var ssulka_uf = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=' + shopid_uf + '&email=' + email_uf + '&LMI_PAYMENT_AMOUNT=' + cost + '&LMI_PAYMENT_DESC=' + program + ' | ' + name + '&preference=bankCard';
      var ssulka_uf = 'http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$_REQUEST['shop_id']}&price={$lead->cost}&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}';

        location.href = ssulka_uf;
    });</script>";
}


/* Конфигуратор GetResponse */
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'main'); // Было open_program


if ($lead->partner == 'tsoy') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Your request has been sent successfully!</h3>
    <p>{$lead->name}, you have successfully registered for the event. Check your e-mail  <b>{$lead->email}</b>, there you will find a letter with further instructions.</p>
  </div>";
}
if ($lead->form == 'look') {
  $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>{$lead->name}, вы успешно зарегистрировались на мероприятие.</p>
		{$redirect}
	</div>";
}
if ($lead->form == 'yakuba-sm-v1') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <p>{$lead->name}, вы успешно зарегистрировались на мероприятие.</p>
  </div>";
}
if ($lead->form == 'download-spb') {
  $config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3>Доступ предоставлен!</h3>
		<a href='{$link}' class='btn-redirect' target='_blank'>Посмотреть »</a>
		{$redirect}
	</div>";
}


/* Если &form=nolinkpay или &partner не пустой, то письмо приходит без ссылки на оплату */
if (($lead->form == 'nolinkpay') && (!empty($lead->partner)) && $lead->partner != 'default') {
  $linkpay = "";
  $shopId = '455815';
} else {
  $shopId = $_REQUEST['shop_id'];
  if ($shopId == '') {
    $shopId = '455571';
  }

  if ($lead->land == 'execution-regulyarnyij-menedzhment-dlya-raczionalnyix-rukovoditelej') {
    $shopId = '454977';
  }

}

/* 112640 - для семинара Кожемяки убираем */
/* 113114 - для семинара Завадского убираем*/
if (trim($lead->program) == 'Системные продажи и маркетинг на рынке В2В' ||
  $_REQUEST['formid'] == 7798 ||
  $_REQUEST['formid'] == 7797 ||
  trim($lead->program) == 'Эффективное управление отделом продаж' ||
  $_REQUEST['formid'] == 7830) {
  $linkpay = '';
} else {
  $linkpay = "
  <p>
    <b>Если Вы еще не оплатили участие</b> <br>
    Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. <br/> Мы используем сервис IntellectMoney.
  </p>
  <p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>

  <p style='margin:40px 0; text-align: center;'><a href='http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$shopId}&price={$lead->cost}&productName={$lead->program}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>

  <p>После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.</p>
  ";

}


/* http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId={$shopId}&price={$lead->cost}&productName={$lead->program}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}
БЫЛО

	<p style='margin:40px 0; text-align: center;'><a href='http://sbs.edu.ru/pay?name={$lead->name}&phone={$lead->phone}&email={$lead->email}&cost={$lead->cost}&program={$lead->program}'
	style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>

БЫЛО
 */

if ($lead->land == 'synergy-digital-forum-2019-ekb') {
  $url = "https://merchant.intellectmoney.ru/ru/?eshopId=458275&orderId=Digital_Forum_land&recipientAmount=5000&recipientCurrency=RUB";
  $linkpay = "
  <p>
    <b>Если Вы еще не оплатили участие</b> <br>
    Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. <br/> Мы используем сервис IntellectMoney.
  </p>
  <p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href='http://sbs.edu.ru/oferta?utm_source=tranzmail-sm'>публичной офертой</a>.</p>

  <p style='margin:40px 0; text-align: center;'><a href='" . $url . "' style='border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;' target='_blank'>Оплатить</a></p>

  <p>После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.</p>
  ";
}


if ($lead->land == 'lp_strelkova') {
  $linkpay = '';
}
if ($lead->land == 'networking-marathon' && $lead->form != 'popup-day-2') {
  $linkpay = '';
}


/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = true;
$config['mail']['smtp']['user']['subject'] = "Регистрация на программу «" . trim($lead->program) . "»";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_type_sm_kou.php';


/* Конфигуратор MessageForCallCentre */

if ($lead->campaign == 'triz_mk' && strpos($lead->land, 'lp_kozhemyako_kou-v1') !== null) {
  $config['ignore']['send_to_user'] = true;
}

if (isset($_REQUEST['partner'])) {
  $config['ignore']['send_to_cc'] = true;

  if ($_REQUEST['land'] == 'gandapas-kou-v2') {
    $config['mail']['smtp']['cc']['subject'] = "Заявка с ленда - Онлайн-практикум Гандапаса";
    $config['mail']['smtp']['cc']['message'] = "
    <p>
      Имя: <b>$lead->name</b>
      <br />Телефон: <b>$lead->phone</b>
      <br />Email: <b>$lead->email</b>
    </p>";
  }

  if ($_REQUEST['land'] == 'peregovoryi-na-million') {
    $config['mail']['smtp']['cc']['subject'] = "Заявка с ленда - Переговоры на миллион";
    $config['mail']['smtp']['cc']['message'] = "
    <p>
      Имя: <b>$lead->name</b>
      <br />Телефон: <b>$lead->phone</b>
      <br />Email: <b>$lead->email</b>
      <br />Способ: <b>$lead->radio</b>
    </p>";
  }

  if ($_REQUEST['partner'] == 'krasnova')
    $config['mail']['smtp']['cc']['emails'] = array(array('Ekrasnova@synergy.ru'));
  if ($_REQUEST['partner'] == 'neupokoeva')
    $config['mail']['smtp']['cc']['emails'] = array(array('ANeupokoeva@synergy.ru'));
}


if ($lead->land == 'marketing-na-360-gradusov') {
  $config['ignore']['send_to_user'] = false;
}

if ($lead->land == 'synergy-management-camp') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;

  $postData = [
    'email' => $lead->email,
    'name' => $lead->name,
    'id' => $lead->uuid,
    'land' => $lead->land,
    'ip' => $lead->ip,
    'dateCreated' => time(),
    'listId' => 102
  ];

  $curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $responseEs = curl_exec($curl);
  curl_close($curl);

  $postDataMessage = '
    <ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
        <ApiKey>GlC4gxWBorIRsSap7Bd8</ApiKey>
        <Data>
            <Receiver>
                <Email>' . $lead->email . '</Email>
            </Receiver>
        </Data>
    </ApiRequest>';

  $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1066");
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataMessage);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $response = curl_exec($curl);
  curl_close($curl);

}


if ($lead->land == 'vujicic-ms-v1-astana') {

  $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ»!";
    $config['mail']['smtp']['user']['message'] = '
        <h3>Здравствуйте, ' . $lead->name . '!</h3>

        <p>Вы успешно зарегистрировались на мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ» в городе <a href="https://sbs-vujicic.kz/nursultan/" target="_blank">Нур-Султан</a>!</p>
        
        <p>В ближайшее время с Вами свяжутся.</p>
        <p>Мы будем информировать Вас о знаменательных событиях в наших следующих письмах.</p>

        <p>С уважением,<br>
        Команда Школы Бизнесы «Синергия»</p>      
   ';

   $config['user']['sendsuccess'] = "
        <script>
          initPopupSuccess('#succsess');
        </script>
      ";
}

if ($lead->land == 'vujicic-ms-v1-almaty') {

  $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ»!";
    $config['mail']['smtp']['user']['message'] = '
        <h3>Здравствуйте, ' . $lead->name . '!</h3>

        <p>Вы успешно зарегистрировались на мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ» в городе <a href="https://sbs-vujicic.kz/almaty/" target="_blank">Алматы</a>!</p>
        
        <p>В ближайшее время с Вами свяжутся.</p>
        <p>Мы будем информировать Вас о знаменательных событиях в наших следующих письмах.</p>

        <p>С уважением,<br>
        Команда Школы Бизнесы «Синергия»</p>      
   ';

   $config['user']['sendsuccess'] = "
        <script>
          initPopupSuccess('#succsess');
        </script>
      ";
}


if ($lead->land == 'vujicic-ms-v1') {
   
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ»!";
    $config['mail']['smtp']['user']['message'] = '
         <h3>Здравствуйте, ' . $lead->name . '!</h3>

         <p>Вы успешно зарегистрировались на мастер-класс Ника Вуйчича и Ицхака Пинтосевича «Победитель лени. Жизнь без границ»!</p>

         <p>Школа Бизнеса «Синергия» организует мастер-классы с участием Ника и Ицхака в городах:</p>
         <ul>
         <li>12 сентября 2019г. <a href="https://sbs-vujicic.kz/almaty/" target="_blank">Алматы</a></li>
         <li>13 сентября 2019г. <a href="https://sbs-vujicic.kz/nursultan/" target="_blank">Нур-Султан</a></li>
         </ul>

         <p>В ближайшее время с Вами свяжутся.</p>

         <p>Мы будем информировать Вас о знаменательных событиях в наших следующих письмах.</p>

         <p>С уважением,<br>
         Команда Школы Бизнесы «Синергия»</p>
   ';
   
   $config['user']['sendsuccess'] = "
        <script>
          initPopupSuccess('#succsess');
        </script>
      ";
}


/* https://sd.synergy.ru/task/view/84001 */
if ($lead->land == 'naviyki-oratorskogo-masterstva') {
  $config['newsletter']['getresponse']['campaign'] = !empty($lead->grcampaign) ? $lead->grcampaign : 'drutko';
}

if ($lead->land == 'lp_strelkova') {

  $linkpay = '';

  if ($_REQUEST['redir']) {
    $config['user']['sendsuccess'] .= "<script>window.location.href='" . $_REQUEST['redir'] . "'</script>";
  }

  if ($_REQUEST['form'] == 'getvideo') {
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Видеозапись бесплатного мастер-класса Зои Стрелковой";
    $config['mail']['smtp']['user']['message'] = '
    <div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
      <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
        <a href="http://synergyregions.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/lp/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
      </div>
      <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
        <h3>Здравствуйте, ' . $lead->name . '!</h3>
        <p>Вы запросили запись вебинара Зои Стрелковой: "Управление дебиторской задолжностью"</p>
        <p>Запись доступна по ссылке: <a href="https://youtu.be/ckQmCBPR-wQ">https://youtu.be/ckQmCBPR-wQ</a></p>
        <p>Смотрите, внедряйте и получайте отличные результаты.</p>
        <p><b>Если вас интересует более глубокое изучение темы управления финансами компании, ждем вас 12-13 Октября на открытой программе Зои Стрелковой: "Финансы для не финансовых менеджеров"</b></p>
        <p><b>Узнать подробнее о программе и зарегистрироваться, можно <a href="http://sbs.edu.ru/lp/strelkova/sm-v1/?partner=' . $_REQUEST['partner'] . '&utm_source=tranzmail-sm">здесь</a></b></p>
        <hr style="color: #E5E5E5;">
        <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
      </div>
      <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. ' . $partner_phone . '</div>
    </div>
    ';
  }

}


if ($lead->land == 'transformation') {

  $config['user']['sendsuccess'] = "
                <script>
              //   location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/?no=cache';
                </script>";

  if ($lead->form == 'program') {
    $config['user']['sendsuccess'] = "
        <div class='send-success'>
          <h3>Спасибо!</h3>
          <p>Ваша заявка отправлена. <br>
          Проверьте вашу почту, мы выслали на нее программу.</p>
        </div>
      ";

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Ваша программа бизнес-форума «Трансформация» ";
    $config['mail']['smtp']['user']['message'] = "
        <div class='send-success'>
          <h3>Добрый день!</h3>
          <p>Вы оставляли заявку на&nbsp;получение программы форума &laquo;Трансформация&raquo;.</p>
          <p>Скачать программу вы можете, пройдя <a href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/programm.pdf?v=2809'>по&nbsp;ссылке.</a></p>
          <p>Успейте зарегистрироваться на&nbsp;форум&nbsp;&mdash; участие бесплатное.</p>
          <p><a href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/'>>>> Перейти к регистрации <<<</a></p>
        </div>
      ";
  } elseif ($lead->form == 'sponsor' || $lead->form == 'partner') {
    $config['user']['sendsuccess'] = "
        <div class='send-success'>
          <h3>Спасибо!</h3>
          <p>Ваша заявка отправлена. <br>
          Мы свяжемся с вами в ближайшее время, чтобы обсудить возможности нашего сотрудничества.</p>
        </div>
      ";

    $config['ignore']['send_to_user'] = false;

    $config['ignore']['send_to_cc'] = true;
    $config['mail']['smtp']['cc']['subject'] = "Заявка с ленда «Трансформация»";
    $config['mail']['smtp']['cc']['emails'] = array(array('sponsor.transformation@gmail.com'));
    $config['mail']['smtp']['cc']['message'] = "
      <h3>Заявка с ленда «Трансформация»</h3>
      <p>
        Имя: <b>$lead->name</b>
        <br />Телефон: <b>$lead->phone</b>
        <br />Email: <b>$lead->email</b>
      </p>";
  } else {


    $config['ignore']['send_to_user'] = false;



    if (isset($_REQUEST['INN'])) {
      if ($_REQUEST['INN'] == '') {
        $_REQUEST['INN'] == '770077';
      }
      $innR = preg_replace('~\D+~', '', $_REQUEST['INN']);
      $postData = array(
        'method' => 'checkInn',
        'inn' => $innR
      );
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, "http://syn.su/transformation.php");
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      $json = json_decode($response);
      if ($json->error == null) {
        if ($json->response != 'no') {
          $inn = $json->response->inn;
          $use = 5 - $json->response->use;
                //виджет сюда
          if ($inn == 773377 || $inn == 778877788777) {
            $use = 1;
          }

                //if($_REQUEST['version'] == 'tickets1001'){
          if (true) {

            if ($use <= 0) {

              $config['ignore']['bitrix24'] = false;
              $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, данный ИНН уже использовался при регистрации на форум.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';

            } else {
              $lead->innCode = preg_replace('~\D+~', '', $_REQUEST['INN']);
              switch ($use) {
                case 1:
                  $topText = 'Вам доступен 1 бесплатный билет в любом свободном секторе';
                  break;
                case 2:
                  $topText = 'Вам доступно 2 бесплатных билета в любых свободных секторах';
                  break;
                case 3:
                  $topText = 'Вам доступно 3 бесплатных билета в любых свободных секторах';
                  break;
                case 4:
                  $topText = 'Вам доступно 4 бесплатных билета в любых свободных секторах';
                  break;
                case 5:
                  $topText = 'Вам доступно 5 бесплатных билетов в любых свободных секторах';
                  break;
              }
                   // $topText = ($use == 5) ? 'Вам доступно 5 бесплатных билетов в любых свободных секторах' : 'Вам доступен 1 бесплатный билет в любом свободном секторе';
              $successsend = "<!--<div class='send-success'>
                        <h3>Спасибо!</h3><p>Теперь вы можете перейти к выбору мест на схеме. $topText</p><div class='btn btn-danger open1001'>Выбрать места</div>
                      </div>-->
                      <script>
                      $(document).trigger('event1001:load')
                      $.extend(true, window.api1001_params, {

                        defaults: {

                          name: '{$lead->name}',
                          phone: '{$lead->phone}',
                          email: '{$lead->email}',
                          comment: 'test'";
              if ($inn == 773377) {
                $successsend .= ",sectorPriority: [106,91, 92, 90, 93, 89, 94, 88, 95, 45, 46, 87, 96, 104, 103, 44, 47, 43, 48, 72, 73, 71, 74, 42, 49, 70, 75, 41, 50, 59, 60, 69, 76, 86, 97, 40, 51, 58, 61, 85, 98, 84, 99, 39, 52, 57, 62, 68, 77, 67, 78, 83, 100, 38, 53, 82, 101, 56, 63, 81, 102, 37, 54, 55, 64, 66, 79, 65, 80]";
              } else if ($inn == 778877788777) {
                $successsend .= ",sectorPriority: [105]";
              } else {
                $successsend .= ",sectorPriority: [91, 92, 90, 93, 89, 94, 88, 95, 45, 46, 87, 96, 104, 103, 44, 47, 43, 48, 72, 73, 71, 74, 42, 49, 70, 75, 41, 50, 59, 60, 69, 76, 86, 97, 40, 51, 58, 61, 85, 98, 84, 99, 39, 52, 57, 62, 68, 77, 67, 78, 83, 100, 38, 53, 82, 101, 56, 63, 81, 102, 37, 54, 55, 64, 66, 79, 65, 80]";
              }

              $successsend .= "},
                        topText: '{$topText}',
                        maxSeatsSelect: {$use},
                        additionally: {

                          mergelead: {
                            name: 'mergelead',
                            value: '{$lead->mergelead}'
                          },
                          land: {
                            name: 'land',
                            value: '{$lead->land}'
                          },
                          inn: {
                            name: 'ИНН',
                            value: '{$inn}'
                          }

                        }
                      });
                      </script>
                    ";
              $config['user']['sendsuccess'] = $successsend;

            } // else if $use <= 0

          } else {

            $config['user']['sendsuccess'] = "
                  <script>
                  $('#status-popup__content').html('<h3>Спасибо!</h3><h4>Ваша заявка отправлена</h4><p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами и&nbsp;расскажем все подробности об&nbsp;участии в&nbsp;бизнес-форуме &laquo;Трансформация&raquo;.</p>');
                  //$.fancybox.close();
                  $.fancybox.open( {href: '#status-popup', padding: 0} );
                  </script>";

          } // else if $_REQUEST['version'] == 'tickets1001'

        } else {
                    /*$config['ignore']['bitrix24'] = false;
                    $config['user']['sendsuccess'] = '
                    <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                          </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>
                          Введен некорректный ИНН. Пожалуйста, введите корректный номер.';*/

          if (isset($json->responseCode) && $json->responseCode == 200501) {
            $config['ignore']['bitrix24'] = false;
            $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">ИП или ООО с таким ИНН не зарегистрирован в Москве.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
          } else {
            $config['ignore']['bitrix24'] = false;
            $config['user']['sendsuccess'] = '
                      <div class="form-group">
                          <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                          <b style="font-size: 20px; color: #be1317">Введен некорректный ИНН. Пожалуйста, введите корректный номер.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
          }

        } // else if $json->response != 'no'
      } else {
        $config['ignore']['bitrix24'] = false;
      } //else if $json->error == null



    } else {
      $config['ignore']['bitrix24'] = true;
   
            // $config['user']['sendsuccess'] = "
            // <script>
            // $('#status-popup__content').html('<h3>Спасибо!</h3><h4>Ваша заявка отправлена</h4><p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами и&nbsp;расскажем все подробности об&nbsp;участии в&nbsp;бизнес-форуме &laquo;Трансформация&raquo;.</p>');
            // $.fancybox.close();
            // $.fancybox.open( {href: '#status-popup', padding: 0} );
            // </script>";


      if (true || $lead->email == 'nkuznetsov@synergy.ru') {

        if (!isset($_REQUEST['orderid'])) {
          if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && $_REQUEST['name'] != '' && $_REQUEST['email'] != '') {
            $seat = '7094';

            $fullname = $lead->name;

            if (isset($_REQUEST['name2'])) {

              $fullname .= ' ' . $_REQUEST['name2'];

            }

            $postData = [
              'method' => 'createOrder',
              'name' => $fullname,
              'phone' => $lead->phone,
              'email' => $lead->email,
              'promocode' => '',
              'payment_type' => 'online',
              'comment' => '',
              'seats' => $seat,
              'names' => $fullname,
              'names2' => ' ',
              'token' => 'lsdkjnzfFDK435JKJf',
              'additionally' => '{"land":{"name":"land","value":"' . $lead->land . '"},"mergelead":{"name":"mergelead","value":"' . $lead->mergelead . '"},"inn":{"name":"ИНН","value":"776677"}}',
              'lang' => 'ru',
              'company' => '',
              'phones' => '',
              'emails' => '',
              'comments' => '',
              'additionallys' => '{"a":1}',
              'currency_onlinePay' => 'RUB',
              'currency_invoicePay' => 'RUB',
              'lang_invoicePay' => 'RU',
              'lang_onlinePay' => 'RU',
            ];
            $postData = http_build_query($postData);
            $response = cURLsend('https://api.1001tickets.org/events/13', $postData);
            $config['user']['sendsuccess'] = '<h3>Спасибо! Билеты будет отправлен на ваш email.</h3>';
          } else {
            $config['user']['sendsuccess'] = '<h3>Спасибо! Ваша заявка отправлена.</h3>';
          }
        }

        if (isset($_REQUEST['fb'])) {

          $response = json_decode($response);

          $config['user']['sendsuccess'] = '
              	 <input type="hidden" name="orderid" value="' . $response->response->txt . '">
              	 <input type="hidden" name="mergelead" value="' . $lead->mergelead . '">
              	 <input type="hidden" name="name" value="' . $lead->name . '">
              	 <input type="hidden" name="phone" value="' . $lead->phone . '">
              	 <input type="hidden" name="email" value="' . $lead->email . '">
                 <input type="hidden" name="land" value="transformation_v4">
              	 <div class="register-popup__form-bottom">
				</div>
              	 <div class="register-popup__tip">Укажите номер ИНН вашего ООО или&nbsp;ИП <b>зарегистрированного в&nbsp;Москве</b><!-- . По&nbsp;одному ИНН могут принять участие пять человек&nbsp;&mdash; как собственники, так и&nbsp;любые другие сотрудники компании. --></div>
							<div class="form__group">
								<input class="form__input" type="text" name="INN" value="" placeholder="ИНН">
							</div>
              	 
					     <button class="form__button" type="submit"><span>Отправить</span> <span class="button__arrow">&#x27F6;</span></button>';

        }

        if (isset($_REQUEST['orderid'])) {

          $config['ignore']['bitrix24'] = false;

          $res = cURLsend('https://api.1001tickets.org/events/13', http_build_query([

            'method' => 'updateAdditionally',
            'orderId' => $_REQUEST['orderid'],
            'additionally' => '{"land":{"name":"land","value":"' . $lead->land . '"},"mergelead":{"name":"mergelead","value":"' . $lead->mergelead . '"},"inn":{"name":"ИНН","value":"' . $_REQUEST['INN3'] . '"}}'

          ]));

          $config['user']['sendsuccess'] = '<style>.register-popup__tip{display:none}</style><h3>Спасибо! Билет будет отправлен на ваш email.</h3>';

        }

      } else {
        $config['ignore']['getresponse'] = true;
        $config['newsletter']['getresponse']['account'] = 'sbsedu';
        $config['newsletter']['getresponse']['campaign'] = 'transformation_no_inn';
        $config['user']['sendsuccess'] = "<script>var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "'; form_2.attr('action', action_2);</script>";
      }

    }
  }

}

if ($lead->land == 'transform') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = true;
  $config['newsletter']['getresponse']['account'] = 'synergy';
  $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_transm';
  if (isset($_REQUEST['version']) && $_REQUEST['version'] == '7v') {
    $config['user']['sendsuccess'] = "<script>location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/choice-of-participation/index-7.php?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';</script> ";
  } else if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'kz') {
    $config['user']['sendsuccess'] = "<script>location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/choice-of-participation/?version=kz&discount={$_REQUEST['discount']}';</script> ";
  } else {
    if (true || $lead->email == "nkuznetsov@synergy.ru") {
      $config['user']['sendsuccess'] = "
                <script>
                location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/choice-of-participation/?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}&m={$_REQUEST['mergelead']}';
                </script>
                ";
      if ($lead->email == "nkuznetsov@synergy.ru") {
        if ($lead->form == "conception-block") {
          if ($_REQUEST['cost'] == 0) {
            $error = false;
            $postData = [
              "shopId" => $_REQUEST['shopId'],
              "productName" => "Бизнес-Марафон ТРАНСФОРМАЦИЯ",
              "price" => $_REQUEST['cost'],
              "name" => $lead->name,
              "discount" => $_REQUEST['discount'],
              "productQ" => $_REQUEST['product_q'],
              "email" => $lead->email,
              "mergelead" => $lead->mergelead,
              "productId" => $_REQUEST['product_id']
            ];
            $response = cURLsend("https://payment.1001tickets.org/transformation/createInvoice.php", $postData);
            $json = json_decode($response);
          }
        }
      }
    } else {
      $config['user']['sendsuccess'] = "
                <script>
                location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';
                </script>
                ";
    }
    if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'rec') {
      $config['user']['sendsuccess'] = "
                <script>
			location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/index-month.php?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';
                </script>
                ";
    }
  }
}

if ($lead->land == 'transform_v2') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = true;
  $config['newsletter']['getresponse']['account'] = 'synergy';
  $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_transm';
  if (isset($_REQUEST['version']) && $_REQUEST['version'] == '7v') {
    $config['user']['sendsuccess'] = "<script>location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/v2/choice-of-participation/index-7.php?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';</script> ";
  } else if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'kz') {
    $config['user']['sendsuccess'] = "
    <script>
    location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/v2/choice-of-participation/?version=kz&name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}&m={$_REQUEST['mergelead']}';
    </script>
    ";
  } else {
    if (true || $lead->email == "nkuznetsov@synergy.ru") {
      $config['user']['sendsuccess'] = "
                <script>
                location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/marafon/v2/choice-of-participation/?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}&m={$_REQUEST['mergelead']}';
                </script>
                ";
      if ($lead->email == "nkuznetsov@synergy.ru") {
        if ($lead->form == "conception-block") {
          if ($_REQUEST['cost'] == 0) {
            $error = false;
            $postData = [
              "shopId" => $_REQUEST['shopId'],
              "productName" => "Бизнес-Марафон ТРАНСФОРМАЦИЯ",
              "price" => $_REQUEST['cost'],
              "name" => $lead->name,
              "discount" => $_REQUEST['discount'],
              "productQ" => $_REQUEST['product_q'],
              "email" => $lead->email,
              "mergelead" => $lead->mergelead,
              "productId" => $_REQUEST['product_id']
            ];
            $response = cURLsend("https://payment.1001tickets.org/transformation/createInvoice.php", $postData);
            $json = json_decode($response);
          }
        }
      }
    } else {
      $config['user']['sendsuccess'] = "
                <script>
                location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';
                </script>
                ";
    }
    if (isset($_REQUEST['version']) && $_REQUEST['version'] == 'rec') {
      $config['user']['sendsuccess'] = "
                <script>
			location.href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/choice-of-participation/index-month.php?name={$_REQUEST['name']}&discount={$_REQUEST['discount']}&email={$_REQUEST['email']}';
                </script>
                ";
    }
  }


  switch ($lead->form) {
    case 'partner':
      $str = 'и&nbsp;расскажет о&nbsp;партнерских возможностях';
      break;
    case 'stab':
      $str = 'и&nbsp;расскажет, как стать руководителем регионального штаба';
      break;
    case 'ambassador':
      $str = 'и&nbsp;расскажет, как стать амбассадором';
      break;
    case 'instrument':
      $str = 'и&nbsp;расскажет подробнее о выбранном инструменте';
      break;
    default:
      $str = '';
  }

  if ($lead->form == 'partner' || $lead->form == 'stab' || $lead->form == 'ambassador' || $lead->form == 'instrument') {
    $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Спасибо, ваша заявка отправлена!</h3>
        <p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами {$str}</p>
      </div>
      <script>

          (function(){

            setTimeout(function(){

              location.href = 'http://synergy.ru/lp/thanks/?utm_source=thanks';

            }, 0);

          })();

        </script>
    ";

    $config['ignore']['send_to_user'] = false;
  }



  // if( $lead->form == 'instrument_8' ) {
  //   $config['user']['sendsuccess'] = "
  //     <div class='send-success'>
  //       <h3>Спасибо!</h3>
  //       <p>Мы направили на&nbsp;вашу электронную почту подробное описание услуг компании Synergy Consulting, которая поможет вывести ваш бизнес на&nbsp;новый уровень эффективности.</p>
  //     </div>
  //   ";

  //   $config['ignore']['send_to_user']   = true;
  //   $config['mail']['smtp']['user']['subject'] = "Описание услуг компании Synergy Consulting";
  //   $config['mail']['smtp']['user']['message'] = "
  //     <div class='send-success'>
  //       <h3>Добрый день!</h3>
  //       <p>Скачать коммерческое предложение вы можете, пройдя <a href='http://xn--80aayoegldhg0a2a2j.xn--p1ai/upload/Synergy-Consulting.pdf'>по&nbsp;ссылке.</a></p>
  //     </div>
  //   ";
  // }
}

if ($lead->land == 'transform2') {
  $config['ignore']['send_to_user'] = false;
  $config['ignore']['getresponse'] = false;
    // <input type='hidden' name='name' placeholder='ФИО' value='".$_REQUEST['name']."' class='GoodLocal'>         <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='".$_REQUEST['email']."'>         <input type='hidden' class='form__input' name='price' placeholder='price' value='".$_REQUEST['price']."'>         <a href='#popup-form' data-price='".$_REQUEST['price']."' class='variables-button-href fancybox'>Принять участие</a>
// $config['user']['sendsuccess'] = " <div class='bgr-11'><div class='popup-top'><iframe class='mobile-frame' src='https://payment.1001tickets.org/cloudpayments/?email=".$_REQUEST['email']."&price=".$_REQUEST['price']."&name=".$_REQUEST['name']."'></iframe></div></div> ";
   // if ($_REQUEST['version'] == 'test') {
  if ($lead->form == 'show-more') {
    $config['user']['sendsuccess'] = "
        <div class='send-success'>
          <h3>Спасибо!</h3>
                 <p>В ближайшее время наши менеджеры свяжутся с вами.</p>
        </div>
      ";
  } else {


    $_payment_message = "Оплата трансформация";

    if ($lead->email == "test@test.ru") {
      switch ($_REQUEST['price']) {
        case 1000:
          $_payment_message = "1";
          break;
        case 3000:
          $_payment_message = "2";
          break;
        case 10000:
          $_payment_message = "3";
          break;
        case 30000:
          $_payment_message = "4";
          break;
        case 50000:
          $_payment_message = "5";
          break;
        case 100000:
          $_payment_message = "6";
          break;
      }
    }




    $config['user']['sendsuccess'] = "
        <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
        <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
        <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
        <button class='variables-button' type='submit' >Принять участие</button>

         <script>
         $.fancybox('https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "', {type:'iframe'})
         </script>";

    if (isset($_REQUEST['product_id']) && $_REQUEST['product_id'] != '') {
      $discount = 0;
      if (isset($_REQUEST['discount']) && $_REQUEST['discount'] != '') {
        $discount = $_REQUEST['discount'];
      }
      $config['user']['sendsuccess'] = "
          <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
          <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
          <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
          <button class='variables-button' type='submit' >Принять участие</button>
          <script>
            $.fancybox('https://payment.1001tickets.org/cloudpayments/?email=" . $_REQUEST['email'] . "&price=" . $_REQUEST['price'] . "&name=" . $_REQUEST['name'] . "&message=" . $_payment_message . "&discount=" . $discount . "&productId=" . $_REQUEST['product_id'] . "&recurrent=off', {type:'iframe'})
          </script>";
    }

    if (true || $lead->email == "nkuznetsov@synergy.ru") {
      $error = false;
      $postData = [
        "shopId" => $_REQUEST['shopId'],
        "productName" => "Бизнес-Марафон ТРАНСФОРМАЦИЯ",
        "price" => $_REQUEST['price'],
        "name" => $lead->name,
        "discount" => $_REQUEST['discount'],
        "productQ" => $_REQUEST['product_q'],
        "email" => $lead->email,
        "mergelead" => $lead->mergelead,
        "productId" => $_REQUEST['product_id'],
        "phone" => $lead->phone
      ];

      $response = cURLsend("https://payment.1001tickets.org/transformation/createInvoice.php", $postData);
      $json = json_decode($response);

      if ($json->error == null) {
        $responseUser = "<script>
              var rnd = Date.now();
              $('body').append('<iframe id=\"imframe'+rnd+'\" name=\"imframe'+rnd+'\"  style=\"display:none;height: 540px !important;width: 350px !important;\"></iframe>');
              $('body').append('<form method=\"POST\" id=\"imform'+rnd+'\" target=\"imframe'+rnd+'\" action=\"" . $json->response->link . "\"><input name=\"i\" type=\"hidden\" value=\"" . $json->response->i . "\"></form>');
                    $.fancybox('#imframe'+rnd, {helpers: {overlay:{media: {},locked:true}}});
              $('#imform'+rnd).submit();
                  </script>";
      } else {
        $error = true;
      }
      if (!$error) {
        $config['user']['sendsuccess'] = "
              <input type='hidden' name='name' placeholder='ФИО' value='" . $_REQUEST['name'] . "' class='GoodLocal'>
              <input type='hidden' class='form__input' name='email' placeholder'e-mail' value='" . $_REQUEST['email'] . "'>
              <input type='hidden' class='form__input' name='price' placeholder='price' value='" . $_REQUEST['price'] . "'>
              <button class='variables-button' type='submit' >Принять участие</button>" . $responseUser;
      } else {
        $config['user']['sendsuccess'] = "<div class='send-success'>
              <h3>Спасибо, ваша заявка принята.</h3>
              <p>В&nbsp;ближайшее время с&nbsp;вами свяжутся.</p>
            </div>";
      }
    }
  }

  if (isset($_REQUEST['step1'])) {

    $config['user']['sendsuccess'] = "<script>
      	$(window).trigger('getstep:paymenttype');
      	$('[name=\"name\"]').val('{$lead->name}');
      	$('[name=\"phone\"]').val('{$lead->phone}');
      	$('[name=\"email\"]').val('{$lead->email}');
      	</script>";

  }

  if (isset($_REQUEST['payment-invoice'])) {

    $config['user']['sendsuccess'] = "<script>$(window).trigger('getstep:company');</script>";

  }

  if (isset($_REQUEST['company'])) {

    $products = array(

      '3584689' => 'Базовый',
      '3694787' => 'Продвинутый',
      '3694799' => 'Продвинутый+Куратор',
      '36947866' => 'Персональный тренер'

    );

    $config['user']['sendsuccess'] = "<h3>Спасибо!</h3><p>Сформированный счет для оплаты будет скачан автоматически в течение 3 секунд...</p><script>$('body').append('<iframe src=\"https://payment.1001tickets.org/sgf/transform_marafon/invoice.php?summ={$_REQUEST['price']}&company={$_REQUEST['company']}&package={$products[$_REQUEST['product_id']]}\" style=\"display:none\" frameborder=\"0\"></iframe>')</script>";

  }


  //  }
}

if ($lead->land == 'transform' && $lead->form == 'register-popup-marafon') {

  $config['user']['sendsuccess'] = "
  <script>
  $(document).ready(function(){
    setTimeout(function() {
     window.location.href = 'http://трансформация.рф/'
   }, 100);
 });
 </script>
 ";

}

if ($lead->land == 'transform' && $lead->form == 'sub') {

  $config['ignore']['send_to_user'] = false;

  $config['ignore']['getresponse'] = true;
  $config['newsletter']['getresponse']['account'] = 'synergy';
  $config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_subtrance';

  $config['user']['sendsuccess'] = "
      <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>Видеозаписи форума вы получите на указанный e-mail.</p>
      </div>
    ";

}


if ($lead->land == 'transform' && $lead->form == 'transformation-download') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Спасибо.</h3>
    <p>Скоро на вашу почту придет письмо с видео. </p>
  </div>";
}


if ($lead->land == 'plan2018') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
   <script>location.href='http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=455571&price=" . $_REQUEST['radio'] . "&productName={$lead->program} | {$lead->name}&type=sbs&email={$lead->email}&username={$lead->name}&mergelead={$lead->mergelead}&httpreferer={$lead->url}'; </script>
  </div>";
}


if ($lead->land == 'transformation-kazan') {
  $config['ignore']['send_to_user'] = false;

  if ($lead->name == 'testotest') {
    $config['user']['sendsuccess'] = "<script>var form_btns = $('form.register-popup__form_btns'); $('div.register-popup__step_1').hide();$('div.register-popup__step_btns').show(); var action_btns = form_btns.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation-kazan&dater=26 октября&partner=&version=&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_btns.attr('action', action_btns);</script>";

    if ($lead->form != 'register-popup') {
      if (true) {
        $back = '$(document).on(\'click\', \'#backBtn\', function(e) {$.fancybox.open(\'#register-popup\');});';
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_btns = $('form.register-popup__form_btns'); $('div.register-popup__step_1').hide();$('div.register-popup__step_btns').show(); var action_btns = form_btns.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation-kazan&dater=26 октября&partner=&version=&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_btns.attr('action', action_btns);</script>";
      } else {

      }
    }

  } else {

    $config['user']['sendsuccess'] = 'Спасибо за&nbsp;предварительную регистрацию. Будем держать вас в&nbsp;курсе!';

  }

}

if ($lead->land == 'transformation_v4') {
  $config['ignore']['send_to_user'] = false;
  if (isset($_REQUEST['INN'])) {
    $innR = preg_replace('~\D+~', '', $_REQUEST['INN']);
    //$innR = 778877788777;
    $postData = [
      'method' => 'checkInn',
      'inn' => $innR
    ];
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://syn.su/transformation.php");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response);
    if ($json->error == null) {
      if ($json->response != 'no') {
        $inn = $json->response->inn;
        $use = 5 - $json->response->use;
      //  $inn = 778877788777;
      /*  if ($inn == 773377 || $inn == 778877788777) {
          $use = 1;
        }*/
        if (true) {
          if ($use <= 0) {
            $config['ignore']['bitrix24'] = false;
            $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, данный ИНН уже использовался при регистрации на форум.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
          } else {
            $lead->innCode = preg_replace('~\D+~', '', $_REQUEST['INN']);
            switch ($use) {
              case 1:
                $topText = 'Вам доступен 1 бесплатный билет';
                break;
              case 2:
                $topText = 'Вам доступно 2 бесплатных билета';
                break;
              case 3:
                $topText = 'Вам доступно 3 бесплатных билета';
                break;
              case 4:
                $topText = 'Вам доступно 4 бесплатных билета';
                break;
              case 5:
                $topText = 'Вам доступно 5 бесплатных билетов';
                break;
            }





            $config['user']['sendsuccess'] = "<input type='hidden' name='land' value='transformation_v4'><input type='hidden' name='mergelead' value='" . $lead->mergelead . "'><script>$('.register-popup__caption-step').html('Шаг 2 из 2');$('.register-popup__tip').html('{$topText}');</script>Укажите, сколько билетов вам требуется<div class=\"form-group\"><input class=\"form-control\" type=\"number\" name=\"tickets_count\" min=\"1\" value=\"1\" max=\"{$use}\" placeholder=\"Количество билетов\"></div><div class=\"form-group\"><input type=\"hidden\" name=\"inn_res\" value=\"{$lead->innCode}\"><input type=\"hidden\" name=\"name\" value=\"{$lead->name}\"><input type=\"hidden\" name=\"use\" value=\"{$use}\"><input type=\"hidden\" name=\"email\" value=\"{$lead->email}\"><input type=\"hidden\" name=\"phone\" value=\"{$lead->phone}\"><input type=\"hidden\" name=\"mergelead\" value=\"{$lead->mergelead}\"><div class=\"row\"><div class=\"col-sm-6\"></div><div class=\"col-sm-6\"><button class=\"form__button button button_gradient\" id='btnnexttwo' type=\"submit\"><span>Далее</span> <span class=\"button__arrow\">&#x27F6;</span></button></div></div></div><script>$('.register-popup__form.register-popup__form-2').submit()</script>";
          } // else if $use <= 0
        } else {

          $config['user']['sendsuccess'] = "
                  <script>
                  $('#status-popup__content').html('<h3>Спасибо!</h3><h4>Ваша заявка отправлена</h4><p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами и&nbsp;расскажем все подробности об&nbsp;участии в&nbsp;бизнес-форуме &laquo;Трансформация&raquo;.</p>');
                  //$.fancybox.close();
                  $.fancybox.open( {href: '#status-popup', padding: 0} );
                  </script>";

        } // else if $_REQUEST['version'] == 'tickets1001'

      } else {
                    /*$config['ignore']['bitrix24'] = false;
                    $config['user']['sendsuccess'] = '
                    <div class="form-group">
                            <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                          </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>
                          Введен некорректный ИНН. Пожалуйста, введите корректный номер.';*/

        if (isset($json->responseCode) && $json->responseCode == 200501) {
          $config['ignore']['bitrix24'] = false;
          $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">ИП или ООО с таким ИНН не зарегистрирован в Москве.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
        } else {
          $config['ignore']['bitrix24'] = false;
          $config['user']['sendsuccess'] = '
                      <div class="form-group">
                          <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                          <b style="font-size: 20px; color: #be1317">Введен некорректный ИНН. Пожалуйста, введите корректный номер.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
        }

      } // else if $json->response != 'no'
    } else {
      $config['ignore']['bitrix24'] = false;
    } //else if $json->error == null



  } else {
    $config['ignore']['bitrix24'] = true;

            // $config['user']['sendsuccess'] = "
            // <script>
            // $('#status-popup__content').html('<h3>Спасибо!</h3><h4>Ваша заявка отправлена</h4><p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами и&nbsp;расскажем все подробности об&nbsp;участии в&nbsp;бизнес-форуме &laquo;Трансформация&raquo;.</p>');
            // $.fancybox.close();
            // $.fancybox.open( {href: '#status-popup', padding: 0} );
            // </script>";
            //




    if (isset($_REQUEST['tickets_count']) || $lead->email == 'nkuznetsov@synergy.ru' || true) {
      if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && $_REQUEST['name'] != '' && $_REQUEST['email'] != '') {

        $count = $_REQUEST['tickets_count'];
        if (true) {
          if ($_REQUEST['tickets_count'] > 5) {
            die('<div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, Вам не доступно указанное количество билетов.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>');
          }

          $category = 588;
          $sector = 0;

          // platinum inn
          if ($_REQUEST['inn_res'] == 77668855991) {
            $sector = 1039;
          }
          if ($_REQUEST['inn_res'] == 77668855992) {
            $sector = 1040;
          }

          // vip inn
          if ($_REQUEST['inn_res'] == 77880088771) {
            $sector = 1043;
          }
          if ($_REQUEST['inn_res'] == 77880088772) {
            $sector = 1046;
          }


          /*if ($_REQUEST['inn_res'] == 7777788888) {
            $category = 165;
          }
          if ($_REQUEST['inn_res'] == 77887788778877) {
            $category = 165;
          }

          if ($_REQUEST['inn_res'] == 770708389311) {
            $category = 165;
          }

          if ($_REQUEST['inn_res'] == 7702384463) {
            $category = 164;
            $sector = 711;
          }

          if ($_REQUEST['inn_res'] == 732818807815) {
            $category = 164;
          }

          if ($_REQUEST['inn_res'] == 732818807815) {
            $category = 164;
          }*/

          if ($sector == 0) {
            $seat = getSeatsRandom($count, $category, false, '105');
          } else {
            $seat = getSeatsRandom($count, $category, $sector, '105');
          }
          $fullname = $lead->name;

          $postData = [
            'method' => 'createOrder',
            'name' => $fullname,
            'phone' => $lead->phone,
            'email' => $lead->email,
            'promocode' => '',
            'payment_type' => 'online',
            'comment' => '',
            'seats' => $seat[0],
            'names' => $fullname,
            'names2' => ' ',
            'token' => 'lsdkjnzfFDK435JKJf',
            'additionally' => '{"land":{"name":"land","value":"' . $lead->land . '"},"mergelead":{"name":"mergelead","value":"' . $lead->mergelead . '"},"inn":{"name":"ИНН","value":"' . $_REQUEST['inn_res'] . '"}}',
            'lang' => 'ru',
            'company' => '',
            'phones' => '',
            'emails' => '',
            'comments' => '',
            'additionallys' => '{"a":1}',
            'currency_onlinePay' => 'RUB',
            'currency_invoicePay' => 'RUB',
            'lang_invoicePay' => 'RU',
            'lang_onlinePay' => 'RU',
          ];
          $postData = http_build_query($postData);
          if ($count > 1) {
            for ($i = 1; $i < $count; $i++) {
              $postData .= '&seats=' . $seat[0] . '&names=' . $lead->name . '&names2= ';
            }
          }
          $response = cURLsend('https://api.1001tickets.org/events/105', $postData);
          $config['user']['sendsuccess'] = "<script>$('.register-popup__caption-step').html(' ');$('.register-popup__tip').html('');</script><div class=\"event1001__final-free\"><h3>Спасибо! Билеты будут отправлены на вашу электронную почту.</h3><div style=\"margin-top: 15px;font-size: 20px;margin-left: auto;margin-right: auto;\">Чтобы валидировать билеты, поделитесь в соцсетях.</div><script type=\"text/javascript\">(function() {if (window.pluso)if (typeof window.pluso.start == \"function\") return;if (window.ifpluso==undefined) { window.ifpluso = 1;var d = document, s = d.createElement('script'), g = 'getElementsByTagName';s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true; s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js'; var h=d[g]('body')[0]; h.appendChild(s); }})();</script> <div class=\"pluso\" data-background=\"transparent\" data-options=\"big,square,line,horizontal,nocounter,theme=04\" data-services=\"vkontakte,facebook,twitter\" data-url=\"http://трансформация.рф/\" data-title=\"Друзья, иду на бесплатный форум #трансформация4 3 сентября, кто со мной?\" data-description=\"Друзья, иду на бесплатный форум #трансформация4 3 сентября, кто со мной?\" style=\"display: block; text-align: center; margin-top: 20px;\"></div></div>";

          $config['ignore']['send_to_user'] = false;

          $config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
          $config['mail']['smtp']['fromname'] = "Команда «Трансформации»";
          $config['mail']['smtp']['user']['subject'] = "Ваш доступ к трансляции форума «Трансформация 3»";
          $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
                    <tbody><tr>
                        <td align="center" valign="top" style="padding:0;margin:0;">
                            <table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
                                <tbody>
                                <tr>
                                    <td align="left" valign="top" style="margin:0;padding:0;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
                                            <tbody><tr>
                                                <td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции Большого московского предпринимательского форума «Трансформация 3».</font><br></span></td>
                                            </tr>
                                        </tbody></table>                                  
                                    </td>
                                </tr><tr>
                                    <td align="left" valign="top" style="margin:0;padding:0;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
                                            <tbody><tr>
                                                <td align="left" valign="top" class="lh-3" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.35;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;"><span style="font-weight: bold;">Время трансляции:</span><br>19-20 февраля, 10:00 – 19:00.</font><br></span></td>
                                            </tr>
                                        </tbody></table>                                  
                                    </td>
                                </tr>                               
                                <tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
                                    <td align="left" valign="top" style="margin:0;padding:0;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
                                            <tbody><tr>
                                                <td align="left" valign="top" class="lh-1" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><span style="font-weight: bold;">Главные темы форума:</span><br><ul><li>Экспорт: выход за рубеж</li><li>Стратегия и финансы</li><li>Маркетинг</li><li>Продажи</li><li>Упаковка бизнеса</li><li>Личная эффективность</li></ul><br>Подробная программа форума доступна по ссылке:<br></span></td>
                                            </tr>
                                        </tbody></table>                                  
                                    </td>
                                </tr><tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/programm.pdf" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПОСМОТРЕТЬ ПРОГРАММУ</a></td></tr></tbody></table></div></td></tr><tr>
                                    <td align="left" valign="top" style="margin:0;padding:0;">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
                                            <tbody><tr>
                                                <td align="left" valign="top" class="lh-1" style="padding: 10px 60px 30px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-weight: bold;"><font style="font-size: 16px;" size="16">Приятного просмотра!</font><br></span></td>
                                            </tr>
                                        </tbody></table>                                  
                                    </td>
                                </tr></tbody></table>
                                </td>
                                </tr>
                                </tbody></table>';
        } else {
          $config['user']['sendsuccess'] = '<div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, Вам не доступно указанное количество билетов.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
        }
      } else {
        $config['user']['sendsuccess'] = "<script>$('.register-popup__tip').html('');</script><h3>Спасибо! Ваша заявка отправлена.</h3>";
      }
    }


       /*     if (false) {

            } else {
             $config['ignore']['getresponse'] =  true;
             $config['newsletter']['getresponse']['account']  ='sbsedu';
             $config['newsletter']['getresponse']['campaign'] = 'transformation_no_inn';
             $config['user']['sendsuccess'] = "<script>var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=".$lead->name."&email=".$lead->email."&phone=".$lead->phone."'; form_2.attr('action', action_2);</script>";
            }*/

  }

  if (!isset($_REQUEST['INN']) && !isset($_REQUEST['tickets_count']) /*&& false*/ ) {
    $config['ignore']['bitrix24'] = true;
    $config['user']['sendsuccess'] = "<script>var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide(); $('[name=\"INN\"]').prop('disabled', false).focus();/*$('[name=\"INN\"]').val('770077');*/  var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2);$('div.register-popup__step_2').show();/*form_2.submit();*/</script>";
    if ($_REQUEST['version'] == 'rudanov') {
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('771177'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
    }
    if ($_REQUEST['version'] != 'shamil') {
      if (cURLsend("https://1001tickets.org/api/getInfo.php", ["category" => $category, "phone" => $lead->phone, 'transform' => '1']) == 0) {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('772277'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      } else {
        $config['user']['sendsuccess'] = '
        <div class="form-group">
          <b style="font-size: 20px; color: #000">Извините, данный телефон уже использовался при регистрации на форум.</b>
        </div>';
      }
    }
    if ($_REQUEST['version'] == 'uds') {
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7777788888'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
    }
  }

  if ($lead->form != 'register-popup') {
    if (true) {
      $back = '$(document).on(\'click\', \'#backBtn\', function(e) {$.fancybox.open(\'#register-popup\');});';
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2);</script>";
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide(); $('[name=\"INN\"]').prop('disabled', false).focus();/*$('[name=\"INN\"]').val('770077');*/ var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); /*form_2.submit()*/;$('div.register-popup__step_2').show();</script>";
      if ($_REQUEST['version'] == 'shamil') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2);</script>";
      }
      if ($_REQUEST['version'] == 'rudanov') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('771177'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }
      if ($_REQUEST['version'] != 'shamil') {
        if (cURLsend("https://1001tickets.org/api/getInfo.php", ["category" => $category, "phone" => $lead->phone, 'transform' => '1']) == 0) {
          $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('772277'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
        } else {
          $config['user']['sendsuccess'] = '
          <div class="form-group">
            <b style="font-size: 20px; color: #000">Извините, данный телефон уже использовался при регистрации на форум.</b>
          </div>';
        }
      }
      if ($_REQUEST['version'] == 'uds') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7777788888'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'pintosevich') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('732818807815'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'kusakin') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('504602959726'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'arbpro') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7842387175'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'mailru') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7743001840'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'kolmakov') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7838062897'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'mvideo') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7707602010'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'sberbank') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7707083893'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'ivi') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7723624187'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'okko') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7814665871'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($_REQUEST['version'] == 'skyeng') {
        $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('7718125023'); var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_v4&dater=19 – 20 февраля&partner=&version=&graccount=sbsedu&grcampaign=transformation_2&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();</script>";
      }

      if ($lead->land == 'transformation_v4' && $lead->form == 'contest') {
        $config['ignore']['send_to_user'] = false;
        $config['user']['sendsuccess'] = '
					<div class="send-success"><h3>Спасибо!</h3>
					<h4>Ваша заявка отправлена</h4>
					<p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами</p>	
					<p><button class="reg-link" onclick="$.fancybox.close();">Ok</button></p>
					</div>';
      }
    } else {

    }
  }

    /*  sex, drugs, hard-code*/
  if ($lead->form == 'translation') {

    $TRANSLATION_LINK = 'https://www.youtube.com/embed/bH9Qico-HM4?rel=0';

    $config['user']['sendsuccess'] = "<script>turnPlayerOn();</script>";

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
    $config['mail']['smtp']['fromname'] = "Команда «Трансформации»";
    $config['mail']['smtp']['user']['subject'] = "Ваш доступ к трансляции форума «Трансформация 4»";

    $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
	<tbody><tr>
		<td align="center" valign="top" style="padding:0;margin:0;">

			<table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
				<tbody>
				<tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции Большого московского предпринимательского форума «Трансформация 4».</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr>                              
			<tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">
                              
					</td>
				</tr><tr>
					<td align="left" valign="top" style="margin:0;padding:0;">

						<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
							<tbody><tr>
								<td align="left" valign="top" class="lh-1" style="padding: 10px 60px 30px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-weight: bold;"><font style="font-size: 16px;" size="16">Приятного просмотра!</font><br></span></td>
							</tr>
						</tbody></table>                                  
					</td>
				</tr></tbody></table>
		</td>
	</tr>
</tbody></table>';

  }
  if ($lead->form == 'subscription') {
    $config['user']['sendsuccess'] = 'Спасибо!
				<script>
				$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email=' . $_REQUEST['email'] . '&price=' . $_REQUEST['price'] . '&name=' . $_REQUEST['name'] . '&message=&land=' . $lead->land . '&form=' . $lead->form . '&mergelead=' . $_REQUEST['mergelead'] . '&product_count=1", {type:"iframe"})
					$.fancybox.update();
				</script>';
  }
  if ($lead->form == 'synergybase') {
    $config['user']['sendsuccess'] = "<script>goToSynBase();</script>";
  }


}

if ($lead->land == 'transformation_astana') {
  $config['ignore']['getresponse'] = true;
  $config['ignore']['send_to_user'] = false;
  if (isset($_REQUEST['INN'])) {
    $innR = preg_replace('~\D+~', '', $_REQUEST['INN']);
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, "https://syn.su/transformationastana.php");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, [
      'method' => 'checkInn',
      'inn' => $innR
    ]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    $json = json_decode($response);
    if ($json->error == null) {
      if ($json->response != 'no') {
        $inn = $json->response->inn;
        //$use = 5 - $json->response->use;
        $use = 1;
        if (true) {
          if ($use <= 0) {
            $config['ignore']['bitrix24'] = false;
            $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, данный БИН или ИНН уже использовался при регистрации на форум.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
          } else {
            $lead->innCode = preg_replace('~\D+~', '', $_REQUEST['INN']);
            switch ($use) {
              case 1:
                $topText = 'Вам доступен 1 бесплатный билет';
                break;
              case 2:
                $topText = 'Вам доступно 2 бесплатных билета';
                break;
              case 3:
                $topText = 'Вам доступно 3 бесплатных билета';
                break;
              case 4:
                $topText = 'Вам доступно 4 бесплатных билета';
                break;
              case 5:
                $topText = 'Вам доступно 5 бесплатных билетов';
                break;
            }


            $config['user']['sendsuccess'] = "<script>form_3 = $('form.register-popup__form-2'); form_3.submit();</script><input type='hidden' name='land' value='transformation_astana'><script>$('.register-popup__caption-step').html('Шаг 3 из 4');$('.register-popup__tip').html('{$topText}');</script>Укажите, сколько билетов вам требуется<div class=\"form-group\"><input class=\"form-control\" type=\"number\" name=\"tickets_count\" min=\"1\" value=\"1\" max=\"{$use}\" placeholder=\"Количество билетов\"></div><div class=\"form-group\"><input type=\"hidden\" name=\"inn_res\" value=\"{$lead->innCode}\"><input type=\"hidden\" name=\"name\" value=\"{$lead->name}\"><input type=\"hidden\" name=\"use\" value=\"{$use}\"><input type=\"hidden\" name=\"email\" value=\"{$lead->email}\"><input type=\"hidden\" name=\"phone\" value=\"{$lead->phone}\"><input type=\"hidden\" name=\"mergelead\" value=\"{$lead->mergelead}\"><div class=\"row\"><div class=\"col-sm-6\"></div><div class=\"col-sm-6\"><button class=\"form__button button button_gradient\" id='btnnexttwo' type=\"submit\"><span>Далее</span> <span class=\"button__arrow\">&#x27F6;</span></button></div></div></div>";
          } // else if $use <= 0
        } else {

          $config['user']['sendsuccess'] = "
                  <script>
                  $('#status-popup__content').html('<h3>Спасибо!</h3><h4>Ваша заявка отправлена</h4><p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами и&nbsp;расскажем все подробности об&nbsp;участии в&nbsp;бизнес-форуме &laquo;Трансформация&raquo;.</p>');
                  //$.fancybox.close();
                  $.fancybox.open( {href: '#status-popup', padding: 0} );
                  </script>";

        }

      } else {
        $config['ignore']['bitrix24'] = false;
        $config['user']['sendsuccess'] = '
                <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>
                      Введен некорректный БИН или ИНН. Пожалуйста, введите корректный номер.';

        if (isset($json->responseCode) && $json->responseCode == 200501) {
          $config['ignore']['bitrix24'] = false;
          $config['user']['sendsuccess'] = '
                      <div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">ИП или ООО с таким БИН или ИНН не зарегистрирован в Нур-Султане.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
        } else {
          $config['ignore']['bitrix24'] = false;
          $config['user']['sendsuccess'] = '
                      <div class="form-group">
                          <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                          <b style="font-size: 20px; color: #be1317">Введен некорректный БИН или ИНН. Пожалуйста, введите корректный номер.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
        }

      }
    } else {
      $config['ignore']['bitrix24'] = false;
    }
  } else {
    $config['ignore']['bitrix24'] = true;

    if (isset($_REQUEST['name']) && isset($_REQUEST['email']) && $_REQUEST['name'] != '' && $_REQUEST['email'] != '' && isset($_REQUEST['tickets_count'])) {

      $count = $_REQUEST['tickets_count'];
      if (true) {
        if ($_REQUEST['tickets_count'] > 5) {
          die('<div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, Вам не доступно указанное количество билетов.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>');
        }

        $fullname = $lead->name;

        $postData = [
          'method' => 'createOrder',
          'name' => $fullname,
          'phone' => $lead->phone,
          'email' => $lead->email,
          'promocode' => '',
          'payment_type' => 'online',
          'comment' => '',
          'seats' => '616610',
          'names' => $fullname,
          'names2' => ' ',
          'token' => 'lsdkjnzfFDK435JKJf',
          'additionally' => '{"land":{"name":"land","value":"' . $lead->land . '"},"mergelead":{"name":"mergelead","value":"' . $lead->mergelead . '"},"inn":{"name":"INN","value":"' . $_REQUEST['inn_res'] . '"}}',
          'lang' => 'ru',
          'company' => '',
          'phones' => '',
          'emails' => '',
          'comments' => '',
          'additionallys' => '{"a":1}',
          'currency_onlinePay' => 'RUB',
          'currency_invoicePay' => 'RUB',
          'lang_invoicePay' => 'RU',
          'lang_onlinePay' => 'RU',
        ];
        $postData = http_build_query($postData);
        if ($count > 1) {
          for ($i = 1; $i < $count; $i++) {
            $postData .= '&seats=616610' . '&names=' . $lead->name . '&names2= ';
          }
        }
        $response = cURLsend('https://api.1001tickets.org/events/86', $postData);
        $config['user']['sendsuccess'] = "<script>$('.register-popup__caption-step').html('Шаг 4 из 4');$('.register-popup__tip').html('');</script><div class=\"event1001__final-free\"><h3>Спасибо! Билеты будут отправлены на вашу электронную почту.</h3><div style=\"margin-top: 15px;font-size: 20px;margin-left: auto;margin-right: auto;\">Чтобы валидировать билеты, поделитесь в соцсетях.</div><script type=\"text/javascript\">(function() {if (window.pluso)if (typeof window.pluso.start == \"function\") return;if (window.ifpluso==undefined) { window.ifpluso = 1;var d = document, s = d.createElement('script'), g = 'getElementsByTagName';s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true; s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js'; var h=d[g]('body')[0]; h.appendChild(s); }})();</script> <div class=\"pluso\" data-background=\"transparent\" data-options=\"big,square,line,horizontal,nocounter,theme=04\" data-services=\"vkontakte,facebook,twitter\" data-url=\"https://astanaforum.info/\" data-title=\"Бизнес-форум ASTANA BASTAU. Друзья, я иду на бесплатный форум #территориябизнесаНур-Султан, кто со мной?\" data-description=\"Бизнес-форум ASTANA BASTAU. Друзья, я иду на бесплатный форум #территориябизнесаНур-Султан, кто со мной?\" style=\"display: block; text-align: center; margin-top: 20px;\"></div></div>";

      } else {
        $config['user']['sendsuccess'] = '<div class="form-group">
                        <input class="form-control form-control-lg" type="text" name="INN" placeholder="БИН или ИНН" required="" aria-required="true">
                        <b style="font-size: 20px; color: #be1317">Извините, Вам не доступно указанное количество билетов.</b>
                      </div><button class="btn btn-danger btn-lg btn_register-popup" type="submit">Отправить</button>';
      }
    } else {
      $config['user']['sendsuccess'] = "<script>$('.register-popup__tip').html('');</script><h3>Спасибо! Ваша заявка отправлена.</h3>";
    }
  }

  if (!isset($_REQUEST['INN']) && !isset($_REQUEST['tickets_count']) /*&& false*/ ) {
    $config['ignore']['bitrix24'] = true;
    $config['user']['sendsuccess'] = "<script>var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('770077');  var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_astana&dater=22-23 СЕНТЯБРЯ 2018&partner=&version=&graccount=synergy&grcampaign=e_mail_chain_kz_astanabastau&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2);$('div.register-popup__step_2').show();form_2.submit();</script>";
  }

  if ($lead->form != 'register-popup') {
    if (true) {
      $back = '$(document).on(\'click\', \'#backBtn\', function(e) {$.fancybox.open(\'#register-popup\');});';
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide();$('div.register-popup__step_2').show(); $('[name=\"INN\"]').prop('disabled', false).focus();var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_astana&dater=22-23 СЕНТЯБРЯ 2018&partner=&version=&graccount=synergy&grcampaign=e_mail_chain_kz_astanabastau&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2);</script>";
      $config['user']['sendsuccess'] = "<div class=\"form__items\"><div class=\"form__item\"><button type=\"button\" class=\"form__button button button_gradient fancybox\" id=\"backBtn\" data-fancybox-options=\"{wrapCSS: 'fancybox-theme-dark'}\">Вернуться назад</button></div></div><script>" . $back . " $.fancybox.open(\"#register-popup\");var form_2 = $('form.register-popup__form-2'); $('div.register-popup__step_1').hide(); $('[name=\"INN\"]').prop('disabled', false).focus();$('[name=\"INN\"]').val('770077');var action_2 = form_2.attr('action') + '&' + 'r=land/index&unit=sbs&type=sm&land=transformation_astana&dater=22-23 СЕНТЯБРЯ 2018&partner=&version=&graccount=synergy&grcampaign=e_mail_chain_kz_astanabastau&form=register-popup&name=" . $lead->name . "&email=" . $lead->email . "&phone=" . $lead->phone . "&mergelead=" . $lead->mergelead . "'; form_2.attr('action', action_2); form_2.submit();$('div.register-popup__step_2').show();</script>";

      if ($lead->land == 'transformation_astana' && $lead->form == 'contest') {
        $config['ignore']['send_to_user'] = false;
        $config['user']['sendsuccess'] = '
          <div class="send-success"><h3>Спасибо!</h3>
          <h4>Ваша заявка отправлена</h4>
          <p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами</p> 
          <p><button class="reg-link" onclick="$.fancybox.close();">Ok</button></p>
          </div>';
      }
    } else {

    }
  }

    /*  sex, drugs, hard-code*/
  if ($lead->form == 'translation') {

    $TRANSLATION_LINK = 'https://www.youtube.com/embed/wLmNW2xEB-E?rel=0';

    $config['user']['sendsuccess'] = "<script>turnPlayerOn();</script>";

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['from'] = "notice@sbs.edu.ru";
    $config['mail']['smtp']['fromname'] = "Команда «Трансформации»";
    $config['mail']['smtp']['user']['subject'] = "Ваш доступ к трансляции форума «Трансформация 3»";

    $config['mail']['smtp']['user']['message'] = '<table width="100%" cellpadding="0" cellspacing="0" border="0" data-mobile="true" dir="ltr" align="center" data-width="600" style="background-color: rgb(237, 237, 237);">
  <tbody><tr>
    <td align="center" valign="top" style="padding:0;margin:0;">

      <table align="center" bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" width="600" class="wrapper" style="width: 600px;">
        <tbody>
        <tr>
          <td align="left" valign="top" style="margin:0;padding:0;">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
              <tbody><tr>
                <td align="left" valign="top" class="lh-4" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.45;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;">Вы успешно зарегистрировались на бесплатный просмотр трансляции Большого московского предпринимательского форума «Трансформация 3».</font><br></span></td>
              </tr>
            </tbody></table>                                  
          </td>
        </tr><tr>
          <td align="left" valign="top" style="margin:0;padding:0;">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
              <tbody><tr>
                <td align="left" valign="top" class="lh-3" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.35;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><font style="font-size: 16px;"><span style="font-weight: bold;">Время трансляции:</span><br>29-30 мая, 10:00 – 19:00.</font><br></span></td>
              </tr>
            </tbody></table>                                  
          </td>
        </tr>                               
      <tr><td align="center" valign="top" style="padding: 30px 0px;"><div data-box="button" style="width: 100%; margin-top: 0px; margin-bottom: 0px; text-align: center;"><table border="0" cellpadding="0" cellspacing="0" align="center" data-editable="button" style="margin: 0px auto;"><tbody><tr><td valign="top" align="center" class="tdBlock" style="display: inline-block; padding: 13px 25px; margin: 0px; background-color: rgb(255, 0, 0); border-radius: 0px;"><a href="http://xn--80aayoegldhg0a2a2j.xn--p1ai/?token=2d3bb47f9495e9cbd987f4c213f163e6" style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; color: rgb(255, 255, 255); font-size: 15px; text-decoration: none; font-weight: bold;" target="_blank">ПЕРЕЙТИ К ПРОСМОТРУ</a></td></tr></tbody></table></div></td></tr><tr>
          <td align="left" valign="top" style="margin:0;padding:0;">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
              <tbody><tr>
                <td align="left" valign="top" class="lh-1" style="padding: 10px 60px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38);"><span style="font-weight: bold;">Главные темы форума:</span><br><ul><li>Цифровая экономика</li><li>Трафик и упаковка</li><li>Продажи</li><li>Автоматизация</li></ul></span></td>
              </tr>
            </tbody></table>                                  
          </td>
        </tr><tr>
          <td align="left" valign="top" style="margin:0;padding:0;">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" data-editable="text" class="text-block">
              <tbody><tr>
                <td align="left" valign="top" class="lh-1" style="padding: 10px 60px 30px; margin: 0px; font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-size: 16px; line-height: 1.15;"><span style="font-family: Arial, Helvetica, sans-serif; color: rgb(38, 38, 38); font-weight: bold;"><font style="font-size: 16px;" size="16">Приятного просмотра!</font><br></span></td>
              </tr>
            </tbody></table>                                  
          </td>
        </tr></tbody></table>
    </td>
  </tr>
</tbody></table>';

  }
  if ($lead->form == 'subscription') {
    $config['user']['sendsuccess'] = 'Спасибо!
        <script>
        $.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email=' . $_REQUEST['email'] . '&price=' . $_REQUEST['price'] . '&name=' . $_REQUEST['name'] . '&message=&land=' . $lead->land . '&form=' . $lead->form . '&mergelead=' . $_REQUEST['mergelead'] . '&product_count=1", {type:"iframe"})
          $.fancybox.update();
        </script>';
  }
  if ($lead->form == 'synergybase') {
    $config['user']['sendsuccess'] = "<script>goToSynBase();</script>";
  }


}

if ($lead->land == 'piz-sm-v4') {
  
  $config['ignore']['getresponse'] = false;
  $config['ignore']['send_to_user'] = false;

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
    'listId' => 125
  ]);
  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  $responseEs = curl_exec($curl);
  curl_close($curl);


  $curl = curl_init("https://api5.esv2.com/v2/Api/SystemTransactionals/1315");
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

  $categoryName = trim($_REQUEST['product_id']);

  switch ($categoryName) {
      case "price-1":
          $category = 518;
          break;
      case "price-2":
          $category = 519;
          break;
      case "price-3":
          $category = 520;
          break;
      case "price-4":
          $category = 598;
          break;
  }
  $ticketsCount = isset($_REQUEST['tickets_count']) && $_REQUEST['tickets_count'] > 0 ? $_REQUEST['tickets_count'] * 1 : 1;
  $priceVariant = isset($_REQUEST['price_variant']) && $_REQUEST['price_variant'] > 0 ? $_REQUEST['price_variant'] * 1 : null;
  $promocode = isset($_REQUEST['promocode']) ? $_REQUEST['promocode'] : '';

  $comment = 'рандомный билет с ленда';

  $seatsRand = getSeatsRandomAll($ticketsCount, $category);
  $lang = 'ru';

  $lead->productId = $product_id;

  if ($promocode == '') {
    $promocode = 'ONLINEOP5';
  }

  $postData = [
    'method' => 'createOrder',
    'name' => $lead->name,
    'phone' => $lead->phone,
    'email' => $lead->email,
    'promocode' => $promocode,
    'payment_type' => 'online',
    'comment' => $comment,
    'price_variant' => $priceVariant,
    'seats' => $seatsRand[0],
    'names' => $lead->name,
    'names2' => ' ',
    'token' => 'lsdkjnzfFDK435JKJf',
    'additionally' => getAdditionally($lead),
    'lang' => $lang,
    'currency_onlinePay' => 'KZT'
  ];

  $postData = http_build_query($postData);

  if ($ticketsCount > 1) {
    for ($i = 1; $i < count($seatsRand); $i++) {
      $postData .= '&seats=' . $seatsRand[$i] . '&names=' . $lead->name . '&names2= ';
    }
  }

  $responseApi = cURLsend('https://api.1001tickets.org/events/99', $postData);
  $responseApi_arr = json_decode($responseApi);

  if (isset($responseApi_arr->response->link) && $responseApi_arr->response->link != '') {

    $sendsuccess_paycard = '
      <div class="font-size-24 font-bold uppercase color-blue">Оплата: ' . $categoryName . ' (' . $ticketsCount . ')</div>
      <iframe class="payment-frame" style="height: 600px;" src="' . $responseApi_arr->response->link . '" ></iframe>
    ';

  }
    
  $default_sendsuccess = "
  <div class='send-success'>
    <h3>Спасибо!</h3>
  <p>Ваша заявка отправлена. <br>
  В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами и&nbsp;расскажет, как приобрести билеты.</p>
  </div>
  ";

  $config['user']['sendsuccess'] = "<script>$('.buy-ticket-left').addClass('hidden');</script>" . $sendsuccess_paycard;

  $config['user']['sendsuccess'] .= '<script>$.fancybox.update()</script>'.$default_sendsuccess;

}

if ($lead->land == 'transformation_v6') {
  $config['ignore']['send_to_user'] = false;
  $config['user']['sendsuccess'] = '
  <div class="send-success">
    <h3>Спасибо!</h3>
    <h4>Ваша заявка отправлена</h4>
    <p>В&nbsp;ближайшее время мы свяжемся с&nbsp;Вами</p>	
    </div>
    ';
}


function getAdditionally($lead)
{
  $additionally = array();
  foreach ($lead as $k => $v) {
    $additionally[$k] = ['name' => $k, 'value' => $v];
  }
  return json_encode($additionally);
}

function getSeatsRandom($tickets_count, $category, $sector = false, $event)
{
  $params = [
    'tickets_count' => $tickets_count,
    'event' => $event,
    'category' => $category
  ];
  if ($sector) {
    $params = [
      'tickets_count' => $tickets_count,
      'event' => $event,
      'category' => $category,
      'sector' => $sector
    ];
  }
  $seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandomTransform.php', $params), true)['seats'];
  return $seats;
}


function getSeatsRandomAll($tickets_count, $category)
{

  $params = array(
    'tickets_count' => $tickets_count,
    'category' => $category,
    'event' => '99'
  );

  $seats = json_decode(cURLsend('https://payment.1001tickets.org/payform/1001min/getSeatsRandom.php', $params), true)['seats'];

  return $seats;

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

function cURLsend($url, $postData)
{
  $curl = curl_init($url);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  if ($postData != false) {
    curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
  }
  $response = curl_exec($curl);
  curl_close($curl);
  return $response;
}