<?php
$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'syn234235syn') {
    echo $challenge;
}

$config = array(
    'host' => 'localhost',
    'name' => 'lander',
    'user' => 'lander_user',
    'password' => 'PRp26V',
    'nametable' => 'facebook_lead'
);

$json = file_get_contents('php://input');
$arr = json_decode($json);

$f = @fopen(dirname(__FILE__) . "/logs/facebookCallback.log", "a+") or ("error");
fputs($f, print_r($arr, true) . "\n");
fclose($f);

$leadgen = $arr->entry[0]->changes[0]->value;

$leadgen_id = $leadgen->leadgen_id;
$form_id = $leadgen->form_id;
$created_time = $leadgen->created_time;
$page_id = $leadgen->page_id;
$lead_data_get = true;
$access_token = "";

/* Curl Request  */
function CurlResponse($url, &$access_token)
{
    $postvars = array(
        "access_token" => "2242869896027279|C-Bf5NLGTKor-pXwN_dEOHubAQk",
    );
    $access_token = $postvars["access_token"];

    $postdata = "";
    foreach ($postvars as $key => $value)
        $postdata .= "&" . rawurlencode($key) . "=" . rawurlencode($value);
    $postdata = substr($postdata, 1);

    $ch = curl_init();
    $separator = "";
    if (strstr($url, '?')) {
        $separator = "&";
    } else {
        $separator = "?";
    }

    curl_setopt($ch, CURLOPT_URL, $url . $separator . $postdata);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


$lead = json_decode(CurlResponse("https://graph.facebook.com/v3.2/" . $leadgen_id, $access_token));

if ($lead->error->code > 0) {
    $lead_data_get = false;
}

$f = @fopen(dirname(__FILE__) . "/logs/facebookCallbackLeadResponse.log", "a+") or ("error");
fputs($f, print_r($lead, true) . "\n");
fclose($f);


$emailNum = 0;

$email = "";
$phone = "";
$name = "";

function availableFields(&$lead, &$emailNum, &$email, &$phone, &$name, &$lead_data_get)
{

    if (preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $lead->field_data[0]->values[0])) {
        $email = $lead->field_data[0]->values[0];
        $emailNum = 1;
    } else if (preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $lead->field_data[1]->values[0])) {
        $email = $lead->field_data[1]->values[0];
        $emailNum = 2;
    } else if (preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $lead->field_data[2]->values[0])) {
        $email = $lead->field_data[2]->values[0];
        $emailNum = 3;
    }

    switch ($emailNum) {
        case 0:

            break;
        case 1:
            if (preg_replace('~\D+~', '', $lead->field_data[1]->values[0]) != '') {
                $phone = $lead->field_data[1]->values[0];
                $name = $lead->field_data[2]->values[0];
            } else {
                $name = $lead->field_data[1]->values[0];
                $phone = $lead->field_data[2]->values[0];
            }
            break;
        case 2:
            if (preg_replace('~\D+~', '', $lead->field_data[0]->values[0]) != '') {
                $phone = $lead->field_data[0]->values[0];
                $name = $lead->field_data[2]->values[0];
            } else {
                $name = $lead->field_data[0]->values[0];
                $phone = $lead->field_data[2]->values[0];
            }
            break;
        case 3:
            if (preg_replace('~\D+~', '', $lead->field_data[0]->values[0]) != '') {
                $phone = $lead->field_data[0]->values[0];
                $name = $lead->field_data[1]->values[0];
            } else {
                $name = $lead->field_data[0]->values[0];
                $phone = $lead->field_data[1]->values[0];
            }
        default:
            break;
    }
    foreach ($lead->field_data as $row) {
        switch ($row->name) {
            case "оставьте_номер_телефона":
                $phone = $row->values[0];
                break;
            case "full_name":
                $name = $row->values[0];
                break;
        }
    }

    $name = str_replace('+', '', $name);
    $name = str_replace('-', '', $name);

    $phone = str_replace('+', '', $phone);
    $phone = str_replace('-', '', $phone);
    $phone = str_replace(' ', '', $phone);
    $phone = preg_replace('~\D+~', '', $phone);
    if (strlen(str_replace(' ', '', $name)) < 3) {
        $name = 'Имя не заполнено';
        $lead_data_get = false;
    }
    if (strlen(str_replace(' ', '', $phone)) < 3) {
        $phone = 'Телефон не заполнен';
        $lead_data_get = false;
    }
    if (strlen(str_replace(' ', '', $email)) < 3) {
        $email = 'e-mail не заполнен';
        $lead_data_get = false;
    }
}

//Валидируем входящие лиды
availableFields($lead, $emailNum, $email, $phone, $name, $lead_data_get);


/*Если данные из фейсбука по лиду не получили пытаемся тащить с нового API списком лиды
  вставлять данные нужного лида, но нужнен переданный параметр формы form_id
*/

if (!$lead_data_get && intval($form_id) > 0) {

    $urlform = "https://graph.facebook.com/v3.2/" . $form_id . "/leads";
    $leads = json_decode(CurlResponse($urlform, $access_token));


    function leadsProcess($leads_list, $access_token, &$name, &$phone, &$email, &$emailNum, &$lead_data_get, &$leadgen_id)
    {
        $leads = $leads_list;
        $finded = false;
        foreach ($leads->data as $i => $rowLine) {
            if ($rowLine->id == $leadgen_id) {
                foreach ($rowLine->field_data as $iProp => $propDataRow) {
                    if ($propDataRow->name == 'full_name') {
                        $name = $propDataRow->values[0];
                    }
                    if ($propDataRow->name == 'phone_number') {
                        $phone = $propDataRow->values[0];
                    }
                    if ($propDataRow->name == 'email') {
                        $email = $propDataRow->values[0];
                    }
                }
                if ($name != "" && $phone != "" && $email != "") {
                    //Ещё раз валидируем лид
                    $finded = true;
                    availableFields($rowLine, $emailNum, $email, $phone, $name, $lead_data_get);
                }
                break;
            }
        }
        if ($finded) return false;

        if (property_exists($leads->paging, "next")) {
            $leads->paging = (array)$leads->paging;
            $leads = json_decode(CurlResponse($leads->paging["next"], $access_token));
            leadsProcess($leads, $access_token, $name, $phone, $email, $emailNum, $lead_data_get, $leadgen_id);
        }
    }


    leadsProcess($leads, $access_token, $name, $phone, $email, $emailNum, $lead_data_get, $leadgen_id);
}


$urlformdata = "https://graph.facebook.com/v2.9/" . $form_id . "?fields=id,name";
$form = json_decode(CurlResponse($urlformdata, $access_token));

$f = @fopen(dirname(__FILE__) . "/logs/facebookCallbackFormData.log", "a+") or ("error");
fputs($f, print_r($form, true) . "\n");
fclose($f);

$formname = $form->name;
try {
    $pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    $stmt = $pdo->query("INSERT INTO `" . $config['nametable'] . "` (`email`,`full_name`,`phone_number`,`leadgen_id`,`page_id`,`form_id`,`created_time`,`formname`) VALUES ('$email','$name','$phone','$leadgen_id','$page_id','$form_id','$created_time','$formname')");
} catch (PDOException $e) {
    $f = @fopen(dirname(__FILE__) . "/logs/error.facebookCallback.log", "a+") or
    ("error");
    fputs($f, date("d:m:Y h:i:s") . 'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage() . '           ' . print_r($arr, true) . "\n");
    fclose($f);
    exit();
}