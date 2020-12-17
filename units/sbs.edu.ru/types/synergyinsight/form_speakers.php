<?php
/*
if (isset($_REQUEST['sms_ver']) && $_REQUEST['sms_ver'] != '') {
  	$curl = curl_init("https://syn.su/smsVerify.php");
  	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  	curl_setopt($curl, CURLOPT_POST, 1);
  	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(["token"=>"4c6620bsgjs1c1aa03a4c099387a862e27d3a","code"=>$_REQUEST['sms_ver'],"method"=>"checkCode","mergelead"=>$lead->mergelead]));
  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  	$response = curl_exec($curl);
  	curl_close($curl);
  	if (json_decode($response)->response != '') {
	  	$curl = curl_init("https://my.synergy.ru/api/synergybase/v2/user/");
	  	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	  	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	  	curl_setopt($curl, CURLOPT_HTTPHEADER,
	  	[
	    	'Content-Type: application/x-www-form-urlencoded',
  			'authorization: dCOD4iGzjePn6rHtcpO6'
	    ]);
	  	curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
	  	curl_setopt($curl, CURLOPT_POSTFIELDS, ["source"=>"synergyinsight.ru","LOGIN"=>$lead->email,"NAME"=>$lead->name,"PERSONAL_MOBILE"=>$lead->phone]);
	  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	  	$response = curl_exec($curl);
	  	curl_close($curl);
      if (json_decode($response)->result == 1) {
        $sendsuccess = '<div class="send-success"><h3>Спасибо!</h3><p>Доступ к базе знаний будет отправлен Вам на почту.</p></div>';
      } else {
        $sendsuccess = '<div class="send-success"><h3>Спасибо!</h3><p>Вы уже зарегистрированны в базе знаний.</p></div>';
      } 		
  	} else {
  		$sendsuccess = '<div class="send-success"><h3>Спасибо!</h3><p>Неверный код из SMS.</p></div>';
  	}
} else {
  	$curl = curl_init("https://syn.su/smsVerify.php");
  	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
  	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
  	curl_setopt($curl, CURLOPT_POST, 1);
  	curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode(["token"=>"4c6620bsgjs1c1aa03a4c099387a862e27d3a","phone"=>$lead->phone,"method"=>"createCode","mergelead"=>$lead->mergelead]));
  	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
  	$response = curl_exec($curl);
  	curl_close($curl);
  	if (json_decode($response)->response != '') {
		$sendsuccess = '<div class="screen-1__input-container"><input name="sms_ver" class="form_h__input valid" type="text" placeholder="Код из SMS" required="" aria-required="true" aria-invalid="false"></div><input type="hidden" name="mergelead" value="'.$lead->mergelead.'"><input type="hidden" name="phone" value="'.$lead->phone.'"><input type="hidden" name="email" value="'.$lead->email.'"><input type="hidden" name="name" value="'.$lead->name.'"><div class="screen-10__input-container"><input type="submit" class="screen-10__submit" value="Подтвердить"></div>';
	} else {
		$sendsuccess = '<div class="send-success"><h3>Спасибо!</h3><p>Ваша заявка отправлена.</p></div>';
	}
}*/
$config['user']['sendsuccess'] = '<div class="send-success"><h3>Спасибо!</h3><p>Ваша заявка отправлена.</p></div>';
?>