<?php
$f = fopen("/var/www/syn.su/public/china.log", "a+") or die("error");
fputs($f, date("d:m:Y h:i:s") . file_get_contents('php://input') . "\n");
fclose($f);

$json = json_decode(file_get_contents('php://input'));

foreach ($json as $row) {
    $partner = (isset($row->status) && $row->status == 'archive') ? "kovpakArch" : "kovpak";
    $response = cURLsend("https://syn.su/lander.php?r=land/index&unit=china&type=businessforum&land=china-business-forum&dater=&partner=" . $partner . "&version=&graccount=&grcampaign=&promocode=&form=mainform", ['name' => $row->name, 'phone' => $row->phone, 'email' => $row->email, 'url' => 'https://chinabusinessforum.ru/?utm_content=' . $row->utm->utm_content . '&utm_medium=' . $row->utm->utm_medium . '&utm_campaign=' . $row->utm->utm_campaign . '&utm_term=' . $row->utm->utm_term . '&utm_source=' . $row->utm->utm_source, 'comments' => '30 минут ковпак']);

}
echo json_encode(["error" => null, "response" => "ok"]);

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