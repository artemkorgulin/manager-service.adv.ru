﻿<?php
if($lead->program=="Что продавать"){
	$link='https://livestream.com/accounts/7155227/events/5695039/';
   $leaddater = '14 июля в 20:00!';
   $leadprogram =  'Что продавать? Как продавать? Кому продавать? ';
}else{
   $leaddater = $lead->dater;
   $leadprogram = $lead->program;
}




$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v2.png" alt="" width="174" height="54"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
         <h3>Здравствуйте, {$lead->name}.</h3>
         <p>Вы зарегистрировались на вебинар <b>«{$leadprogram}»</b>, который ведет эксперт <b>{$lead->speaker}</b>.</p>
         <p>Вебинар состоится <b>{$leaddater}</b>. Мы рекомендуем подключаться к трансляции за 10-15 минут до начала.</p>
         <p><a href="http://sbs.edu.ru/lp/ovchinnikov/wb-v1/img/downloads/demo.pdf">Скачать демо-версию книги &laquo;Манифест правильного чиновника. Как заставить госпредприятие приносить прибыль городу&raquo;</a></p>
         <p style="margin:40px 0; text-align: center;"><a href="{$link}" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Смотреть вебинар »</a></p>
         <hr style="color: #E5E5E5;">
         <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
   </div>
   <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>

</div>
EOD;
return $str;