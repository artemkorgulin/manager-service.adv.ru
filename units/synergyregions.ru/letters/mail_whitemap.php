<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://sbs.edu.ru?utm_source=whitemap" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}!</h3>
         <p>Вы зарегистрировались на онлайн-встречу с режиссером Александром Мельником, в рамках которой пройдет презентация нового кинопроекта «Белая карта».</p>
         <p>Встреча состоится. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
         <p style="margin:40px 0; text-align: center;"><a href="https://livestream.com/accounts/7155227/events/5755266/" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть онлайн-трансляцию</a></p>
         <hr style="color: #E5E5E5;">
         <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
   </div>
</div>
EOD;
return $str;