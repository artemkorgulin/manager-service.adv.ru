<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://lingva.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт языкового центра"><img src="http://lingva.edu.ru/lp/taraskina/wb-v1/img/logo.png" alt="" width="337" height="41"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}!</h3>
         <p>Вы зарегистрировались на вебинар <b>«{$lead->program}»</b>, который ведет эксперт <b>{$lead->speaker}</b>.</p>
         <p>Вебинар состоится <b>{$lead->dater}</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
         <p style="margin:40px 0; text-align: center;"><a href="{$link}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>
         <hr style="color: #E5E5E5;">
         <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://lingva.edu.ru?utm_source=tranzmail-wb">университета «СИНЕРГИЯ»</a></i></p>
   </div>
   <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015.  Университет «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Ленинградский проспект, дом 80 копрус Г..<br>Тел. 8 (800) 100-00-11</div>
</div>
EOD;
return $str;