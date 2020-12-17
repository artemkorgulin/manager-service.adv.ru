<?php
/*
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru?utm_source=tranzmail-mk" title="Перейти на сайт Университета"><img src="http://synergy.ru/img/logo.png" alt="" style="width:174;height:auto"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Вы успешно зарегистрировались на программу <b>«{$program}»</b></b>.</p>
		<p><b>Если Вы еще не оплатили участие</b></p>
		<p>Оплатите участие банковской картой или электронными деньгами. Онлайн-платежи защищены, а процесс оплаты займет не более 2 минут. Мы используем сервис IntellectMoney.</p>

		<p style="margin:40px 0; text-align: center;"><a href="https://merchant.intellectmoney.ru/?eshopId={$im_purse}&user_email={$lead->email}&recipientAmount={$lead->cost}&serviceName={$program}&userName={$lead->name}&OrderId={$order_id}&recipientCurrency=RUR&preference=bankCard" style="border-radius:5px; font-size: 15px; color:#003677; margin:20px 0; text-decoration: none; font-weight: bold; border:2px solid #003677; padding:10px 20px;" target="_blank">Перейти к оплате »</a></p>
		<p>После проведения платежа мы вышлем подтверждение и включим вас в список участников. </p>
		<p><b>Держите телефон под рукой: мы позвоним, чтобы уточнить условия участия и подтвердить ваши регистрационные данные.</b></p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;">До встречи!<br>Университет «Синергия», <br> <a href="http://www.synergy.ru ">www.synergy.ru</a><br>8 800 707 41 77 </p>
	</div>
</div>
EOD;
*/

$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<a href="http://synergy.ru?utm_source=tranzmail-mk" title="Перейти на сайт Университета"><img src="http://synergy.ru/img/logo.png" alt="" style="width:174;height:auto"></a>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Здравствуйте, {$lead->name}!</h3>
		<p>Спасибо, что оставили заявку на&nbsp;приобретение курса <b>«{$program}»</b>.</p>
		<p>В&nbsp;ближайшее время наш менеджер свяжется с&nbsp;вами для подтверждения заявки и&nbsp;уточнения способа оплаты.</p>
		<p>Платные курсы проекта Synergy Lectorium всегда направлены на&nbsp;изучение наиболее актуальных и&nbsp;востребованных на&nbsp;сегодняшний день тем.</p>
		<p><b>Приобретая курс, вы&nbsp;гарантированно получаете:</b></p>
		&mdash;&nbsp;Доступ в&nbsp;личный кабинет<br>
		&mdash;&nbsp;Подготовленный совместно с&nbsp;методистами учебный план<br>
		&mdash;&nbsp;Обратную связь со&nbsp;спикерами<br>
		&mdash;&nbsp;Лекции, которые навсегда останутся в&nbsp;вашем архиве<br>
		<br>
		<p>Благодарим за&nbsp;внимание!</p>
		<hr style="color: #E5E5E5;">
		<p style="color:#505050;">До встречи!<br>Университет «Синергия», <br> <a href="http://www.synergy.ru ">www.synergy.ru</a><br>8 800 707 41 77 </p>
	</div>
</div>
EOD;

return $str;
