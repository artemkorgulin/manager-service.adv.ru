<?php

if($_REQUEST['form'] == 'partner'){
   $config['user']['sendsuccess'] = "
   	<div class='send-success'>
   		<h3>Заявка успешно отправлена!</h3>
   		<p>Проверьте вашу почту, куда мы отправили письмо-подтверждение.
   	</div>";

   $msg = '';

} else {
   $config['user']['sendsuccess'] = "
      <div class='send-success'>
         <h3>Заявка успешно отправлена!</h3>
         <p>{$lead->name}, вы успешно зарегистрировались на крупнейшую бизнес-регату «Синергия»! Проверьте вашу почту, куда мы отправили письмо-подтверждение.
      </div>";

   $msg = '<p>Поздравляем! Вы успешно зарегистрировались на крупнейшую бизнес-регату «Синергия»</p>';
}


$config['ignore']['send_to_user']   = true;
$config['mail']['smtp']['user']['subject'] = "Успешная регистрация на крупнейшую бизнес-регату «Синергия»";
$config['mail']['smtp']['user']['message'] = "<div style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;'>
   <div style='margin: 0 auto; width: 560px; padding: 10px 20px;'>
      <a href='http://sbs.edu.ru?utm_source=' title='Перейти на сайт школы бизнеса'><img src='http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png' alt=' width='174' height='54'></a>
   </div>
   <div style='margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;'>
         <h3>Здравствуйте, {$lead->name}!</h3>
         {$msg}


         <p><b>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</b></p>
         <hr style='color: #E5E5E5;'>
         <p style='color:#505050;'>До встречи!<br>Школа бизнеса «Синергия», <br> <a href='http://www.sbs.edu.ru '>www.sbs.edu.ru</a><br>8 800 707 41 77 </p>
   </div>

</div>";