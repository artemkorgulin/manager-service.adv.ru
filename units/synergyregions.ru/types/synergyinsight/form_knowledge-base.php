<?php
/* https://sd.synergy.ru/Task/View/98946 */
$config['ignore']['send_to_user'] = false;

$config['user']['sendsuccess'] = '
<div class="send-success">
	<h3>Ваша заявка отправлена!</h3>
	<p>В&nbsp;ближайшее время мы&nbsp;пришлем вам доступ к&nbsp;демо-записям всех выступлений Synergy Insight Forum 2016</p>
</div>
';

$config['mail']['smtp']['user']['subject'] = "Synergy Insight Forum: начните Новый год с новых знаний";
$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/mail_synergyinsight/knowledge-base.php';