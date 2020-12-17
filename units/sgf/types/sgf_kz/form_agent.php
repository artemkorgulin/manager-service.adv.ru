<?php
include_once 'form_partner.php';

$config['mail']['smtp']['user']['subject'] = "Партнеру Synergy Global Forum 2017 в Алматы";

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sgf_kz/agent.php';