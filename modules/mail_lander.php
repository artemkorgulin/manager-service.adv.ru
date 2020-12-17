<?php
    // задача: письмо в контакт-центр
    if (GV::$config['ignore']['send_to_cc']) {
        $data = array(
            'aim' => 'cc',
        );
        foreach (GV::$config['mail'][GV::$config['mail']['type']] as $k => $v) {                       // данные с общими параметрами
            if (($k == 'cc') || ($k == 'user')) {
                continue;
            }
            $data[$k] = $v;
        }
        foreach (GV::$config['mail'][GV::$config['mail']['type']]['cc'] as $k => $v) {               // данные со специфическими параметрами для CC
            $data[$k] = $v;
        }
        
        $data['land'] = GV::$lead->land;
        $data['partner'] = GV::$lead->partner;
        $data['email'] = GV::$lead->email;
        $data['phone'] = GV::$lead->phone;
        $data['name'] = GV::$lead->name;
        $data['analytics_id'] = GV::$lead->analytics_id;
        $data['piwik_id'] = GV::$lead->piwik_id;
        $data['mergelead'] = GV::$lead->mergelead;
        $data['refer'] = GV::$lead->refer;//Добавление реферера по https://sd.synergy.ru/task/view/69930
        if (!empty($_FILES)) {
            $save_to = realpath(__DIR__) . "/worker/upload_attach/" . time() . "_" . basename($_FILES['file']['name']);
            if (move_uploaded_file($_FILES['file']['tmp_name'], $save_to)) {
                $data['file_send'] = true;
                $data['files'] = array($save_to);
            }
        }

        $data = json_encode($data); 
        Job::addJob('mail', $data);
    }

    // задача: письмо клиенту
    if (GV::$config['ignore']['send_to_user']) {
        $data = array(
            'aim' => 'user',
        );
        foreach (GV::$config['mail'][GV::$config['mail']['type']] as $k => $v) {                       // данные с общими параметрами
            if (($k == 'cc') || ($k == 'user')) {
                continue;
            }
            $data[$k] = $v;
        }

        foreach (GV::$config['mail'][GV::$config['mail']['type']]['user'] as $k => $v) {               // данные со специфическими параметрами для клиента
            $data[$k] = $v;
        }
        $data['emails'][0][] = GV::$lead->email;
        $data['email'] = GV::$lead->email;
        $data['phone'] = GV::$lead->phone;
        $data['name'] = GV::$lead->name;
        $data['dater'] = GV::$lead->dater;

        $data = json_encode($data); 
        Job::addJob('mail', $data);
    }