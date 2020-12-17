<?php


try {
    $pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

    $stmt = $pdo->query("SELECT * FROM lander.db_job_queue where service='bitrix24' and status =0 order by id ".$_REQUEST['sort']." limit 1000")->fetchAll();

    foreach ($stmt as $row) {


        $ch = curl_init();
        //   $max_time = 300;
        curl_setopt($ch, CURLOPT_URL, 'https://corp.synergy.ru/api/crm/leads');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $row['data']);
        curl_setopt($ch, CURLOPT_HEADER, false);
          // curl_setopt($ch, CURLOPT_TIMEOUT_MS, $max_time);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($ch);
        curl_close($ch);

       // $resp_bak = $response;
       // $response = json_decode($response);
      //  $query = "";
       // if ($response->result < 1) {
       //     $query = "UPDATE `db_job_queue` SET `status` = 3, `detail` = '" . $resp_bak . "' WHERE id = " . $row['id'];
      //  }

        //if (isset($response->id)) {

            $query = "UPDATE `db_job_queue` SET `status` = 2, `detail` = '" . $response->id . "' WHERE id = " . $row['id'];

       // }
       // if ($query != '') {
            print_r($query);
            $stmtUPD = $pdo->query($query);
        //}
    }


} catch (PDOException $e) {
    $f = @fopen(dirname(__FILE__) . "/logs/error.addjob.log", "a+") or ("error");
    fputs($f, date("d:m:Y h:i:s") . 'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage() . "\n");
    fclose($f);
}