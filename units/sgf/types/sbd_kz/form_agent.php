<?php
include_once 'form_partner.php';

$config['mail']['smtp']['user']['subject'] = "Партнеру Synergy Business Day 2018 в Алматы";

$config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/letters/sbd_kz/agent.php';