<?php
/*$body = <<<EOD
<h3>Приветствуем!</h3>
<p>Вы&nbsp;оставляли заявку на&nbsp;видео прошлых Synergy Global Forum, проверяйте почту&nbsp;&mdash; совсем скоро мы&nbsp;вышлем вам лучшие фрагменты выступлений наших неподражаемых спикеров.</p>
EOD;*/

$body = <<<EOD
<h3>Здравствуйте!</h3>
<p>Смотрите видео с&nbsp;Synergy Insight Forum 2016 и&nbsp;вдохновляйтесь знаниями от&nbsp;ведущих российских бизнес-спикеров.</p>
<ul>
	<li>16 спикеров</li>
	<li>16 выступлений</li>
	<li>16 новых инсайтов</li>
</ul>
<p>
Стоимость комплекта видеозаписей 1&nbsp;000&nbsp;рублей.<br>
	Для оплаты перейдите <a href="http://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&shopId=455445&price={$_REQUEST['cost']}&email={$lead->email}&username={$lead->name}&productName=Видеозаписи Synergy Insight Forum 2016&land={$lead->land}&phone={$lead->phone}&form={$lead->form}&mergelead={$lead->mergelead}&gra=synergy&grc=e_mail_chain_sif_video" target="_blank">по&nbsp;ссылке</a>.
</p>
EOD;

$letter = include 'template.php';
return $letter;