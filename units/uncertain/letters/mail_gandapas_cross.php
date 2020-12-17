<?php

$str = <<<EOD

<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<p><b>Здравствуйте, {$lead->name}!</b></p>
		<p>Благодарим вас за подачу заявки на тренинг Радислава Гандапаса «{$_REQUEST['program']}». Тренинг будет проходить {$_REQUEST['dater']} года. В ближайшее время с вами свяжется наш менеджер.</p>
		<p>Если вы еще не оплатили билеты, то вы можете это сделать по <a href="{$_SERVER['HTTP_REFERER']}">ссылке</a> в разделе «Купить билет».</p>
		<p>С уважением, Школа Бизнеса «Синергия»</p>
	</div>
</div>
EOD;

return $str;