<?php
require '/var/www/syn.su/public/worker/GetResponseAPI3.class.php';
$url_api = 'https://api3.getresponse360.pl/v3';

try {
    $pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);

    $stmt = $pdo->query("SELECT * FROM `db_job_queue` WHERE `status`=0 AND `service`='getresponse' ORDER BY id DESC LIMIT ".$_REQUEST['limit']);

    foreach ($stmt as $row) {
        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=1 WHERE id = ".$row['id']);
        $sql = "SELECT `id`, `service`, `data` FROM `db_job_queue` WHERE `detail`='daemon" . getmypid() . "'";
        $result = $row;
        $data = json_decode($result['data'], true);
        switch($data["account"]) {
                case 'synergy':
                     case 'synergy':
                    // бизнес-логика Университета
                    // кампании, в которые нужно подписчика копировать
                    // т.е. в идеале подписчик присутсвует во всех кампаниях
                    $pullCopy = array(
                        'yurkov_blog' => '',
                        'e_mail_chain_sert' => '',
                        'e_mail_chain_tracy' => '',
                        'e_mail_chain_sgf' => '',
                        'e_mail_regular_wb' => '',
                        'e_mail_chain_nedozvon' => '',
                        'e_mail_chain_poslevuz' => '',
                        'mk_alibasov' => '',
                        'e_mail_chain_lectorium' => '',
                        'after_happy_new_year' => '',
                        'e_mail_chain_nedozvon2' => '',
                        'e_mail_regular_wb' => '',
                        'e_mail_chain_bp' => '',
                        'e_mail_chain_subsgf' => '',
                        'e_mail_chain_cat' => '',
                        'e_mail_chain_sif' => '',
                        'e_mail_chain_storm_berlin' => '',
                        'e_mail_chain_ny' => '',
                        'e_mail_chain_sgf_ny' => '',
                        'e_mail_chain_sub_en' => '',
                        'e_mail_chain_sub_ny' => '',
                        'e_mail_chain_sif_video' => '',
                        'e_mail_chain_map_new' => '',
                        'e_mail_chain_grb' => '',
                        'e_mail_chain_sif2017' => '',
                        'e_mail_chain_mail_sgfpodpis_msk' => '',
                        'e_mail_chain_almaty'    => '',
                        'synergy_digital'        => '',
                        'e_mail_chain_lectorium' => '',
                        'e_mail_chain_vpo_en'    => '',
                        'e_mail_chain_vpo'       => '',
                        'e_mail_chain_transm'    => '',
                        'e_mail_chain_trans_p'   => '',
                        'web_bm_avetov_partners' => '',
                        'webinar_dvyurkov'       => '',
                        'e_mail_m_systems'       => '',
                        'e_mail_chain_bz3'       => '',
                        'e_mail_chain_synonline' => '',
                        'e_mail_chain_referent'  => ''
                    );

                    // кампании, между которыми подписчик перемещается
                    // т.е. в идеале подписчик присутсвует только в одной кампании из списка
                    $pullMove = array(
                        'sub_mag_2'              => '',
                        'e_mail_chain_catalog'   => '',
                        'e_mail_regular_dubai'   => '',
                        'e_mail_chain_bank'      => '',
                        'e_mail_chain_distance'  => '',
                        'e_mail_chain_fb'        => '',
                        'e_mail_chain_fi'        => '',
                        'e_mail_chain_college'   => '',
                        'e_mail_chain_mag'       => '',
                        'e_mail_chain_mag2'      => '',
                        'e_mail_chain_moms'      => '',
                        'e_mail_chain_perevod'   => '',
                        'e_mail_chain_sub'       => '',
                        'e_mail_chain_sng'       => '',
                        'e_mail_chain_zao'       => '',
                        'e_mail_chain_proftest'         => '',
                        'e_mail_chain_finishproftest'   => '',
                        'e_mail_chain_engtest'          => '',
                        'e_mail_chain_roi'       => '',
                        'e_mail_chain_aspirant'  => '',
                        'e_mail_chain_armiya'    => '',
                        'e_mail_chain_engblend'  => '',
                        'e_mail_chain_icamp'     => '',
                        'e_mail_chain_nedozvon'  => '',
                        'e_mail_chain_dogovor'   => '',
                        'e_mail_chain_submba'    => '',
                        'e_mail_chain_intensiv'  => '',
                        'e_mail_chain_sm'        => '',
                        'e_mail_chain_mba'       => '',
                        'e_mail_chain_minimba'   => '',
                        'e_mail_chain_distper'   => '',
                        'e_mail_chain_intensiv'  => '',
                        'e_mail_chain_jonst'     => '',
                        'e_mail_chain_win'       => '',
                        'e_mail_chain_dubai_eng' => '',
                        'e_mail_chain_icampleto' => '', 
                        'e_mail_chain_aspirzao'  => '',
                        'e_mail_chain_7days'     => '',
                        'e_mail_chain_eng'       => '',
                        'e_mail_chain_emba'       => '',
                        'e_mail_chain_calc'       => ''
                    );

                    $getresponsesynergy = new GetResponse('b5eabf78cf42cbbe61f660361ffce627');
                    $getresponsesynergy->enterprise_domain = 'e.synergy.edu.ru';
                    $getresponsesynergy->api_url = $url_api; 
                    $contacts =  $getresponsesynergy->getContactsIdByEmail($data['email']);

                    $contact = "";
                    if (isset($contacts[0]['contactId'])) {
                        $contact = $contacts[0]['contactId'];
                    }
                    if (empty($contact)) {
                        $campaignId =  $getresponsesynergy->getCampaignIdByName(trim($data["campaign"]));
                        if(empty($campaignId)) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='Компании ".$data['campaign']." не существует в GR' WHERE `id` = ".$result['id']);
                        }
               
                        $requ = $getresponsesynergy->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => array('campaignId' => $campaignId),
                            'ipAddress'         => $data['ip'],
                         
                        ]);
                        print_r($requ);
                        $requ = json_decode(json_encode($requ), True);

                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $flagSuccess['queued'] = 1;
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Отправлен запрос на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                        }
                    }
                    else {
                        if (array_key_exists($data["campaign"], $pullCopy)) {
                            foreach ($pullCopy as $k => $v) {
                                $campaign = $getresponsesynergy->getCampaignIdByName(mb_strtolower(trim($k)));
                                if (empty($campaign)) {
                                    unset($pullCopy[$k]);
                                    continue;
                                }
                                $pullCopy[$k] = $campaign;
                            }
                           
                            foreach($contacts as $v) {
                                if($v['campaign'] == $pullCopy[$data['campaign']]) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Контакт ".$data['email']." уже присутствует в компании ".$data['campaign']."' WHERE `id` = ".$result['id']);
                                }
                            }
                   
                            if ($data["campaign"] == 'e_mail_chain_sif2017' || $data["campaign"] == 'e_mail_m_systems') {
                                $requ = $getresponsesynergy->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        =>  "0",
                                    'campaign'          => ['campaignId' => $pullCopy[$data["campaign"]]],
                                    'ipAddress'         => $data['ip']
                                ]);
                            } else {
                                $requ = $getresponsesynergy->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                                    'campaign'          => ['campaignId' => $pullCopy[$data["campaign"]]],
                                    'ipAddress'         => $data['ip'],
                                 
                                ]);
                            }
                            $requ = json_decode(json_encode($requ), True);
                            if (isset($requ['message'])) {
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                            } else {
                                $flagSuccess = ['queued' => 1];   
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Отправлен запрос дублирования контакта в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                            }
                        } elseif(array_key_exists($data["campaign"], $pullMove)) {
                            foreach ($pullMove as $k => $v){
                                $campaign = $getresponsesynergy->getCampaignIdByName(mb_strtolower(trim($k)));
                                if(empty($campaign)) {
                                    unset($pullMove[$k]);
                                    continue;
                                }
                                $pullMove[$k] = $campaign;
                            }
                        
                            foreach ($contacts as $k => $v) {
                                if ($v['campaign']['campaignId'] == $pullMove[$data['campaign']]) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Контакт ".$data['email']." уже есть в компании ".$data['campaign']."' WHERE `id` = ".$result['id']);
                                }
                                if (in_array($v['campaign']['campaignId'], $pullMove) == false) {
                                    unset($contacts[$k]);                    
                                } 
                            }
                            if (count($contacts) > 1) {
                                $i = 0;
                                foreach($contacts as $k => $v) {
                                    if($i === 0) {
                                        $i++;
                                        continue;
                                    }
                                    $delete = $getresponsesynergy->deleteContact($v['contactId']);
                                }
                                unset($i);
                            }
                            if(count($contacts) == 1){
                                $campaignId =  $getresponsesynergy->getCampaignIdByName(trim($data["campaign"]));
                                $move = (array)$getresponsesynergy->updateContact($contact,[
                                    'campaign'  => ['campaignId' => $campaignId]
                                ]);
                                if (isset($move['message'])) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$move['message']."' WHERE `id` = ".$result['id']);
                                } else {
                                    $getresponsesynergy->updateContact($contact,[
                                        'dayOfCycle' => isset($data['cycle_day']) ? $data['cycle_day'] : "0"
                                    ]);
                                }
                                if (isset($move['contactId']) && ($move['contactId'] != "")) {
                                    $flagSuccess = ['queued' => 1];
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2,`detail`='Подписчик перемещен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                                } 
                            }
                        
                            if(count($contacts) == 0) {
                   
                                $requ = $getresponsesynergy->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                                    'campaign'          => ['campaignId' => $pullMove[$data["campaign"]]],
                                    'ipAddress'         => $data['ip'],
                                 
                                ]);
                                $requ = json_decode(json_encode($requ), True);
                                if (isset($requ['message'])) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                                } else {
                                    $flagSuccess['queued'] = 1;
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Поставлен в очередь на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                                }
                            }  
                        }
                    }

                    if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
                         $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2 WHERE `id` = ".$result['id']);
                    } else {
						$flagSuccess = isset($flagSuccess) ? $flagSuccess : "Нет ответа от ГР";
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".print_r($flagSuccess, true)."' WHERE `id` = ".$result['id']);
                    }
                    break;
                case 'sgf2017':
                    $pullCopy = [
                        'e_mail_chain_sub_en_sgf' => '',
                        'email_students'          => '',
                        'e_mail_chain_ny_en_video' => ''
                    ];
                    $pullMove = [
                    ];

                    $getresponsesgf = new GetResponse('3e59363b2075ea6821687e9f1eb08f25');
                    $getresponsesgf->enterprise_domain = 'email.sgf2017.com';
                    $getresponsesgf->api_url = $url_api; 
                    $contacts =  $getresponsesgf->getContactsIdByEmail($data['email']);
                    $contact = "";
        
                    if (isset($contacts[0]['contactId'])) {
                        $contact = $contacts[0]['contactId'];
                    }

                    if (empty($contact)) {
                        $campaignId =  $getresponsesgf->getCampaignIdByName(trim($data["campaign"]));
                        if(empty($campaignId)) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='Компании ".$data['campaign']." не существует в GR' WHERE `id` = ".$result['id']);
                        }
                   
                        $requ = $getresponsesgf->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => ['campaignId' => $campaignId],
                            'ipAddress'         => $data['ip'],
                         
                        ]);
                        $requ = json_decode(json_encode($requ), True);

                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $flagSuccess['queued'] = 1;

                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Отправлен запрос на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                        }
                    }
                    else {
                        if (array_key_exists($data["campaign"], $pullCopy)) {
                            foreach ($pullCopy as $k => $v) {
                                $campaign = $getresponsesgf->getCampaignIdByName(mb_strtolower(trim($k)));
                                if (empty($campaign)) {
                                    unset($pullCopy[$k]);
                                    continue;
                                }
                                $pullCopy[$k] = $campaign;
                            }
                                                 foreach($contacts as $v) {
                                if($v['campaign'] == $pullCopy[$data['campaign']]) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Контакт ".$data['email']." уже присутствует в компании ".$data['campaign']."' WHERE `id` = ".$result['id']);
                                }
                            }
                     
                            if ($data["campaign"] == 'e_mail_chain_sif2017') {
                                $requ = $getresponsesgf->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        =>  "0",
                                    'campaign'          => ['campaignId' => $pullCopy[$data["campaign"]]],
                                    'ipAddress'         => $data['ip']
                                ]);
                            } else {
                                $requ = $getresponsesgf->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                                    'campaign'          => ['campaignId' => $pullCopy[$data["campaign"]]],
                                    'ipAddress'         => $data['ip'],
                                 
                                ]);
                            }
                            $requ = json_decode(json_encode($requ), True);

                            if (isset($requ['message'])) {
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                            } else {
                                $flagSuccess = ['queued' => 1];   
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Отправлен запрос дублирования контакта в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);    
                            }
                        } elseif(array_key_exists($data["campaign"], $pullMove)) {
                            foreach ($pullMove as $k => $v){
                                $campaign = $getresponsesgf->getCampaignIdByName(mb_strtolower(trim($k)));
                                if(empty($campaign)) {
                                    unset($pullMove[$k]);
                                    continue;
                                }
                                $pullMove[$k] = $campaign;
                            }
                
                            foreach ($contacts as $k => $v) {
                                if ($v['campaign']['campaignId'] == $pullMove[$data['campaign']]) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Контакт ".$data['email']." уже есть в компании ".$data['campaign']."' WHERE `id` = ".$result['id']);
                                }
                                if (in_array($v['campaign']['campaignId'], $pullMove) == false) {
                                    unset($contacts[$k]);                    
                                } 
                            }
                            if (count($contacts) > 1) {
                                $i = 0;
                                foreach($contacts as $k => $v) {
                                    if($i === 0) {
                                        $i++;
                                        continue;
                                    }
                                    $delete = $getresponsesgf->deleteContact($v['contactId']);
                                }
                                unset($i);
                            }
                            if(count($contacts) == 1){
                                $campaignId =  $getresponsesgf->getCampaignIdByName(trim($data["campaign"]));
                                $move = (array)$getresponsesgf->updateContact($contact,[
                                    'campaign'  =>  ['campaignId' => $campaignId]
                                ]);
                                if (isset($move['message'])) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$move['message']."' WHERE `id` = ".$result['id']);
                                } else {
                                    $getresponsesgf->updateContact($contact,[
                                        'dayOfCycle' => isset($data['cycle_day']) ? $data['cycle_day'] : "0"
                                    ]);
                                }
                                if (isset($move['contactId']) && ($move['contactId'] != "")) {
                                    $flagSuccess = ['queued' => 1];
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2,`detail`='Подписчик перемещен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                                } 
                            }
                            if(count($contacts) == 0) {
                     
                                $requ = $getresponsesgf->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                                    'campaign'          => ['campaignId' => $pullMove[$data["campaign"]]],
                                    'ipAddress'         => $data['ip'],
                                 
                                ]);
                                $requ = json_decode(json_encode($requ), True);
                                if (isset($requ['message'])) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                                } else {
                                    $flagSuccess['queued'] = 1;
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Поставлен в очередь на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                                }
                            }  
                        }
                    }

                    if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2 WHERE `id` = ".$result['id']);
                    } else {
                        $flagSuccess = isset($flagSuccess) ? $flagSuccess : "Нет ответа от ГР";
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".print_r($flagSuccess, true)."' WHERE `id` = ".$result['id']);
                    }
                    break;
				case 'sbsedu':
                    $pullSpecial = [
                        'sub_mba' => '',
                        'sgf' => '',
                        'sif' => '',
                        'startup' => '',
                        'demo_emba' => '' 
                    ];
                    
                    $pullCopySbs = [
                        'webinar' => '',
                        'sgf_video' => '',
                        'start' => '',
                        'office' => '',
                        'business' => '',
                        'student' => '',
                        'hartmann' => '',
                        'goldstar' => '',
                        'start_clients' => '',
                        'sif_demo'  => '',
                        'webinar_test' => '',
                        'mk_buyers' => '',
                        'sif1_buyers' => '',
                        'ed_buyers' => '',
                        'sif2_buyers' => '',
                        '4_buyers' => '',
                        'mb_buyers' => '',
                        'rg_buyers' => '',
                        'startup2' => '',
                        'startup'  => '',
                        'openday_mba' => '',
                        'transformation_no_inn'=>'',
                        'transformation_all_leads' => '',
                        'transformation_2'         => '',
                        '18_synergywomenforum'     => ''
                    ];

                    $pullMoveSbs = [
                        'webinar_buyers' => '',
                        'sif_buyers' => '',
                        'sifsale_buyers' => '',
                        'start_chain' =>'',
                        'vheroes_buyers' =>'',
                        'start_trip' => '',
                        'startsale_buyers' => '',
                        'start_buyers' => ''
                    ];

                    $getresponsesbsedu = new GetResponse('7d19c9913eca9b7099f54c5e07bbb90d');
                    $getresponsesbsedu->enterprise_domain = 'info.sbs.edu.ru';
                    $getresponsesbsedu->api_url = $url_api; 
                    $contact =  $getresponsesbsedu->getContactsIdByEmail($data['email']);
                    if (empty($contact)) { 
                        $landId = $speakerId = $programId = 1; 
                        $land = $speaker = $program = $landLast = '-'; 
                 
      
                        $campaignId =  $getresponsesbsedu->getCampaignIdByName(trim($data["campaign"]));
                        if(empty($campaignId)) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='Компании ".$data['campaign']." не существует в GR' WHERE `id` = ".$result['id']);
                        }
                      
                        $requ = $getresponsesbsedu->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => array('campaignId' => $campaignId),
                            'ipAddress'         => $data['ip'],
                         
                        ]);
                        $requ = json_decode(json_encode($requ), True);

                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Отправлен запрос на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                            $flagSuccess = ['queued' => 1];
                        }
                    } else {
            
                        if (array_key_exists($data["campaign"], $pullCopySbs)) {
                            $campaignId = $getresponsesbsedu->getCampaignIdByName($data["campaign"]);
                            $requ = $getresponsesbsedu->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => "0",
                                    'campaign'          => ['campaignId' => $campaignId],
                                    'ipAddress'         => $data['ip'],
                                    
                            ]);
                            $requ = json_decode(json_encode($requ), True);
                            if (!isset($requ['message'])) {
                                $flagSuccess = ['queued' => 1];
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Подписчик добавлен в компанию ".$data['campaign']."' WHERE `id` = ".$result['id']);
                            } 
                        }  elseif (array_key_exists($data["campaign"], $pullMoveSbs)) {
                            $idCont = $contact[0]['contactId'];
                            $campaignId = $getresponsesbsedu->getCampaignIdByName($data["campaign"]);
                            $move = (array)$getresponsesbsedu->updateContact($idCont,[
                                'campaign'  =>  ['campaignId' => $campaignId]
                            ]);
                            if (isset($move['message'])) {
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$move['message']."' WHERE `id` = ".$result['id']);
                            } else {
                                $getresponsesbsedu->updateContact($idCont,[
                                    'dayOfCycle' => isset($data['cycle_day']) ? $data['cycle_day'] : "0"
                                ]);
                            }
                            if (isset($move['contactId']) && ($move['contactId'] != "")) {
                                $flagSuccess = ['queued' => 1];
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Подписчик перемещен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                            } 
                        } elseif (array_key_exists($data["campaign"], $pullSpecial)) {
                            foreach($pullSpecial as $k => $v) {
                                $campaign = $getresponsesbsedu->getCampaignIdByName(mb_strtolower(trim($k)));
                                if(empty($campaign)) {
                                    unset($pullSpecial[$k]);
                                    continue;
                                }
                                $pullSpecial[$k] = $campaign;
                            }
                            foreach ($contact as $k => $v) {
                                if ($v['campaign']['name'] == $pullSpecial[$data["campaign"]]) {
                                    continue;
                                }
                                $delete = $getresponsesbsedu->deleteContact($v['contactId']);
                                unset($contact[$k]);
                            }
                            if (empty($contact)) {
                                $requ = $getresponsesbsedu->addContact([
                                    'name'              => $data['name'],
                                    'email'             => $data['email'],
                                    'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                                    'campaign'          => ['campaignId' => $pullSpecial[$data["campaign"]]],
                                    'ipAddress'         => $data['ip'],
                                    
                                ]);

                                $requ = json_decode(json_encode($requ), True);
                                $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2,`detail`='Подписчик добавлен в спец.компанию' WHERE `id` = ".$result['id']);
                            } else { 
                                $$stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2,`detail`='Подписчик в спец.компании уже есть' WHERE `id` = ".$result['id']);
                                $flagSuccess = ['queued' => 1];
                            }
                        } elseif ($data["campaign"] == 'total_subscription') {
                            $data["campaign"] = 'old_subscription';
                            $campaignId = $getresponsesbsedu->getCampaignIdByName($data["campaign"]);
                            if (!empty($campaignId)) {
                                $contactId =  $getresponsesbsedu->getContactIdByEmailCampaign($data['email'],$campaignId);
                                if($contactId != "") {
                                    $requ = $getresponsesbsedu->updateContact($contactId,[
                                            'dayOfCycle' => "0"
                                    ]);
                                    $requ = json_decode(json_encode($requ), True);
                                    if (!isset($requ['message'])) {
                                        $flagSuccess['queued'] = 1;
                                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Счетчик сброшен' WHERE `id` = ".$result['id']);
                                    }
                                } else{	
                                    $requ = $getresponsesbsedu->addContact([
                                        'name'              => $data['name'],
                                        'email'             => $data['email'],
                                        'dayOfCycle'        => "0",
                                        'campaign'          => ['campaignId' => $campaignId],
                                        'ipAddress'         => $data['ip'],
                                        
                                    ]);
                                    $requ = json_decode(json_encode($requ), True);
                                    if (!isset($requ['message'])) {
                                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Подписчик добавлен в компанию old_subscription' WHERE `id` = ".$result['id']);
                                    }  
                                }
                            } 
                        }  else {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Подписчик уже имеет подписку' WHERE `id` = ".$result['id']);
                            $flagSuccess = ['queued' => 1];
                        }
                    }
                    if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2 WHERE `id` = '%s' LIMIT 1", $result['id']);
                    } else {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Подписчик добавлен' WHERE `id` = ".$result['id']);
                    }
                    break;
				case 'drb':
                    $getresponsedrb = new GetResponse('82595ce6a67b4c596d13a89250ffd3e6');
                    $getresponsedrb->enterprise_domain = 'drb.sbs.edu.ru';
                    $getresponsedrb->api_url = $url_api; 
                    $campaign =  $getresponsedrb->getCampaignIdByName(trim($data["campaign"]));
                    if ($campaign == "") {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='Компания не найдена' WHERE `id` = ".$result['id']);
                    }
     
                    if ($data['grtag'] != null) {
                        $requ = $getresponsedrb->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => ['campaignId' => $campaign],
                            'ipAddress'         => $data['ip']
                        ]);    
                        $grTag = $data['grtag'];
                        $requ = json_decode(json_encode($requ), True);
                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $idContacts =  $getresponsedrb->getContactsIdByEmail($data['email']);
                            $idCont = $idContacts[0]['contactId'];
                            $getresponsedrb->updateContact($idCont,[
                                'tags' => ['tagId' => $getresponsedrb->getTagsByName($grTag)],
                             
                            ]);
                            $flagSuccess['queued'] = 1;
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Добавлен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                        }
                    } else {
                        $requ = $getresponsedrb->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => ['campaignId' => $campaign],
                            'ipAddress'         => $data['ip']
                        ]);
                        $requ = json_decode(json_encode($requ), True);
                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $idContacts =  $getresponsedrb->getContactsIdByEmail($data['email']);
                            $idCont = "";
                            if (isset($idContacts[0]['contactId'])) {
                                $idCont = $idContacts[0]['contactId'];
                            }
                            $getresponsedrb->updateContact($idCont,[
                             
                            ]);
                            $flagSuccess['queued'] = 1;
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Добавлен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                        }  
                    }
                        if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2 WHERE `id` = ".$result['id']);
                        } else {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        }
                    break;
                default:
                    $url_api = 'https://api3.getresponse360.pl/v3';
                    switch ($data['account']) {
                        case 'megacampus':
                            $getresponsedefult = new GetResponse('e4252f1403442043580652ee02a9aa8f');
                            $getresponsedefult->enterprise_domain = 'e.megacampus.ru';
                            break;
                        case 'egemetr':
                            $getresponsedefult = new GetResponse('99c6a18b107f72dc3550c35b9f134778');
                            $getresponsedefult->enterprise_domain = 'e.egemetr.ru';
                            break;
                    }
                    $getresponsedefult->api_url = $url_api; 
                    $campaignId =  $getresponsedefult->getCampaignIdByName(trim($data["campaign"])); 
                    if (empty($campaignId)) {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='Компания не найдена' WHERE `id` = ".$result['id']);
                    }
                    $contact =  $getresponsedefult->getContactsIdByEmail($data['email']); 
                    if(empty($contact)) {
   
                       	$requ = $getresponsedefult->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => ['campaignId' => $campaignId],
                            'ipAddress'         => $data['ip'],
                         
                        ]);
                        $requ = json_decode(json_encode($requ), True);
                        if (isset($requ['message'])) {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Отправлен запрос на добавление в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                            $flagSuccess = ['queued' => 1];
                        }
                    }
                    else {
          
                            foreach($contacts as $v) {
                                if($v['campaign'] == $pullCopy[$data['campaign']]) {
                                    $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2, `detail`='Контакт ".$data['email']." уже присутствует в компании ".$data['campaign']."' WHERE `id` = ".$result['id']);
                                }
                            }
              
                        $requ = $getresponsedefult->addContact([
                            'name'              => $data['name'],
                            'email'             => $data['email'],
                            'dayOfCycle'        => isset($data['cycle_day']) ? $data['cycle_day'] : "0",
                            'campaign'          => ['campaignId' => $campaignId],
                            'ipAddress'         => $data['ip'],
                         
                        ]);
                        $requ = json_decode(json_encode($requ), True);
                        if (isset($requ['message'])) {
                            print('DEFAULT Error --- 3');
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".$requ['message']."' WHERE `id` = ".$result['id']);
                        } else {
                            $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `detail`='Добавлен в компанию ".$data["campaign"]."' WHERE `id` = ".$result['id']);
                            $flagSuccess = ['queued' => 1];
                        }
                    }
                    if ((isset($flagSuccess['queued'])) && ($flagSuccess['queued'] == 1)) {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=2 WHERE `id` = ".$result['id']);
                    } else {
                        $stmtupd = $pdo->query("UPDATE `db_job_queue` SET `status`=3, `detail`='".print_r($flagSuccess, true)."' WHERE `id` = ".$result['id']);
                    }
                    break;
        }
    }    
} catch(PDOException $e) {
    $f=@fopen(dirname(__FILE__)."/logs/error.addGetResponse.log","a+") or ("error");
    fputs($f,date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: '.$e->getMessage()."\n");
    fclose($f); 
}



function isServiceAvailable($url) {
        if(!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }
        $cl = curl_init($url);
        curl_setopt($cl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($cl, CURLOPT_HEADER, true);
        curl_setopt($cl, CURLOPT_NOBODY, true);
        curl_setopt($cl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($cl, CURLOPT_SSL_VERIFYHOST, 0);
        $response = curl_exec($cl);
        $error = curl_errno($cl);
        if (!empty($error))
            return false;
        $httpcode = curl_getinfo($cl, CURLINFO_HTTP_CODE);
        if (!empty($httpcode))
            return $httpcode;
        curl_close($cl);
        return false;
}