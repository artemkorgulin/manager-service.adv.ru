<?php

if(($_REQUEST['partner'] == 'drb') || ($_REQUEST['partner'] == 'chelyabinsk') || ($_REQUEST['partner'] == 'novosibirskbo') || ($_REQUEST['partner'] == 'ekb') || ($_REQUEST['partner'] == 'krasnoyarsk') || ($_REQUEST['partner'] == 'spb')) {

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
<a href="http://synergyregions.ru" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/assets/templates/regions/img/new_logo.png" alt="" width="176" height="30"></a>
</div>
<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
<h3>Ваша регистрация на событие:<br> Тони Роббинс впервые в России</h3>
<h3>Здравствуйте, {$lead->name}.</h3>

<p>Вы зарегистрировались на первое в России выступление Тони Роббинса, которое состоится 1 сентября в СК Олимпийский.</p>
<p>Следите за нашими письмами, мы будем сообщать вам обо всех деталях события.</p>

<hr style="color: #E5E5E5;">
<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru">Школы Бизнеса «Синергия»</a></i></p>
<p style="color:#505050;">{$partner_phone}</p>
</div>
<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2018. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;

} else {

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
<a href="http://sbs.edu.ru?utm_source=tranzmail-wb" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_sbs.png" alt="" width="322" height="37"></a>
</div>
<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
<h3>Ваша регистрация на событие:<br> Тони Роббинс впервые в России</h3>
<h3>Здравствуйте, {$lead->name}.</h3>

<p>Вы зарегистрировались на первое в России выступление Тони Роббинса, которое состоится 1 сентября в СК Олимпийский.
Если вы еще не приобрели билеты на мероприятие, перейдите по <a href="http://tonyrobbinsmoscow.ru/" target="_blank">ссылке</a></p>
<p>Следите за нашими письмами, мы будем сообщать вам обо всех деталях события.</p>

<hr style="color: #E5E5E5;">
<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-wb">Школы Бизнеса «Синергия»</a></i></p>
<p style="color:#505050;">{$partner_phone}</p>
</div>
<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2018. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;

}

if( $lead->form == 'contest' || $lead->form == 'popup-contest') {
    $contest_link = isset($_REQUEST['contest_link']) ? $_REQUEST['contest_link'] : 'https://vk.com/feed?w=wall-9941011_8703';

    $str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
<a href="http://synergyregions.ru" title="Перейти на сайт школы бизнеса"><img src="http://synergyregions.ru/assets/templates/regions/img/new_logo.png" alt="" width="176" height="30"></a>
</div>
<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
<p>Добрый день!</p>
<p>Регистрация на конкурс прошла успешно.</p>
<br>
<p>Не забудьте правила конкурса:</p>
<ol>
<li><strong>Сделать репост <a href="{$_REQUEST['contest_link']}">записи ВКонтакте</a></strong></li>
<li><strong>Победителя определят генератором случайных чисел {$_REQUEST['contest_results_text']} в группе <a href="https://vk.com/synergydigital?utm_source=maillist&utm_medium=Email&utm_content=es&utm_campaign=trans_konkurs">Synergy Digital</a> ВКонтакте.</strong></li>
</ol>

<hr style="color: #E5E5E5;">
<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://synergyregions.ru">Школы Бизнеса «Синергия»</a></i></p>
<p style="color:#505050;">{$partner_phone}</p>
</div>
<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2018. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;

}

if( $lead->form == 'solodar' ) {

$str = <<<EOD
<p>Легендарный Тони Роббинс - коуч президентов, мировых знаменитостей и олимпийских чемпионов едет к вам! Впервые он проведет семинар для жителей России и поделится секретами вдохновляющей жизни и головокружительного успеха с вами!
</p>
<p>Тони привезёт совершенно новую программу. Её нет и не будет нигде в свободном доступе. А по степени практической ценности и полезности контента это будет 100% эксклюзив.</p>
<p>Вам осталось сделать только 1 шаг - приобрести билет и 1 сентября оказаться вместе с нами в СК «Олимпийский». <strong>Вы идете на семинар в команде Марии Солодар. На билеты для вашей команды предоставляется специальная скидка 30%!</strong></p>
<h3 style="color:red;text-align: center;"><strong>ВАЖНО:</strong></h3>
<p style="color:red;text-align: center;"><strong>Спец.цена действует только 24 часа!</strong></p>
<p>Скорее переходите на <a href="http://synergyforum.ru/" target="_blank">synergyforum.ru</a> и при покупке билета укажите промокод <strong>SOLODAR</strong>.</p>
<p>Долгожданный день семинара приближается стремительно. Пора наконец ощутить подлинную любовь и страсть к жизни! Сверните горы, расправьте широкие крылья и дотянитесь до самых высоких звезд! Это будет день, который вы никогда не забудете!</p>
<p>Поспешите занять место на этом невероятном событии, пока вас не опередил кто-нибудь другой!</p>
<p style="text-align: center;"><strong>Действуйте прямо сейчас!</strong><br>
<span style="background: red;"><strong>ПОЛУЧИТЬ БИЛЕТ НА ТОНИ<br> СО СКИДКОЙ 30%!</strong></span></p>
<p>С уважением,<br>
команда Школы Бизнеса «Синергия».</p>
EOD;

}



return $str;