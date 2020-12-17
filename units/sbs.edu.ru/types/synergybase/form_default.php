<?php
if (isset($_REQUEST['graccount']) && $_REQUEST['graccount'] == 'synergy' && isset($_REQUEST['grcampaign']) && $_REQUEST['grcampaign'] == 'e_mail_chain_bz3') {
	$postData = [
		'email' 	  => $lead->email, 
		'name'  	  => $lead->name,
		'id' 		  => $lead->uuid,
		'land'  	  => $lead->land,
		'ip' 		  => $lead->ip,
		'dateCreated' => time(),
		'listId'	  => 13
	];
	$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
}
if ($lead->land == 'synergybase' || $lead->land =='synergybase_intensive') {

	if ($lead->land =='synergybase_intensive') {
		$config['user']['sendsuccess'] = "<div class='send-success'>
		<h3>Заявка успешно отправлена!</h3>
		<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
		</div><script>$.ajax({
			'url': 'https://synergybase.ru/ajax/',
			'method': 'POST',
			'data': {
				action: 'add_user',
				email:  '".$lead->email."',
				name:  '".$lead->name."',
				phone:  '".$lead->phone."'
				},
			})</script>";
		}
		$config['ignore']['getresponse']    = false;
		$config['newsletter']['getresponse']['account']  = 'synergy';
		$config['newsletter']['getresponse']['campaign'] = 'e_mail_chain_bz3';
		$postData = [
			'email' 	  => $lead->email, 
			'name'  	  => $lead->name,
			'id' 		  => $lead->uuid,
			'land'  	  => $lead->land,
			'ip' 		  => $lead->ip,
			'dateCreated' => time(),
			'listId'	  => 13
		];
		$curl = curl_init("https://syn.su/worker/daemon-expertsender.php");
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($curl);
		curl_close($curl);
		if ($lead->form == 'register-popup' || $lead->form == 'end' || $_REQUEST['packages'] == 'nodemo') {
//			if ($lead->land !='synergybase_intensive') {
//				$config['ignore']['send_to_user'] = false;
//				$config['user']['sendsuccess'] = "
//				<script>
//				location.href='https://synergybase.ru/packages/?name={$_REQUEST['name']}&email={$_REQUEST['email']}&mergelead={$_REQUEST['mergelead']}&t_clead=".time()."&packages=nodemo';
//				</script>
//				";	
//			}
		}  else if ($lead->form == 'registration-base') {
			$config['ignore']['send_to_user'] = false;
			$config['user']['sendsuccess'] = "
			<script>
			location.href='https://synergybase.ru/courses/synergy-women-forum-iskusstvo-byt-pervoy/?name={$_REQUEST['name']}&email={$_REQUEST['email']}&mergelead={$_REQUEST['mergelead']}&t_clead=".time()."&packages=nodemo';
			</script>
			";
		}
	} else if ($lead->land == 'synergybase2') {
		$productCount = 1;
		if (isset($_REQUEST['product_count']) && $_REQUEST['product_count'] > 1) {
			$productCount = $_REQUEST['product_count'];
		}
		if (isset($_REQUEST['radio']) && $_REQUEST['radio'] > 0) {
			$config['user']['sendsuccess'] = '
			<script>
			$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email='.$_REQUEST['email'].'&price='.$_REQUEST['radio']*$productCount.'&name='.$_REQUEST['name'].'&message=&land='.$lead->land.'&form='.$lead->form.'&mergelead='.$_REQUEST['mergelead'].'&product_count='.$productCount.'", {type:"iframe"})
			$.fancybox.update();
			</script>';
		} else {
			$config['user']['sendsuccess'] = "<div class='send-success'>
			<h3>Заявка успешно отправлена!</h3>
			<p>Cпасибо, мы свяжемся с вами в ближайшее время. </p>
			</div>";
			if (isset($_REQUEST['cost'])) {
				if ($_REQUEST['cost'] == 0) {

					$postData = [
						'Name' 			=> $lead->name,
						'Token'			=> '',
						'Email'			=> $lead->email,
						'AccountId'		=> $lead->email,
						'TransactionId' => '',
						'InvoiceId'		=> $lead->mergelead,
						'PaymentAmount' => 0
					];

					$response = cURLsend("https://payment.1001tickets.org/cloudpayments/obkc-rec/pay.php",$postData);

					$config['user']['sendsuccess'] = 	
					"<div class='send-success'>
					<h3>Заявка успешно отправлена!</h3>
					<p>Доступ к базе знаний отправлен Вам на электронную почту. Письмо придет в течение 10 минут</p>
					</div>";
				} else {
					$config['user']['sendsuccess'] = '
					<script>
					$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email='.$_REQUEST['email'].'&price='.$_REQUEST['cost']*$productCount.'&name='.$_REQUEST['name'].'&message=&land='.$lead->land.'&form='.$lead->form.'&mergelead='.$_REQUEST['mergelead'].'&product_count='.$productCount.'", {type:"iframe"})
					$.fancybox.update();
					</script>';
				}
			} elseif (isset($_REQUEST['baseprice'])) {
				if ($_REQUEST['baseprice'] == 0) {

					$postData = [
						'Name' 			=> $lead->name,
						'Token'			=> '',
						'Email'			=> $lead->email,
						'AccountId'		=> $lead->email,
						'TransactionId' => '',
						'InvoiceId'		=> $lead->mergelead,
						'PaymentAmount' => 0
					];

					$response = cURLsend("https://payment.1001tickets.org/cloudpayments/obkc-rec/pay.php",$postData);

					$config['user']['sendsuccess'] = 	
					"<div class='send-success'>
					<h3>Заявка успешно отправлена!</h3>
					<p>Доступ к базе знаний отправлен Вам на электронную почту. Письмо придет в течение 10 минут</p>
					</div>";
				} else {
					$discount = 0;
					if (isset($_REQUEST['discount']) && $_REQUEST['discount'] != 0) {
						$discount = $_REQUEST['discount'];
					}
					$baseprice = $_REQUEST['baseprice']*$productCount;
					if ($discount > 0) {
						$baseprice = $baseprice-(($baseprice*$discount)/100);
					}
					if (true) {
						$config['user']['sendsuccess'] = json_encode(["result"=>1,"data"=>["url"=>'https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email='.$_REQUEST['email'].'&price='.$baseprice.'&name='.$_REQUEST['name'].'&message=&land='.$lead->land.'&form='.$lead->form.'&mergelead='.$_REQUEST['mergelead'].'&product_count='.$productCount]]);
					} else {
						$config['user']['sendsuccess'] = '
						<script>
						$.fancybox("https://payment.1001tickets.org/cloudpayments/obkc-rec/card/card.php?email='.$_REQUEST['email'].'&price='.$baseprice.'&name='.$_REQUEST['name'].'&message=&land='.$lead->land.'&form='.$lead->form.'&mergelead='.$_REQUEST['mergelead'].'&product_count='.$productCount.'", {type:"iframe"})
						$.fancybox.update();
						</script>';
					}
				}
			}
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