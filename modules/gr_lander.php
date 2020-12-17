<?php
// задача для GetResponse
//https://sd.synergy.ru/Task/View/101899
if ((strpos(GV::$lead->land, 'synergy_webinars_moscow_skriptyi-prodazh-10-reczeptov-idealnogo-peregovorshhika') !== false) || (strpos(GV::$lead->land, 'lp_fridman_wb-v5') !== false) || (strpos(GV::$lead->land, 'lp_rakov_wb-v1') !== false) || (strpos(GV::$lead->land, 'lp_britva_wb-1') !== false) || (strpos(GV::$lead->land, 'synergy_webinars_moscow_kak-upakovat-stratap-za-40-minut') !== false) || ((GV::$lead->land == "synergyinsight_main") && (GV::$lead->form == "popup-webinars")) && (GV::$config['newsletter']['getresponse']['account'] == 'sbsedu')) {
    if (rand(1, 2) == 1) {
        GV::$config['newsletter']['getresponse']['campaign'] = "webinar";
    } else {
        GV::$config['newsletter']['getresponse']['campaign'] = "webinar_test";
    }
}
//https://sd.synergy.ru/Task/View/104424
if (GV::$lead->land == 'synergystartup_miniland') {
    if (rand(1, 2) == 1) {
        GV::$config['newsletter']['getresponse']['campaign'] = "startup";
    } else {
        GV::$config['newsletter']['getresponse']['campaign'] = "startup2";
    }
}
if (GV::$config['ignore']['getresponse'] && !empty(GV::$lead->email)) {
    $data = array(
        'email' => GV::$lead->email,
        'campaign' => GV::$config['newsletter']['getresponse']['campaign'],
        'account' => GV::$config['newsletter']['getresponse']['account'],
        'name' => GV::$lead->name ? GV::$lead->name : "-",
        'cycle_day' => GV::$lead->cycle_day,
        'grtag' => GV::$lead->grtag,
        'ip' => GV::$lead->ip,
        'custom' => array(),
    );
    foreach (GV::$config['newsletter']['getresponse'][GV::$config['newsletter']['getresponse']['account']]['fields'] as $k => $v) {
        if (!empty(GV::$lead->$v)) {
            $data['custom'][] = array(
                'name' => $k,
                'content' => GV::$lead->$v
            );
        }
    }
    // записываем поледний лэнд (текущий), с которого пришел пользователь
    $data['custom'][] = array(
        'name' => 'last_land',
        'content' => GV::$lead->land,
    );

    $data['custom'][] = array(
        'name' => 'last_date',
        'content' => date("Y-m-d")
    );

    if (GV::$lead->land == 'synergyzavod' && ((GV::$lead->form == 'bottom') || (GV::$lead->form == 'mentor') || (GV::$lead->form == 'top'))) {
        $data['custom'][] = array(
            'name' => 'product_1',
            'content' => '1'
        );
    }

    if (GV::$lead->land == 'transform_webinar_urkov') {
        $data['custom'] = array();
    }
    /*
    $data['custom'][] = array(
        'name' => 'analytics_id',
        'content' => GV::$lead->analytics_id
    );*/

    require('gr_drb_config.php');
    $data = json_encode($data);
    Job::addJob('getresponse', $data, GV::$config['newsletter']['getresponse']['account']);
}

$arrLandInGr = array(
    'synergypeople',
    'kehoe-kz',
    'robbins-coach',
    'sgf2018_msk',
    'croatia-race',
    'synergymba',
    'synergyzavod_business'
);

if (isset(GV::$lead->land) and in_array(GV::$lead->land,$arrLandInGr)) {
    $data = array(
        'email' => GV::$lead->email,
        'campaign' => GV::$lead->grcampaign,
        'account' => GV::$lead->graccount,
        'name' => GV::$lead->name ? GV::$lead->name : "-",
        'cycle_day' => GV::$lead->cycle_day,
        'grtag' => GV::$lead->grtag,
        'ip' => GV::$lead->ip,
        'custom' => array(),
    );
    $data = json_encode($data);
      Job::addJob('getresponse', $data, GV::$config['newsletter']['getresponse']['account']);
}