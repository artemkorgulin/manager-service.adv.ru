<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru" title="Перейти на сайт Университета"><img src="http://synergy.ru/lp/box/logo/logo.png" alt="" width="240" height="35"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Спасибо, что оставили заявку на приобретение курса <b>«Актерское мастерство суворовской закалки».</b></p>

		<p>В ближайшее время наш менеджер свяжется с вами для подтверждения заявки и уточнения способа оплаты.</p>

		<p>Платные курсы проекта Synergy Lectorium всегда направлены на изучение наиболее актуальных и востребованных на сегодняшний день тем.</p>

		<p>Приобретая курс, вы гарантированно получаете:
		<br>
		<ul>
		<li>Доступ в личный кабинет</li>
		<li>Подготовленный совместно с методистами учебный план</li>
		<li>Обратную связь со спикерами</li>
		<li>Лекции, которые навсегда останутся в вашем архиве</li>
		</ul>
		</p>

		<p>Благодарим за внимание!</p>
	</div>
	<div style="text-align: center; margin-top: 15px; color:#909090; font-size:11px;">© 2015. Университет «Синергия», Все права защищены.<br>125190, г.&nbsp;Москва, Ленинградский пр-т, д.&nbsp;80, корпуса&nbsp;Г,&nbsp;Е,&nbsp;Ж.<br>Тел. <a href="tel:+74958001001">+7 (495) 800 10 01</a></div>
</div>
EOD;
return $str;