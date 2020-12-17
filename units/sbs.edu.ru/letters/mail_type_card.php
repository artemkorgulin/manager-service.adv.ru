<?php
$card_type1 = $lead->form == 'gold' ? 'золотую' : 'серебряную';
$card_type2 = $lead->form == 'gold' ? 'золотой' : 'серебряной';
$card_time = $lead->form == 'gold' ? '1 год' : '6 месяцев';

$body = <<<EOD
<h3>Здравствуйте, {$lead->name}!</h3>
<p>Спасибо за заявку на {$card_type1} карту Школы Бизнеса «Синергия». Вы решили инвестировать в себя и в развитие бизнеса. В 2016 году вас ждет настоящий прорыв. Вот только малая часть программ, которые вы получаете единым пакетом:</p>
<ul>
	<li>Новый авторский курс Александра Фридмана «Короли и Капуста»</li>
	<li>Знаменитая технология Игоря Манна «Как стать №1»</li>
	<li>Полная интеллектуальная прокачка от Максима Поташева</li>
	<li>Уникальные онлайн-практикумы от ведущих мировых спикеров — Аллана Пиза, Брайана Трейси, Ицхака Адизеса, Джона Шоула и других;</li>
	<li>Пакет категории Business на Synergy Global Forum 21-22 ноября 2016;</li>
	<li>Пакет категории Business на Synergy Insight Forum 23-24 апреля 2016;</li>
	<li>Пакет категории Business на «Базовые стратегии 2017» в декабре 2016.</li>
</ul>
<p>Держите телефон под рукой: мы позвоним, чтобы подтвердить вашу заявку и обсудить возможности вашей {$card_type2} карты.</p>
EOD;

if ( $lead->land == 'gold-silver' ) {
$body = <<<EOD
<p>Спасибо, что оставили заявку на приобретение {$card_type2} карты Школы Бизнеса «Синергия»!</p>
<p>Это ваш входной билет на все наши курсы, программы, закрытые вебинары и форумы. Карта действует {$card_time} с момента покупки — начинайте формировать свою программу успеха уже сейчас.</p>
<p>Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут.</p>
<p>Мы используем сервис IntellectMoney.</p>
<p>Переходя по ссылке для онлайн-оплаты, вы подтверждаете свое согласие с <a href="http://sbs.edu.ru/oferta?utm_source=tranzmail-sm">публичной офертой</a>.</p>
<p style="margin:40px 0; text-align: center;"><a href="https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=454977&email={$lead->email}&LMI_PAYMENT_AMOUNT={$lead->cost}&LMI_PAYMENT_DESC={$_REQUEST['program']}&preference=bankCard" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Оплатить</a></p>
<p>После проведения платежа мы включим вас в список участников и вышлем подтверждение на ваш электронный адрес.</p>
<p>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия, подтвердить ваши регистрационные данные и ответить на все интересующие вас вопросы.</p>
EOD;
}

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://sbs.edu.ru?utm_source=tranzmail-sm" title="Перейти на сайт школы бизнеса"><img src="http://sbs.edu.ru/land/box/emails/mail_logo_shb_v3.png" alt="" width="140" height="37"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		{$body}
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;"><i>С уважением, команда <a style="color:#505050;" href="http://sbs.edu.ru?utm_source=tranzmail-sm">Школы Бизнеса «Синергия»</a></i></p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 1988-2015. Школа Бизнеса «СИНЕРГИЯ», Все права защищены.<br>105318 Москва, Измайловский вал, 2, стр. 1, офис 602.<br>Тел. {$partner_phone}</div>
</div>
EOD;
return $str;