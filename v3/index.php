<?php
header('Access-Control-Allow-Origin: *');
require __DIR__ . '/vendor/autoload.php';

try {
    $config2 = [];
    $config1 = require __DIR__ . '/source/config/main.php';
    if (file_exists(__DIR__ . '/source/config/main-local.php')) {
        $config2 = require __DIR__ . '/source/config/main-local.php';
    }

    (new \Synergy\lander\app\LanderApplication(array_merge($config1, $config2)))->run();

} catch (Exception $e) {
    die ($e->getMessage());
}