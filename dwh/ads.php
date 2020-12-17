<?php
$access_token ='EAAJpcDq1RLUBAAdVF2aWg1gM9T3hjZATzmXaTnbN8TMn1WtHJRmaPzkbLDViSpgxzWmKVmUaI1SYei1FHyb8Xz3d8AqSUnDIlSS6bf7fKJkSVvp2pOuZCRPNZB1GdRH8PiiyYjjZC7sxqyKTEJ8c6Odhq6dODJvAO3lWDa5j3gZDZD';
$url = "https://graph.facebook.com/v3.0/act_".$_REQUEST['adId']."?fields=ads{leads{form_id}},leadgen_forms{name}";
$url_with_token = $url . "&access_token=".$access_token;
$ads = json_decode(file_get_contents($url_with_token));
$forms = [];
foreach ($ads->leadgen_forms->data as $row) {
    array_push($forms,$row->name);
}

echo json_encode($forms);

?>