<?php
$config['ignore']['send_to_user'] = false;
$config['ignore']['getresponse'] = false;
$comments = $_REQUEST['comments'];
$postData = [
	'email' 	  => $lead->email, 
	'name'  	  => $lead->name,
	'sId' 		  => 264,
	'tId'  	  	  => 1102,
	'Task' 		  => $comments["Сообщение об ошибке"]
];

$curl = curl_init("https://syn.su/-sd-/api/createTask.php");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($curl);
curl_close($curl);
$config['user']['sendsuccess'] = '
<div class="send-success">
<h3>Спасибо!</h3>
<p>Ваша заявка создана. Логин и пароль придут Вам на почту.</p>
</div>
';
?>