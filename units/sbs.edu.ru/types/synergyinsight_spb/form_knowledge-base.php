<?php
$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>Совсем скоро мы&nbsp;пришлем вам видеозаписи выступлений спикеров СИФ 2016.</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Получите полный комплект видеозаписей Synergy Insight Forum 2016";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight_spb/knowledge-base.php';