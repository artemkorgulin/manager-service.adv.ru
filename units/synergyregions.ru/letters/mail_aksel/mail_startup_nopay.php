<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}!</h3>
         <p>Поздравляем! Вы успешно зарегистрировались для участия в новой программе Школы Бизнеса «Синергия» {$_REQUEST['program']}.</p>
         <p><b>Обучение начнется {$_REQUEST['date']}.</b> Перед первой встречей мы пришлем вам Flip-lesson — небольшое задание, которое надо будет выполнить для быстрого погружения в тему первого модуля. </p>

         <p>После проведения платежа мы вышлем подтверждение и включим вас в список участников. </p>
         <p><b>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</b></p>
         <hr style="color: #E5E5E5;">
         <p style="color:#505050;">До встречи!<br>Школа бизнеса «Синергия», <br> <a href="http://www.sbs.edu.ru ">www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
   </div>
</div>
EOD;
return $str;