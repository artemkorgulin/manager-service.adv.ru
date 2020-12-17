<?php
return [
    'components' => [
        'request' => [
            'class' => \Synergy\lander\app\components\http\HttpRequest::class,
            /*'server' => [
                'HTTP_REFERER' => 'http://synergyonline.ru/lp/zao/new/hny/?utm_source=test&utm_term=term&partner=tp',
            ],
            'get' => [
                'r' => 'drop',
                'unit' => 'synergy',
                'type' => 'vpo',
                'version' => 'hny',
                'form' => 'top',
                'graccount' => 'synergy',
                'grcampaign' => 'e_mail_chain_distance',
            ],
            'post' => [
                'name' => 'Тест',
                'phone' => '+7 (100) 000-00-00',
                'email' => 'aavolkov@synergy.ru',
                'url' => 'http://synergyonline.ru/lp/zao/new/hny/?utm_source=test&utm_term=term&partner=tp'
            ],*/
        ],
        'db' => [
            'class' => \Synergy\lander\app\components\db\LPDO::class,
            'dsn'   => 'mysql:host=localhost;dbname=lander',
            'user'  => 'lander_user',
            'password' => 'PRp26V',
        ],
    ]
];