<?php
    if (stristr(GV::$lead->url, "synergyregions.ru")) {
        //if (GV::$lead->grcampaign != 'arhangelsky_krasnoyarsk') {
            //$data['campaign'] = 'eevmenenko';
        //}
        $data['account'] = 'drb';
        GV::$config['newsletter']['getresponse']['account'] = 'drb';

        $pullDist = array(
            'ekb' => '',
            'kg' => '',
            'krdr' => '',
            'nn' => '',
            'novosibirskbo' => '',
            'orenburg' => '',
            'rnd' => '',
            'spb' => '',
            'sta' => '',
            'ufa' => '',
            'drb' => '',
            'omsk' => '',
            'tomsk' => '',
            'kazan' => '',
            'chelyabinsk' => '',
            'samara' => '',
            'zavod-krasnoyarsk' => '',
            'zavod-chelyabinsk' => '',
            'zavod-samara' => '',
            'zavod-novosibirskbo' => '',
            'zavod-kg' => '',
            'zavod-rnd' => '',
            'zavod-ekb' =>  '',
            'zavod-nn' => '',
            'zavod-drb' => '',
            'zavod-krdr' => '',
            'zavod-ufa' => '',
            'zavod-kazan' => '',
            'zavod-spb' => '',
            'krasnoyarsk' => ''
        );

        if (array_key_exists(GV::$lead->partner, $pullDist)) {
            $data['custom'][] = array(
                'name' => 'partner',
                'content' => GV::$lead->partner
            );
        } else {
            $data['custom'][] = array(
                'name' => 'partner',
                'content' => 'drb'
            );
        }

        if (GV::$lead->land == 'sbs-intensive') {
            $data['campaign'] = '7day';
        }

        if (GV::$lead->land == 'sbs-demo-version-emba') {
            $data['campaign'] = 'demomba';
        }
                        
        if (GV::$lead->land == 'intensive-startup') {
            $data['campaign'] = 'istartup';
            $data['custom'][] = array(
                'name' => 'partner',
                'content' => GV::$lead->partner
            );
        }
        
        if (strpos(GV::$lead->land, 'programms_master-classes_skriptyi-prodazh-10-reczeptov-idealnogo-peregovorshhika') !== false) {
            $data['campaign'] = 'yakuba_spb';
        } 
    } 
    
    if (GV::$lead->land == "synergyserviceforum") {

        $data['custom'][] = array(
            'name' => 'city',
            'content' => 'Санкт-Петербург'
        );

        $data['custom'][] = array(
            'name' => 'city2',
            'content' => 'Санкт-Петербурге'
        );

        $data['custom'][] = array(
            'name' => 'partner',
            'content' => 'spb'
        );

        $data['custom'][] = array(
            'name' => 'segment',
            'content' => 'бизнес'
        );
    }

    $pullDrb = array(
        'chelyabinsk' => '', 
        'drb' => '', 
        'ekb' => '', 
        'kazan' => '', 
        'kg' => '', 
        'krasnoyarsk' => '', 
        'krdr' => '', 
        'nn' => '', 
        'novosibirskbo' => '', 
        'omsk' => '', 
        'rnd' => '', 
        'samara' => '', 
        'spb' => '', 
        'sta' => '', 
        'ufa' => '', 
        'zavod-' => '', 
        'zavod-chelyabinsk' => '', 
        'zavod-drb' => '', 
        'zavod-ekb' => '', 
        'zavod-kazan' => '', 
        'zavod-kg' => '', 
        'zavod-krasnoyarsk' => '', 
        'zavod-krdr' => '', 
        'zavod-nn' => '', 
        'zavod-novosibirskbo' => '', 
        'zavod-rnd' => '', 
        'zavod-samara' => '', 
        'zavod-spb' => '', 
        'zavod-sta' => '', 
        'zavod-ufa' => '', 
        'ggumarova' => ''
    );

    if (array_key_exists(GV::$lead->partner, $pullDrb)) {
        if (strpos(GV::$lead->partner, 'zavod') !== false) {
            switch (GV::$lead->partner) {
                case 'zavod-':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'drb'
                    );
                    break;
                case 'zavod-chelyabinsk':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'chelyabinsk'
                    );
                    break;
                case 'zavod-drb': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'drb'
                    );
                    break;
                case'zavod-ekb': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'ekb'
                    );
                    break;
                case'zavod-kazan':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'kazan'
                    );
                    break; 
                case'zavod-kg':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'kg'
                    );
                    break;
                case'zavod-krasnoyarsk': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'krasnoyarsk'
                    );
                    break;
                case'zavod-krdr': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'krdr'
                    );
                    break;
                case'zavod-nn': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'nn'
                    );
                    break;
                case'zavod-novosibirskbo': 
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'novosibirskbo'
                    );
                    break;
                case'zavod-rnd':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'rnd'
                    );
                    break;
                case'zavod-samara':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'samara'
                    );
                    break;
                case'zavod-spb':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'spb'
                    );
                    break;
                case'zavod-sta':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'sta'
                    );
                    break;
                case'zavod-ufa':
                    $data['custom'][] = array(
                        'name' => 'partner',
                        'content' => 'ufa'
                    );
                    break;
            }
            $data['grtag'] = 'startup';
            $data['campaign'] = 'startupdrb';
        } else {
            $data['custom'][] = array(
                'name' => 'partner',
                'content' => GV::$lead->partner
            );
        }
             
        $data['account'] = 'drb';
        GV::$config['newsletter']['getresponse']['account'] = 'drb';

        if (GV::$lead->land == 'sbs-intensive') {
            $data['campaign'] = '7day';
        }

        if (GV::$lead->land == 'sbs-demo-version-emba') {
            $data['campaign'] = 'demomba';
        }

        if (GV::$lead->land == 'synergyinsight_main') {
            $data['campaign'] = 'sif_2017';
        }

        if (GV::$lead->partner == 'ggumarova') {
            $data['campaign'] = 'kzstart'; 
            if (GV::$lead->land == 'sbs-intensive') {
                $data['campaign'] = 'kz7day';  
            }
        }
    }

    if (GV::$lead->land == "sgf2017_almaty") {
        $data['account'] = 'drb';
        GV::$config['newsletter']['getresponse']['account'] = 'drb';
        $data['campaign'] = 'kz_sgf_sub';
        if (GV::$lead->form == "knowledge-base") {
            $data['campaign'] = 'kz_sgf_sub';
        } else {
            $data['campaign'] = 'kz_sgf';
        }
        $data['custom'][] = array(
            'name' => 'partner',
            'content' => 'drb'
        );
    }