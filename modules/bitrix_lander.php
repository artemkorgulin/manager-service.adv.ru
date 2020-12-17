<?php
    // задача для Bitrix24
    if (GV::$config['ignore']['bitrix24']) {
        $data = array();
        foreach (GV::$config['crm']['bitrix24']['fields'] as $k => $v) {
            $data[$k] = GV::$lead->$v;
        }
        
        $data = json_encode($data); //JSON_UNESCAPED_UNICODE
        Job::addJob('bitrix24', $data, GV::$lead->unit);
    }