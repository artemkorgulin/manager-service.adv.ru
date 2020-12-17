<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>Совсем скоро мы&nbsp;пришлем вам видеозаписи выступлений спикеров SIF 2017.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Получите полный комплект видеозаписей Synergy Insight Forum 2016";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/knowledge-base.php';

/* https://sd.synergy.ru/Task/View/131058 */
$config['ignore']['send_to_user'] = false;