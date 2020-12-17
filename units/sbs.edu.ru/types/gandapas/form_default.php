<?php
 

$config['user']['sendsuccess'] = "
<div class='send-success'>
  <h3>Заявка успешно отправлена!</h3>
  <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
</div>";
 

/* Конфигуратор UserMail */
$config['ignore']['send_to_user'] = false;
// $config['mail']['smtp']['user']['subject'] = "Регистрация на программу «" . trim($lead->program) . "»";
// $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/xxx.php';




if ($lead->land == 'sbs_script') {
  $config['mail']['smtp']['user']['subject'] = "Гандапас";
  $config['ignore']['send_to_user'] = false;

  $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Заявка успешно отправлена!</h3>
      <p>В ближайшее время с вами свяжутся</p>
    </div>";

}