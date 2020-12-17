<?php

if ($lead->version == 'versms') {
  $config['user']['sendsuccess'] = "
    <div class='landformbox__inner'>
      <form action='http://synergy.ru/lander/alm/lander.php?r=landphone_validate&type=egemetr' data-form='smsver' method='post' class='application'>
        
        <div class='form__form-group'>
          <label class='form__label'>
            <span class='form__label-text'>На ваш телефон отправлен код подтверждения</span>
            <input type='text' class='input GoodLocal' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' min='4' reqired autofocus />
            <input type='submit' value='Подтвердить' class='button button_color_blue'>
          </label>
        </div>
        <div class='form__form-group'>
          <label class='form__label'>
            <span class='msg_text'>Не пришел код в течение 2-ух минут?</span> 
            <input type='button' class='button button_color_blue' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landresendsms\");' value='Выслать еще раз'>
          </label>
        </div>
        
        <input type='hidden' name='type' value='proftest'>
        <input type='hidden' name='version' value='{$lead->version}'>
        <input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
        <input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />
        <input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />
        <input type=\"hidden\"  name=\"comments\" value=\"лид из смс-формы\">
      </form>
    </div>";
    
    
    // Верификация успешна
    $config['user']['sendsuccessvalidation'] = "
    <div class='send-success'>
    	<h3>Проверка пройдена!</h3>
    	<p>Доступ предоставлен.</p>
    	<script>$(function(){ localStorage.setItem('verification', 'success'); $('body').trigger('init-test'); });</script>
    </div>";
    
    // Верификация провалена
    $config['user']['sendfaildvalidation'] = "
    <div class='send-error'>
    	<h3>СМС код не корректный!</h3>
    	<p>Попробуйте <a href='#' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landphone_retry&type=proftest\"); return false;'>еще раз</a>.</p>
    
    </div>";
    
    // Неверный номер + смс сервис не доступен
    $config['user']['smscfail'] = "
    <div class='send-error' id='send-success'>
        <h3>Произошла ошибка!</h3>
        <p>Вы ввели неверный номер мобильного телефона <b>{$lead->phone}</b>, или служба отправки смс недоступна. Пожалуйста, попробуйте позже.</p>
    
    </div>";
} elseif ($lead->land == 'moi_online_dp') {
  $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <script>
      $(document).ready(function() {
        $.fancybox.close();
        $.fancybox.open({ src: '#thanks-popup', type: 'inline' });
      });
    </script>
  </div>";
} else {
  $config['user']['sendsuccess'] = "Спасибо! Ваша заявка отправлена.";
}





###############################
##### Сайт + по умолчанию #####
###############################

// Адрес и имя для отправки писем
$config['mail']['smtp']['from']		= "notice@moi.edu.ru";
$config['mail']['smtp']['fromname']	= "Московский Открытый Институт";