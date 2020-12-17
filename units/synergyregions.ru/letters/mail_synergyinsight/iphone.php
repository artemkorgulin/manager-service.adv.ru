<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
   <div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
      <a href="http://sbs.edu.ru?utm_source=tranzmail-mk" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sif.png" alt="" width="294" height="39"></a>
   </div>
   <div style="margin: 0 auto; width: 540px; padding:25px 30px 15px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
   <h3>Здравствуйте, {$lead->name}!</h3>

	<p>Вы интересовались мобильным приложением Synergy Friends. Это приложение станет новым инструментом нетворкинга для Для российского бизнес-сообщества. На данный момент приложение уже доступно на устройствах Android. Для IOS и других устройств работает web-версия приложения.</p>

	<p style="margin:40px 0; text-align: center;">
         <a href="http://sbs.edu.ru/synergy/skachat-prilozhenie-synergy-friends" style="border-radius:5px; font-size: 15px; color:#01B358; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #01B358; padding:10px 20px;" target="_blank">Скачать »</a>
         </p>

	<p><b>Подробнее о Форуме</b><br>
	Каждый из 16 спикеров Synergy Insight Forum даст самый яркий контент в своей теме и поделится инсайтами, которые еще не были опубликованы. Со всеми спикерами вы пообщаетесь лично — после Форума будет традиционная закрытая вечеринка в клубе Soho Rooms.
<br><br>
Держите телефон под рукой: мы позвоним, чтобы рассказать подробнее о Форуме, ответить на вопросы и забронировать для Вас лучшие места в зале.
	</p>

         <hr style="color: #E5E5E5;">
         <p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-mk">Школы Бизнеса «Синергия»</a></i></p>
   </div>
   <div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2016. Школа Бизнеса «Синергия», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;