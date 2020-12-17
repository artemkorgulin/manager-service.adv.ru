<?php
	$f = fopen("/var/www/syn.su/public/logs/whatsapp.log","a+") or die ("error");
	fputs($f,date("d:m:Y h:i:s").print_r(file_get_contents('php://input'),true)."\n");
    fclose($f);
    $config = [
		'host' 	     => 'localhost',
	    'name' 	     => 'lander',
	    'user' 	     => 'lander_user',
	    'password'   => 'PRp26V'
    ]; 
    try {
        $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
        $json = json_decode(file_get_contents('php://input'));
        foreach ($json->messages as $message) {
            $phone = explode("@",$message->author)[0];
            $sel_Users = $pdo->query("SELECT * FROM lander.whatsapp WHERE phone = '".$phone."'")->fetch(PDO::FETCH_ASSOC);
            if ($phone != '79651388313') {
                if (isset($sel_Users['id']) && $sel_Users['id'] > 0) {
                    $query = "UPDATE `lander`.`whatsapp` SET `messages` = :messages WHERE `id` = :id";
                    $upd_User = $pdo->prepare($query);
                    $messages = [];
                    array_push($messages,json_decode($sel_Users['messages']));
                    array_push($messages,$message);                
                    $upd_User->execute(['id'=>$sel_Users['id'],'messages'=>json_encode($messages)]);
                } else {
                    $query = "INSERT INTO `lander`.`whatsapp` (`phone`,`messages`) VALUES (:phone,:messages)";
                    $ins_User = $pdo->prepare($query);
                    $ins_User->execute(['phone'=>$phone,'messages'=>json_encode($message,JSON_HEX_TAG | JSON_HEX_APOS  | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)]);
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL,"https://syn.su/addjob.php");
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, 
                        ["data" => json_encode(
                            [
                                'phone'      => $phone, 
                                'NAME'       => $message->senderName,
                                'sourceName' => '3',
                                'sourceDesc' => 'whatsapp',
                                'landCode'   => 'territoriyabiznesa',
                                'unit'       => 'whatsapp',
                                'sourceCode' => 'whatsapp',
                                'campaign'   => 'whatsapp_territoriyabiznesa',
                                'form'       => 'whatsapp',
                                'medium'     => 'sch',
                                'url'        => 'whatsapp',
                                'comments'   => $message->body
                            ],JSON_HEX_TAG | JSON_HEX_APOS  | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE)
                        ]
                    );  
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($curl);
                    curl_close ($curl);
                }
            }
        }
    } catch(PDOException $e) {
        $f=@fopen(dirname(__FILE__) . "/logs/error.db.log","a+") or ("error");
        fputs($f, date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
        fclose($f);	
    }
?>