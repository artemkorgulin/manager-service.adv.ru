<?php

$str = <<<EOD

<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 560px; padding: 10px 20px;">
		<h1>Здравствуйте, {$lead->name}!</h1>
	</div>
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Благодарим за Ваш заказ.</h3>
		<p>
			Ваш заказ передан на обработку менеджеру. 
		</p>
		<p>
			В ближайшее время с Вами свяжутся для актуализации данных по заказу.
		</p>
		<p>
			Спасибо!
		</p>
		<p>
			------------------------------------------------------------------------------------------------------ 
		</p>
		<p>
			Это письмо сформировано автоматически! 
		</p>
		<p>
			Отвечать на него не нужно! 
		</p>
		<p>
			Если у вас возникли вопросы по вашему заказу, то, пожалуйста, напишите письмо нам на адрес: <a href="mailto:umlrnd@yandex.ru">umlrnd@yandex.ru</a> 
		</p>
	</div>
</div>
EOD;

return $str;