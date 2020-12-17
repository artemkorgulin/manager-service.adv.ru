<?php
$str = <<<EOD
<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
	<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">
		<h3>Ваше обращение получено! </h3>
		<p>В ближайшее время мы свяжемся с Вами.</p>
		<hr style="color: #E5E5E5;">
		<p>С&nbsp;уважением, Центр профессиональной переподготовки <a href="//{$siteurl}">{$siteurl}</a></p>
	</div>
</div>
EOD;

return $str;