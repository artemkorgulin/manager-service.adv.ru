<?php

$uuid = sprintf(
    '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0x0fff) | 0x4000,
    mt_rand(0, 0x3fff) | 0x8000,
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff),
    mt_rand(0, 0xffff)
);
if (!isset($_COOKIE['uuid'])) {
    setcookie("uuid", $uuid, time() + 60 * 60 * 24 * 365 * 10);
} else {
    $uuid = $_COOKIE['uuid'];
}

echo "<script>(function() {function sendCookie() {window.parent.postMessage({uuid: '" . $uuid . "'}, '*');}setTimeout(sendCookie);})()</script>";


?>