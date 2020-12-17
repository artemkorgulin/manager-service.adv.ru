<?php
$config['ignore']['bitrix24'] = false;

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_ny/rusbz_post_pay.php';
$config['mail']['smtp']['user']['subject'] = "Подтверждение регистрации “Бизнес в Америке”";
$config['mail']['smtp']['fromname'] = "Synergy Global Forum New York";

echo 'ok';