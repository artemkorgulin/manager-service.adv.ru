<?php

$config['ignore']['getresponse'] = false;

$config['user']['sendsuccess'] = "
<div class='send-success'>
  <h3>Спасибо!</h3>
  <p>Вы успешно подписаны.</p>
</div>";

if ($lead->form == "subscribe") {
	$config['ignore']['bitrix'] = false;
	$postData = [
		'email' => $lead->email,
		'name' => $lead->email,
		'id' => $lead->uuid,
		'land' => $lead->land,
		'ip' => $lead->ip,
		'dateCreated' => time(),
		'listId' => 71
	];
	$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$responseEs = curl_exec($curl);
	curl_close($curl);
}