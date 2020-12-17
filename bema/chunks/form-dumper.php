<?php
if (isset($_POST['email'])) {

    if ($f = fopen(__DIR__ . '/dumps/' . $_POST['email'] . '.php', 'w')) {
        //fwrite($f, '<?php return ' . var_export($_POST, true) . ';');
       // fclose($f);

        $response = cURLsend("http://synergy.ru/lander/alm/lander.php",["r"=>"land/index","form"=>"main","unit"=>"bemafestival","land"=>"bemafestival","name"=>$_POST['name'],"email"=>$_POST['email'],"phone"=>$_POST['phone'],"comments"=>print_r($_POST['comments'],true)]);
        fwrite($f, '<?php return ' . print_r($response, true) . ';');
        fclose($f);
        
    }

}


function cURLsend($url,$postData) {
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}