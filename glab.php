<?php
$f = fopen("/var/www/syn.su/public/logs/glab.log", "a+") or die("error");
fputs($f, date("d:m:Y h:i:s") . print_r(json_decode(file_get_contents('php://input')),true) . "\n");
fclose($f);

$json = json_decode(file_get_contents('php://input'));

if ($json->object_attributes->state == 'merged' && $json->object_attributes->target_branch == "synsu") {
    exec('git pull origin synsu');
}
echo "OK";
