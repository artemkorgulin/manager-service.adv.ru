<?php
// Проставляем нумерацию билетов
$log_file = UNIT_DIR.'/logs/registrations.log';
$num = file_get_contents($log_file) + 1;
$num = (int)$num;

$f = fopen($log_file, "w+");
fputs($f, $num);
fclose($f);

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 600px; padding: 10px 20px 0;">
		<img src="http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/img/mail/BP_rassylka.jpg" alt="" width="600" height="400">
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FFFFFF; border:1px solid #FFFFFF; border-radius:6px;">
		<p>Спасибо за&nbsp;регистрацию на&nbsp;шоу «Брусиловский прорыв»!</p>
		<p>Это письмо является вашим входным билетом на&nbsp;шоу. Билет действителен на&nbsp;одно лицо.</p>
		<p>Пожалуйста, распечатайте его или&nbsp;предъявите в&nbsp;электронном виде на&nbsp;экране вашего смартфона при&nbsp;входе на&nbsp;территорию мероприятия.</p>
		<h3>Место проведения шоу:</h3>
		<p>«Парк Патриот», Московская область, Одинцовская область, г. Кубинка, 55&nbsp;км Минского шоссе.</p>
		<p>Сайт парка: <a href="http://patriotp.ru/" target="_blank">patriotp.ru</a></p>
		<h3>Как добраться:</h3>
		<p><b>На&nbsp;общественном транспорте:</b> с&nbsp;Белорусского вокзала, Смоленское направление&nbsp;МЖД, станция Кубинка-1, далее автобусом.</p>
		<p><b>На&nbsp;автомобиле:</b> по&nbsp;Минскому шоссе (55&nbsp;км). На&nbsp;территории Парка действует бесплатная парковка.</p>
		<p>Приезжайте пораньше, чтобы успеть занять место на&nbsp;комфортабельной крытой трибуне (рассадка свободная), рассмотреть военную технику, <span style="white-space:nowrap;">сфотографироваться</span> в&nbsp;историческом фотоателье, записаться на&nbsp;участие в&nbsp;съемках полноформатного документального фильма и… много чего&nbsp;еще!</p>
		<p>Подробнее о&nbsp;мероприятии можете узнать из&nbsp;<a href="http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/presentation.pdf" target="_blank">презентации</a>.</p>
		<hr style="color: #E5E5E5;">
		<h3>Организаторы мероприятия</h3>
		<p><img src="http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/img/mail/logo.jpg" alt="" width="374" height="54"></p>
		<h3>Информационные партнеры</h3>
		<p><img src="http://xn--90acawbgfg1aekeibee2a1n.xn--p1ai/img/mail/logo-info-new.jpg" alt="" width="591" height="70"></p>
		<hr style="color: #E5E5E5;">
		<div style="font-size: 12px; color: #a9a9a9;">Билет №$num.</div>
	</div>
</div>
EOD;
return $str;