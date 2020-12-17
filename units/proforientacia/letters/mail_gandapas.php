<?php

$str = <<<EOD

<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<p><b>Здравствуйте, {$lead->name}!</b></p>
		<p>Благодарим вас за подачу заявки на тренинг Радислава Гандапаса «Ораторское искусство 2.0». Тренинг будет проходить 7 и 8 декабря 2018 года. В ближайшее время с вами свяжется наш менеджер.</p>
		<p>Если вы еще не оплатили билеты, то вы можете это сделать по <a href="{$_SERVER['HTTP_REFERER']}">ссылке</a> в разделе «Стоимость участия».</p>
		<p>С уважением, Школа Бизнеса «Синергия»</p>
	</div>
</div>
EOD;

return $str;