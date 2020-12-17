<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://arsenal-i.ru" title="Перейти на сайт программы Электробезопасность"><img src="http://arsenal-i.ru/img/mail-logo.png" alt=""></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}!</h3>
         <p>Спасибо за оставленную заявку. Мы свяжемся с Вами в течение 15 минут. Если у вас срочный вопрос позвоните прямо сейчас по номеру 8 (800) 200-58-68</p>
         <hr style="color: #E5E5E5;">
         <p style="color:#505050;">До встречи!<br>КОМАНДА ИНСТИТУТА АРСЕНАЛ, <br> <a href="http://arsenal-i.ru">arsenal-i.ru</a><br>8 (800) 200-58-68</p>
   </div>
   
</div>
EOD;
return $str;