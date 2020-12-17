<?php

$leaddater = $lead->dater;
$leadprogram = $lead->program;
$link = $lead->link;

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}..</h3>
         <p>Вы зарегистрировались на вебинар <b>«{$leadprogram}»</b>, который ведет эксперт <b>{$lead->speaker}</b>.</p>
         <p>Вебинар состоится <b>{$leaddater}</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
         <p style="margin:40px 0; text-align: center;"><a href="{$link}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>
         <hr style="color: #E5E5E5;">
   </div>
</div>
EOD;
return $str;