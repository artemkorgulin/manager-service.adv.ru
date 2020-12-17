<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=lander", 'lander_user', 'PRp26V', [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
} catch (PDOException $e) {
    sendToMM("Невозможно соединиться с БД");
}
if (isset($_REQUEST['token']) && $_REQUEST['token'] == "155f2ebf66e79d248cce9f9da4abda54" && isset($_REQUEST['phone']) && $_REQUEST['phone'] != '') {
    $codes = [900, 901, 902, 903, 904, 905, 906, 907, 908, 909, 910, 911, 912, 913, 914, 915, 916, 917, 918, 919, 920, 921, 922, 923, 924, 925, 926, 927, 928, 929, 930, 931, 932, 933, 934, 935, 936, 937, 938, 939, 940, 941, 942, 943, 944, 945, 946, 947, 948, 949, 950, 951, 952, 953, 954, 955, 956, 957, 958, 959, 960, 961, 962, 963, 964, 965, 966, 967, 968, 969, 970, 971, 972, 973, 974, 975, 976, 977, 978, 979, 980, 981, 982, 983, 984, 985, 986, 987, 988, 989, 990, 991, 992, 993, 994, 995, 996, 997, 998, 999];
    $phone = preg_replace('~\D+~', '', $_REQUEST['phone']);
    $cCode = substr($phone, 0, 1);
    if ($cCode == 7 || $cCode == 8) {
        $phone = substr($phone, 1);
    }
    if (preg_match("/^[0-9]{10,10}+$/", $phone)) {
        if (array_search(substr($phone, 0, 3), $codes) !== false) {
            switch ($_REQUEST['type']) {
                case 'synergy':
                    {
                        $link = $_REQUEST['link'] ?? 'https://goo.gl/fhAz54';
                        $message = "Специалист приемной комиссии свяжется с вами в рабочее время по будням. Подберите программу обучения " . $link;
                        if (date("w", time()) < 6) {
                            $hour = date("G", time());
                            if ($hour >= 9 && $hour < 20) {
                                $message = "Специалист приемной комиссии свяжется с вами в течение 30 минут. Подберите программу обучения " . $link;
                            }
                        }
                        $stmt = $pdo->prepare("INSERT INTO  `smsResponse` (`status`,`phone`,`text`,`response`) VALUES (:st,:ph,:tx,:rs)");
                        $response = json_decode(cURLsend("https://payment.1001tickets.org/devinotelecom/", ["token" => "dc19dc122ccfde866cc4b8ebaef49188", "phone" => $phone, "message" => $message]));
                        $stmt->execute(["st" => $response->status > 0 ? $response->status : 0, "ph" => $phone, "tx" => $message, "rs" => json_encode($response)]);
                        break;
                    }
                case 'territoriyabiznesa':
                    {
                        $message = "Ваша заявка на форум Территория бизнеса принята! Оплатить билет сейчас на сайте: территориябизнеса.рф";
                        $stmt = $pdo->prepare("INSERT INTO  `smsResponse` (`status`,`phone`,`text`,`response`) VALUES (:st,:ph,:tx,:rs)");
                        $response = json_decode(cURLsend("https://payment.1001tickets.org/devinotelecom/", ["token" => "dc19dc122ccfde866cc4b8ebaef49188", "phone" => $phone, "message" => $message]));
                        $stmt->execute(["st" => $response->status > 0 ? $response->status : 0, "ph" => $phone, "tx" => $message, "rs" => json_encode($response)]);
                        break;
                    }
            }
        }
    }
}

function sendToMM($text)
{
    $postData = 'payload=' . json_encode([
            'text' => $text,
            'username' => 'Lander'
        ]);
    $response = cURLsend('https://mm.synergy.ru/hooks/mhki36yjut899qk1bskj6hepna', $postData);
}

function cURLsend($url, $postData)
{
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    if ($postData != false) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
    }
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

?>


