<?php
###########################
##### Подписные ленды #####
###########################
// Конфигуратор GetResponse
$config['ignore']['getresponse'] = (isset($lead->area) ? false : true);
$config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'sbsedu');
$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'total_subscription');


if ($lead->land == 'sertificat3000' || $lead->land == 'sertificat5000') {
    if ($lead->land == 'sertificat3000') {
        $cost = '3 000';
    } else if ($lead->land == 'sertificat5000') {
        $cost = '5 000';
    }

    // Конфигуратор UserMail
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = $cost;
    $config['mail']['smtp']['user']['message'] = "
      <p>Поздравляем,</p>
      <p>Вы подписались на&nbsp;информационную рассылку Школы Бизнеса &laquo;Синергия&raquo;. Теперь вы можете использовать " . $cost . "&nbsp;рублей в&nbsp;счет оплаты любого продукта Школы Бизнеса.</p>
    ";
}

if ($lead->land == 'sbs-intensive') {
    // Конфигуратор UserMail
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо за регистрацию!</h3>
        <p>Первый урок курса придет вам на почту <b>{$lead->email}</b> в течение пары минут. Если не найдете письмо во Входящих, проверьте папку спам, иногда письма попадают туда. Если у вас остались вопосы, пишите нам info@sbs.edu.ru или звоните: +7 (495) 787-87-67</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
} elseif ($lead->land == 'syn_lp_online_fasion') {
    // Конфигуратор UserMail
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Спасибо за регистрацию!</h3>
        <p>Наш менеджер свяжется с вами в течении нескольких минут.</p>
    </div>";
} else {
    // Конфигуратор UserMail
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Пожалуйста, подтвердите ваш адрес электронной почты.</h3>
        <p>Письмо подтверждения мы отправили на вашу почту <b>{$lead->email}</b>.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    </div>";
}

// Не отправлять в Битрикс24 если содержит только мыло
// Закомменчено по заявке №101710
//$config['ignore']['bitrix24'] = (!empty($lead->phone)  ? true : false);

	// по заявке 125344 перенесено из unit synergy сюда
if ($_REQUEST['land'] == 'synergy-intensive' || $_REQUEST['land'] == 'synergy-intensive-email') {

    $config['ignore']['bitrix24'] = true;
    /* Конфигуратор GetResponse */
    $config['ignore']['getresponse'] = true;
    $config['newsletter']['getresponse']['account'] = (!empty($lead->graccount) ? $lead->graccount : 'synergy');
    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_sub');

  /* Конфигуратор UserMail */
    $config['user']['sendsuccess'] = "
  <div class='send-success'>
          <h3>Подписка успешно оформлена!</h3>
          <p>На ваш почтовый ящик <b>{$lead->email}</b> отправлена ссылка для подтверждения доступа к Базе знаний.</p>

  </div>";


} else if ($lead->graccount == 'synergy' && $lead->grcampaign == 'e_mail_chain_7days') {

    $config['ignore']['bitrix24'] = false;

}

if ($lead->land == 'sbs-intensive') {
    $config['ignore']['getresponse'] = true;
}

$config['user']['sendsuccess'] .= $redirect; 