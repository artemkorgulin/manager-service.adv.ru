<?php
header('Access-Control-Allow-Origin: *');  
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0", false);
header("Pragma: no-cache");
header('Content-Type: text/html; charset=utf-8');


$config = array(
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V',
    'nametable'  => 'payments',
    'tablepromo' => 'promocode'
);

$configMail = array(
	'host' 	   	 => 'localhost',
	'SMTPAuth' 	 => false,
	'username' 	 => '',
	'password' 	 => '',
	'SMTPSecure' => false,
	'port' 		 => 25,
	'from' 		 => 'notice@sbs.edu.ru',
	'charset' 	 => 'UTF-8' 
);

try {
	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	if (isset($_COOKIE['redirectUserPay'])) {
		$url = "Location: ".$_COOKIE['redirectUserPay'];
		unset($_COOKIE['redirectUserPay']);
    	setcookie('redirectUserPay', null, -1, '/');
		header($url);
		exit();
	}

	$shopId 	     = isset($_REQUEST['shopId'])		 	 ? htmlspecialchars($_REQUEST['shopId'])	   		: "";
	$price  	     = isset($_REQUEST['price'])	 	 	 ? htmlspecialchars($_REQUEST['price'])  	   		: "";
	$email  	     = isset($_REQUEST['email'])	   	 	 ? htmlspecialchars($_REQUEST['email'])		   		: "";
	$productName     = isset($_REQUEST['productName'])  	 ? htmlspecialchars($_REQUEST['productName'])  		: "";
	$userName  	   	 = isset($_REQUEST['username'])     	 ? htmlspecialchars($_REQUEST['username'])	   		: "";
	$phone 		   	 = isset($_REQUEST['phone'])     	 	 ? htmlspecialchars($_REQUEST['phone'])		   		: "";
	$comments 	     = isset($_REQUEST['comments'])     	 ? htmlspecialchars($_REQUEST['comments'])	   		: "";
	$orderId 	   	 = isset($_REQUEST['orderId'])		 	 ? htmlspecialchars($_REQUEST['orderId'])      		: "";
	$land  		     = isset($_REQUEST['land'])		 	 	 ? htmlspecialchars($_REQUEST['land'])		   		: "";
	$form 		  	 = isset($_REQUEST['form'])		 	 	 ? htmlspecialchars($_REQUEST['form'])		   		: "";
	$contractNum   	 = isset($_REQUEST['contractNum'])  	 ? htmlspecialchars($_REQUEST['contractNum'])  		: "";
	$graccount     	 = isset($_REQUEST['gra'])  		 	 ? htmlspecialchars($_REQUEST['gra']) 		   		: "";
	$graccount2    	 = isset($_REQUEST['gra2'])  		 	 ? htmlspecialchars($_REQUEST['gra2']) 		   		: "";
	$grcampaign    	 = isset($_REQUEST['grc'])   		 	 ? htmlspecialchars($_REQUEST['grc']) 		   		: "";
	$grcampaign2   	 = isset($_REQUEST['grc2'])   		 	 ? htmlspecialchars($_REQUEST['grc2']) 		   		: "";
	$type  		   	 = isset($_REQUEST['type'])		 	 	 ? htmlspecialchars($_REQUEST['type'])		   		: "";
	$mergelead     	 = isset($_REQUEST['mergelead'])	 	 ? htmlspecialchars($_REQUEST['mergelead'])	   		: "";
	$httpreferer   	 = isset($_REQUEST['httpreferer'])       ? htmlspecialchars($_REQUEST['httpreferer'])  		: "";
	$additionally    = isset($_REQUEST['additionally']) 	 ? $_REQUEST['additionally'] 				   	   	: "";
	$productId	   	 = isset($_REQUEST['productId'])	 	 ? $_REQUEST['productId']					   	   	: "";
	$urlredirect     = isset($_REQUEST['postpayredirect']) 	 ? htmlspecialchars($_REQUEST['postpayredirect'])  	: "";
	$invoicestatus   = isset($_REQUEST['invoicestatus'])	 ? htmlspecialchars($_REQUEST['invoicestatus'])  	: "";
	$promocode	     = isset($_REQUEST['promo'])			 ? htmlspecialchars($_REQUEST['promo'])				: "";
	$lang	       	 = isset($_REQUEST['lang'])			 	 ? htmlspecialchars($_REQUEST['lang'])				: "";
	$merchantReceipt = isset($_REQUEST['merchantReceipt']) 	 ? htmlspecialchars($_REQUEST['merchantReceipt']) : "";
		
	if (isset($_REQUEST['invoicepayment'])) {

		require 'modules/blockurl_intellectmoneyPay.php';

		if ($orderId == "") {
			$orderId = $shopId.time();
		}

		$productName = mb_convert_encoding($productName, 'utf-8', mb_detect_encoding($productName));

		$userName    = mb_convert_encoding($userName, 'utf-8', mb_detect_encoding($userName));

		$form = (isset($form) && $form != '' && $form !='undefined') ? trim($form) : '';

		$prefix = '';
		
		$name_postfix = '';

		switch ($form) {
			case 'shbs' : 
		    	$prefix = 'ШБС: ';
		     	break;
		    default :
		    	if (isset($contractNum) && $contractNum != '' && $contractNum != 'undefined') {
		    		if ($lang !='en') {
		    			$contract = 'Договор';
		    		} else {
		    			if ($comments !='') {
		    				$contract .='Ordering customer: '.$comments.' :';
		    			}
		    			$contract .= ' Contract';
		    		}
		  	    	$name_postfix = ': '.$contract.' № ' . trim(strip_tags($contractNum));
		  	  	}
		      	break;
  		}	

  		if ($productName == '' && $type != 'sbs') {
  			$productName = $prefix.' Оплата счета №'.$orderId;
  		}

  		if ($name_postfix != '' && $type != 'sbs') {
  			$productName = $userName ." || ". $productName ." || ".$name_postfix;
  		} else if ($type != 'sbs') {
  			$productName = $userName." || ".$productName;
  		}

  		if ($grcampaign != '') {
  			$comments .= " Аккаунт GR:".$graccount." || Кампания GR:".$grcampaign;
  			if ($grcampaign2 != '') {
  				$comments .= " Аккаунт GR 2:".$graccount2." || Кампания GR 2:".$grcampaign2;
  			}
  		}

  		if ($land == 'synergyartclub') {
  			$price *= $comments;
  		}

  		if ($urlredirect != "") {
			$comments = $urlredirect;
			setcookie('redirectUserPay',$urlredirect.'?name='.$userName.'&email='.$email);
		} 

		switch ($type) {
			case 'timepadspain': {
				if ($mergelead != '') {
	  				$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$mergelead."'")->fetchAll();
					foreach ($stmt as $row) {
						if (isset($stmt[0]['date_order'])) {
			  				$datetime = $stmt[0]['date_order'];
			  				$nowdate  = time();
			  				if ($nowdate > ($datetime + 86400)) {
			  					$url = 'Location: http://sgf2017.com/';		
			  				} else {
			  					$url = 'Location: '.$row['comments'];
			  				}
			  			}
			  			header($url);
						exit();
					}
  				}
			}

			case 'superticket': {
				if ($mergelead != '') {
	  				$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$mergelead."'")->fetchAll();
					foreach ($stmt as $row) {
						if (isset($stmt[0]['date_order'])) {
			  				$datetime = $stmt[0]['date_order'];
			  				$nowdate  = time();
			  				if ($nowdate > ($datetime + 86400)) {
			  					$url = 'Location: '.$row['httpreferer'];		
			  				} else {
			  					$url = 'Location: '.$row['comments'];
			  				}
			  			}
			  			header($url);
						exit();
					}
  				}
			}
		
			default: {
		  		if ($mergelead != "") {
		  			$stmt = $pdo->query("SELECT id,date_create,mergelead FROM `".$config['nametable']."` where mergelead = '".$mergelead."'")->fetchAll();
		  			$promocode_id = 0;
		  			if ($promocode != '') {
		  				$stmtpromo = $pdo->query("SELECT * FROM `".$config['tablepromo']."` where promocode = '".$promocode."'")->fetchAll();
		  				if (isset($stmtpromo[0]['id'])) { 
		  					if ($stmtpromo[0]['used'] == 0) {
		  						if ($land == 'sadovod') {
		  							if ($row['promocode_id'] == 151) {
			  							if ($price == 5000 || $price == 7500) {
			  								$price = $price - ($stmtpromo[0]['discount'] * $price) / 100;
			  							} else if ($price == 3500) {
			  								$price = $price - (($stmtpromo[0]['discount'] * 2) * $price) / 100;
			  							}
		  							} else {
		  								if ($price == 3500) {
		  									$price = $stmtpromo[0]['discount'];
		  								}
		  							}
		  						} else {
		  							$price = $price - ($stmtpromo[0]['discount'] * $price) / 100;
		  						}
		  						$promocode_id = $stmtpromo[0]['id'];
		  					} 
		  				}
		  			}
		  			if (isset($stmt[0]['date_create'])) {
		  				$datetime = explode(' ',$stmt[0]['date_create']);
		  				$date 	  = explode('-',$datetime[0]);
		  				$nowdate  = explode('-',date("Y-m-d"));

		  				if ((($date[2] + 6) < $nowdate[2] || $date[2] == $nowdate[2]) && ($date[1] == $nowdate[1] && $date[0] == $nowdate[0])) {
		  					$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`orderId`,`userName`,`price`,`status`,`detail`,`comments`,`phone`,`userEmail`,`productName`,`shopId`,`land`,`form`,`mergelead`,`httpreferer`,`type`,`product_id`,`promocode_id`) VALUES ('$orderId','$userName','$price','1','Создан номер заказа','$comments','$phone','$email','$productName','$shopId','$land','$form','$mergelead','$httpreferer','$type','$productId','$promocode_id')");
		  					
		  					$productName = urlencode($productName);
			  				$userName = urlencode($userName);
							$url = "Location: https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=$shopId&LMI_PAYMENT_AMOUNT=$price&Mail=$email&EMAIL=$email&LMI_PAYMENT_DESC=$productName&LMI_PAYMENT_NO=$orderId&nameuser=$userName&comments=$comments&phoneuser=$phone&landname=$land&gra=$graccount&gra2=$graccount2&grc=$grcampaign&grc2=$grcampaign2&preference=bankCard";
							if ($urlredirect != "") {
					  			$url .= '&LMI_SUCCESS_URL=https://synergy.ru/lander/alm/intellectmoneyPay.php';
					  		}
					  		if ($merchantReceipt != "") {
					  			switch ($shopId) {
					  				case '456318':
					  					$url .= '&merchantReceipt={"inn":"7708142686","group":"Main","content":{"type":1,"positions":[{"quantity":1.000,"price":'.$price.',"tax":6,"text":"'.substr($productName,0,127).'"}],"customerContact":"'.$email.'"}}';
					  					exit();
					  					break;	
					  				default:
					  					break;
					  			}
					  		}
							header($url);
							exit();
		  				} else {
		  					$url = "Location: ".$httpreferer;
							header($url);
							exit();
		  				}		
		  			} else {
			  			$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`orderId`,`userName`,`price`,`status`,`detail`,`comments`,`phone`,`userEmail`,`productName`,`shopId`,`land`,`form`,`mergelead`,`httpreferer`,`type`,`product_id`,`promocode_id`) VALUES ('$orderId','$userName','$price','1','Создан номер заказа','$comments','$phone','$email','$productName','$shopId','$land','$form','$mergelead','$httpreferer','$type','$productId','$promocode_id')");
			  			
			  			$productName = urlencode($productName);
			  			$userName = urlencode($userName);

						$url = "Location: https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=$shopId&LMI_PAYMENT_AMOUNT=$price&Mail=$email&EMAIL=$email&LMI_PAYMENT_DESC=$productName&LMI_PAYMENT_NO=$orderId&nameuser=$userName&comments=$comments&phoneuser=$phone&landname=$land&gra=$graccount&gra2=$graccount2&grc=$grcampaign&grc2=$grcampaign2&preference=bankCard";
						if ($urlredirect != "") {
					  		$url .= '&LMI_SUCCESS_URL=https://synergy.ru/lander/alm/intellectmoneyPay.php';
					  	}
					  	if ($merchantReceipt != "") {
					  		switch ($shopId) {
					  			case '456318':
					  				$url .= '&merchantReceipt={"inn":"7708142686","group":"Main","content":{"type":1,"positions":[{"quantity":1.000,"price":'.$price.',"tax":6,"text":"'.substr($productName,0,127).'"}],"customerContact":"'.$email.'"}}';
					  				exit();
					  				break;
					  				
					  			default:
					  				break;
					  		}
					  	}
						header($url);
						exit();
		  			}
		  		} else {
			  		$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`orderId`,`userName`,`price`,`status`,`detail`,`comments`,`phone`,`userEmail`,`productName`,`shopId`,`land`,`form`,`mergelead`,`httpreferer`,`type`,`product_id`) VALUES ('$orderId','$userName','$price','1','Создан номер заказа','$comments','$phone','$email','$productName','$shopId','$land','$form','$mergelead','$httpreferer','$type','$productId')");
			  		$productName = urlencode($productName);
			  		$userName = urlencode($userName);

					$url = "Location: https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE=$shopId&LMI_PAYMENT_AMOUNT=$price&Mail=$email&EMAIL=$email&LMI_PAYMENT_DESC=$productName&LMI_PAYMENT_NO=$orderId&nameuser=$userName&comments=$comments&phoneuser=$phone&landname=$land&gra=$graccount&gra2=$graccount2&grc=$grcampaign&grc2=$grcampaign2&preference=bankCard";
					if ($urlredirect != "") {
					  	$url .= '&LMI_SUCCESS_URL=https://synergy.ru/lander/alm/intellectmoneyPay.php';
					}			
					if ($merchantReceipt != "") {
						switch ($shopId) {
							case '456318':
								$url .= '&merchantReceipt={"inn":"7708142686","group":"Main","content":{"type":1,"positions":[{"quantity":1.000,"price":'.$price.',"tax":6,"text":"'.substr($productName,0,127).'"}],"customerContact":"'.$email.'"}}';
								exit();
								break;			
						  	default:
						  		break;
						}	
			  		}
					header($url);
					exit();
				}
			}
		}
		exit();
	}

	if (isset($_REQUEST['inBitrixOnly'])) {
		$users = '';
		$info  = '';

		if ($additionally != '') {
			$json  = json_decode($additionally);
			$users = $json->users; 
			$info  = $json->info;
		}

		$ticketinfo = '';

		if (isset($json->addTicketInfo) && $json->addTicketInfo != '') {
			$ticketinfo = $json->addTicketInfo;
		}

		foreach ($users as $user) {
			$ticketinfo .= '<br>'.$user->ticketInfo.' ID билета: '.$user->seatId;
		}

		$postUsers = array(
			'phone'		     => $phone,
			'email'		     => $email,
			'NAME'		     => $userName,
			'sourceName'     => 'WEB',
			'mergelead'      => $mergelead,
		 	'ticketinfo'     => $ticketinfo,
			'ticketamount'   => $price
		);

		$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postUsers);
		$json = json_decode($response);
		if (isset($json->dealid)) {
			echo 'bitrixOK';
			$stmtupdate = $pdo->query("UPDATE `".$config['nametable']."` SET `deal_id` = '".$json->dealid."' WHERE `mergelead` = '".$mergelead."'"); 
		}
		exit();
	}

	if (isset($_REQUEST['fileupload'])) {
		if (is_dir('superticket/timepadspain/~~uploadsAlignment/'.$_REQUEST['fileupload'])) {
			echo 'Файл уже загружен';
			exit();
		}
		if (isset($_REQUEST['addfiles'])) {
			$allowed = array('pdf');
			if(isset($_FILES[0]) && $_FILES[0]['error'] == 0) {
				$extension = pathinfo($_FILES[0]['name'], PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $allowed)){
					echo 'error_extension';
					exit();
				}
				$file = $_FILES[0];
				if(!is_dir("superticket/timepadspain/~~uploadsAlignment/".$_REQUEST['fileupload'])) {
					mkdir("superticket/timepadspain/~~uploadsAlignment/".$_REQUEST['fileupload'] , 0777, true);
				}
				if(is_uploaded_file($file['tmp_name'])){
					$fname = $_FILES[0]['name'];
					move_uploaded_file($file['tmp_name'],"superticket/timepadspain/~~uploadsAlignment/".$_REQUEST['fileupload']."/".$fname);
				}
			}

			$response = cURLsend('http://stp.sgf2017.com:8080/order.discountUpload?mergelead='.$_REQUEST['fileupload'], false);
			$jsontimepad = json_decode($response);
												
			if ($jsontimepad->error == false) {
				echo "uploadok";
			}
			
			exit();
		}
		echo include 'superticket/timepadspain/modules/file_upload.php';
		
		exit();
	}

	if (isset($_REQUEST['ticketsupload']) && $_REQUEST['ticketsupload'] != '') {
		if (isset($_REQUEST['addTicketets'])) {
			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$_REQUEST['ticketsupload']."'")->fetchAll();
			foreach ($stmt as $row) {
				$response = cURLsend('http://stp.sgf2017.com:8080/send.ok?mergelead='.$row['mergelead'], false);
				$jsontimepad = json_decode($response);							
			    if ($jsontimepad->error == false) {
					echo 'uploadOK';
					require_once ('/var/www/syn.su/public/worker/new_daemons/lib/PHPMailer/PHPMailerAutoload.php');
					$message 	 	= include 'superticket/timepadspain/letters/ticketsend_clientRUS.php'; 
					$additionally 	= $row['additionally'];
					$json 			= json_decode($additionally);
					$managers 	 	= $json->managers;
					$email_regional = $managers->regional->email;
					$name_regional  = $managers->regional->name;
					$email_manager  = $managers->manager->email;
					$name_manager   = $managers->manager->name; 
					if ($json->lang != 'ru') {
						$message 	= include 'superticket/timepadspain/letters/ticketsend_clientENG.php'; 
					}

					$mailer = new PHPMailer;
				    $mailer->isSMTP();                                         
					$mailer->Host         = $configMail['host'];
					$mailer->SMTPAuth     = $configMail['SMTPAuth'];                               
					$mailer->Username     = $configMail['username'];  
					$mailer->Password     = $configMail['password'];  
					$mailer->SMTPSecure   = $configMail['SMTPSecure'];  
					$mailer->Port         = $configMail['port'];
					$mailer->From         = $configMail['from'];
				    $mailer->FromName     = 'SGF 2017';
				    $mailer->CharSet      = $configMail['charset'];
				    $mailer->isHTML(true);                                                
				    $mailer->addAddress($row['userEmail']);
				    $mailer->Subject      = 'Билеты на SGF 2017';
				    $mailer->Body         = $message;
				    $mailer->addBCC($email_regional);
                    $mailer->addBCC('7200@synergy.ru');
				    $files = scandir('superticket/timepadspain/~~uploads/'.$row['mergelead'].'/');
				    foreach ($files as $file) {
				    	$mailer->addAttachment('superticket/timepadspain/~~uploads/'.$row['mergelead'].'/'.$file);  
				    }
					$mailer->send();

					$postData = array(
						'mergelead' 	   => $row['mergelead'],
						'ticketdealstatus' => '1'
					);
					
					$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);
				} 
				exit();
			}
			exit();
		}
		if (isset($_REQUEST['startId'])) {
			$allowed = array('pdf');
			if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
				$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
				if(!in_array(strtolower($extension), $allowed)){
					echo '{"status":"error"}';
					exit();
				}
				$file = $_FILES['upl'];
				if(!is_dir("superticket/timepadspain/~~uploads/".$_REQUEST['ticketsupload'])) {
					mkdir("superticket/timepadspain/~~uploads/".$_REQUEST['ticketsupload'] , 0777, true);
				}
				if(is_uploaded_file($file['tmp_name'])) {
					$fname =$_FILES['upl']['name'];
					move_uploaded_file($file['tmp_name'],"superticket/timepadspain/~~uploads/".$_REQUEST['ticketsupload']."/".$fname);
				}
			}
			echo '{"status":"success"}';
			$stmtupd = $pdo->query("UPDATE `".$config['nametable']."` SET `tickets` = '1' WHERE `mergelead` = '".$_REQUEST['ticketsupload']."'"); 
			exit();
		}
		$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$_REQUEST['ticketsupload']."'")->fetchAll();
		foreach ($stmt as $row) {
			echo include 'superticket/timepadspain/modules/ticket_upload.php';
			exit();
		}
		exit();
	}
	if (isset($_REQUEST['timepadspain'])) {
		if (isset($_REQUEST['extendticket'])) {
			if (isset($_REQUEST['orders'])) {
				$orders = json_decode($_REQUEST['orders']);
				foreach ($orders as $order) {
					$stmtselect = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$mergelead."'")->fetchAll();
					foreach ($stmtselect as $row) {
						switch ($row['type']) {
							case 'timepadspain':
								$email_regional   = $order->managers->regional->email;
								$email_manager	  = $order->managers->manager->email;
								$full 		      = 'Имя: '.$order->full->name.'<br> Email: '.$order->full->email.'<br> Телефон: '.$order->full->phone.'<br> ID лида: '.$order->full->crm_leadId.'<br> ID сделки: '.$order->full->crm_dealId.'<br> ID счета: '.$order->full->crm_orderId.'<br> Время окончания брони: '.date('Y-m-d h:i:s', strtotime($order->full->booked_end));
								$prolongLink  	  = 'https://synergy.ru/lander/alm/intellectmoneyPay.php?timepadspain&link&prolongorder='.$order->mergelead;
								$cancelLink 	  = 'https://synergy.ru/lander/alm/intellectmoneyPay.php?timepadspain&cancelorder='.$order->mergelead;
								$message_regional = include 'superticket/timepadspain/letters/messagecancle_regional.php'; 
								$message_manager  = include 'superticket/timepadspain/letters/messagecancle_manager.php'; 
								sendMail('Необходимо продлить бронь',$message_regional,$email_regional,'','');
								sendMail('Необходимо продлить бронь',$message_manager,$email_manager,'','');
								break;
							default:
								break;
						}
					}
				}
				echo "ok";
				exit();
			}
			exit();
		}
		if (isset($_REQUEST['cancelorder']) && $_REQUEST['cancelorder'] != '') {
			if (isset($_REQUEST['update'])) {
				if (isset($_REQUEST['status'])) {
					$stmtupd = $pdo->query("UPDATE `".$config['nametable']."` SET `date_order` = '0', `status_code` = '".$_REQUEST['status']."' WHERE `mergelead` = '".$_REQUEST['cancelorder']."'"); 

					$postData = array(
						'mergelead' 		=> $_REQUEST['cancelorder'],
						'ticketdealstatus'	=> '-1'
					);
									
					$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);

					echo "ok";
					exit();
				}
			}

			$response = cURLsend('http://stp.sgf2017.com:8080/order.cancel?mergelead='.$_REQUEST['cancelorder'], false);
			$json = json_decode($response);
												
			if ($json->error == false) {
				echo $json->success;
			} else {
				echo $json->errorMessage;
			}
			exit();
		}

		if (isset($_REQUEST['prolongorder']) && $_REQUEST['prolongorder'] != '') {
			if (isset($_REQUEST['link'])) {

				$response = cURLsend('http://stp.sgf2017.com:8080/order.prolongate?mergelead='.$_REQUEST['prolongorder'], false);
				$json = json_decode($response);
												
				if ($json->error == false) {
					echo $json->success;
				} else {
					echo $json->errorMessage;
				}
				exit();
			}
			$date = time() + 86400;
			$stmtupd = $pdo->query("UPDATE `".$config['nametable']."` SET `date_order` = '".$date."' WHERE `mergelead` = '".$_REQUEST['prolongorder']."'"); 
			echo 'ok';
			exit();
		}
		if (isset($_REQUEST['crm']) && $_REQUEST['crm'] == true && $mergelead != '') {

			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$mergelead."'")->fetchAll();
			if (isset($stmt[0]['date_create'])) {
				foreach ($stmt as $row) {
					if ($row['status'] != 2) {
						$stmtupd = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '2',`date_pay` = now() ,`detail` = 'Заказ успешно оплачен' WHERE `mergelead` = '".$mergelead."'"); 
					}
					echo $mergelead;

					switch ($row['type']) {
						case 'timepadspain':
					
							$additionally 	= $row['additionally'];
							$json 			= json_decode($additionally);
							$managers 	    = $json->managers;
							$email_manager  = $managers->manager->email;
							$name_manager   = $managers->manager->name; 
							$email_regional = $managers->regional->email;
							$name_regional  = $managers->regional->name;
							$users 	  	    = $json->users; 

							$ticketinfo = '';
							foreach ($users as $user) {
								$ticketinfo .= '<br>'.$user->ticketInfo.' ID билета: '.$user->seatId;
							}

							$message 		  = include 'superticket/timepadspain/letters/uploadticket_manager.php'; 
							$message_regional = include 'superticket/timepadspain/letters/uploadticket_regional.php'; 
							$message_client   = include 'superticket/timepadspain/letters/uploadticket_clientRUS.php';
							if ($json->lang != 'ru') {
								$message_regional = include 'superticket/timepadspain/letters/uploadticket_regionalENG.php'; 
								$message_client   = include 'superticket/timepadspain/letters/uploadticket_clientENG.php';
							}

							$subject = 'Произведена оплата по счету '.$row['orderId'];

							sendMail($subject,$message,$email_manager,'','');						
							sendMail($subject,$message_regional,$email_regional,'','');
							sendMail($subject,$message_client,$row['userEmail'],'','');

							if (isset($_REQUEST['invoicestatus'])) {
				
							 	$response = cURLsend('http://stp.sgf2017.com:8080/sale.ok?mergelead='.$row['mergelead'], false);
							 	$json = json_decode($response);
															
								if ($json->error != false) {
									$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '4', `detail` = 'Произошла ошибка', `errors` = '".$response."' WHERE `orderId` = '".$_REQUEST['LMI_PAYMENT_NO']."'"); 
								}							
							}
							exit();
					}
				}
			} else {
				$postData = array(
					'method' 	 	 => 'getOrderInfo',
					'mergelead'		 => $mergelead
				);
				$response = cURLsend('https://payment.1001tickets.ru/', $postData);
				if ($response !='') {
					$json = json_decode($response);
						$postData = array(
							'method' 	 => 'updateOrderStatus',
							'api_token'  => '',
							'auth_token' => '',
							'orderId'	 => $json->orderId,
							'status'	 => '4'
						);
										
						$postData = http_build_query($postData);
						$response = cURLsend('https://api.1001tickets.ru/events/'.$json->event, $postData);

						$postData = array(
							'method' 	 	 => 'updateAdditionally',
							'orderId'		 => $json->orderId,
							'additionally'	 => json_encode(array('mergelead' => array('name' => 'mergelead', 'value' => $json->mergelead)))
						);
											
						$postData = http_build_query($postData);
						$response = cURLsend('https://api.1001tickets.ru/events/'.$json->event, $postData);
						exit();
				}
			}
			exit();
		}
		if ($price != '' && $shopId != '' && $email != '' && $mergelead != '' && $userName != '') {
			$orderId      = $shopId.time();
			$productName  = $userName." || ".$productName;
			$productName .= ' ---';
			$type 		  = 'timepadspain';
			$users 	   	  = '';
			$info 	  	  = '';
			$managers 	  = '';
			$leadId   	  = '';
			$companyName  = '';
			$lang 		  = '';

			if ($additionally != '') {
				$json 	  	 = json_decode($additionally);
				$users 	  	 = $json->users; 
				$info  	  	 = $json->info;
				$managers 	 = $json->managers;
				$leadId      = $json->leadId;
				$companyName = $json->companyName;
				$lang 	 	 = $json->lang;
			}

			$comments = 'https://merchant.intellectmoney.ru/?LMI_PAYEE_PURSE='.$shopId.'&LMI_PAYMENT_AMOUNT='.$_REQUEST['priceRUB'].'&Mail='.$email.'&EMAIL='.$email.'&LMI_PAYMENT_DESC='.$productName.'&type='.$type.'&LMI_PAYMENT_NO='.$orderId.'&nameuser='.$userName.'&phoneuser='.$phone.'&landname='.$land.'&preference=bankCard';

			if ($httpreferer != '') {
				$comments .= '&LMI_SUCCESS_URL='.$httpreferer;
			}

			$url = 'https://synergy.ru/lander/alm/intellectmoneyPay.php?invoicepayment&type='.$type.'&mergelead='.$mergelead;

			if ($shopId != 'invoice') {
				$price = $_REQUEST['priceRUB'];
			}

			$stmt = $pdo->query("INSERT INTO `".$config['nametable']."` (`orderId`,`userName`,`price`,`status`,`detail`,`comments`,`phone`,`userEmail`,`productName`,`shopId`,`land`,`form`,`mergelead`,`httpreferer`,`additionally`,`type`,`product_id`,`date_order`) VALUES ('$orderId','$userName','$price','1','Создан номер заказа','$comments','$phone','$email','$productName','$shopId','$land','$form','$mergelead','$httpreferer','$additionally','$type','$productId','".time()."')");

			require_once ('/var/www/syn.su/public/worker/new_daemons/lib/PHPMailer/PHPMailerAutoload.php');
			
			$email_regional = $managers->regional->email;
			$name_regional  = $managers->regional->name;
			$email_manager  = $managers->manager->email;
			$name_manager   = $managers->manager->name; 
			
			$priceСonversion = 0;
			$priceСonversion = ($price * 3) / 100;
			$priceFinal 	 = $price;

			if ($shopId == 'invoice') {

				$tickets 	= '';
				$ticketsNum = 0;

				$economCategoryTicket 	= array();
				$vipCategoryTicket      = array();
				$standardCategoryTicket = array();
				$businessCategoryTicket = array();
				$premiumCategoryTicket  = array();

				foreach ($users as $user) {
					switch ($user->category) {
						case 'ECONOM':
					 		array_push($economCategoryTicket, $user);
					 		break;
					 	case 'VIP':
					 		array_push($vipCategoryTicket, $user);
					 		break;
					 	case 'STANDARD':
					 		array_push($standardCategoryTicket, $user);
					 		break;
					 	case 'BUSINESS':
					 		array_push($businessCategoryTicket, $user);
					 		break;
					 	case 'PREMIUM':
					 		array_push($premiumCategoryTicket, $user);
					 		break;
					 	default:
					 		break;
					 } 
				}

				function addTicket($CategoryTicket,$ticketsNum,$lang) {
					if (count($CategoryTicket) > 0) {
						$priceTicket = 0;
						$category    = '';
						$amount      = 0;
						$ticketsum   = 0;
						if ($ticketsNum < 1) {
							$ticketsNum = 1;
						}
						$services_name = 'Пакет услуг';
						if ($lang != 'ru') {
							$services_name = 'Information and consultancy services: Service package';
						}
						foreach ($CategoryTicket as $row) {
							$priceTicket = $row->price;
							$amount   	+= $row->price;
							$category  	 = $row->category;
							$ticketsum++;
						}
						$ticket = 
								'<tr>
									<td>'.$ticketsNum.'</td>
									<td>'.$services_name.' "'.$category.'"</td>
									<td>'.$ticketsum.'</td>
									<td align="right">USD</td>
									<td align="right">'.$priceTicket.'</td>
									<td align="right">'.$amount.'</td>
								</tr>';
						$ticketsNum++;
						return array($ticket,$ticketsNum);
					} 
				}

				$ticketsNumb = 1;
				list($ticketCat,$ticketNum) = addTicket($economCategoryTicket,$ticketsNumb,$lang);
				$tickets    .=  $ticketCat;
				if ($ticketNum > 0)	{
					$ticketsNumb = $ticketNum;
			 	}
				list($ticketCat,$ticketNum) = addTicket($vipCategoryTicket,$ticketsNumb,$lang);
				$tickets    .=  $ticketCat;
				if ($ticketNum > 0)	{
					$ticketsNumb = $ticketNum;
			 	}
				list($ticketCat,$ticketNum) = addTicket($standardCategoryTicket,$ticketsNumb,$lang);
				$tickets    .=  $ticketCat;
				if ($ticketNum > 0)	{
					$ticketsNumb = $ticketNum;
			 	}
				list($ticketCat,$ticketNum) = addTicket($businessCategoryTicket,$ticketsNumb,$lang);
				$tickets    .=  $ticketCat;
				if ($ticketNum > 0)	{
					$ticketsNumb = $ticketNum;
			 	}
				list($ticketCat,$ticketNum) = addTicket($premiumCategoryTicket,$ticketsNumb,$lang);
				$tickets    .=  $ticketCat;
				if ($ticketNum > 0)	{
					$ticketsNumb = $ticketNum;
			 	}
				if (count($economCategoryTicket) > 0) {
					$ticketsNum++;
				}
				if (count($vipCategoryTicket) > 0) {
					$ticketsNum++;
				}
				if (count($standardCategoryTicket) > 0) {
					$ticketsNum++;
				}
				if (count($businessCategoryTicket) > 0) {
					$ticketsNum++;
				}
				if (count($premiumCategoryTicket) > 0) {
					$ticketsNum++;
				}
			}

			$cancelLink = 'https://synergy.ru/lander/alm/intellectmoneyPay.php?timepadspain&cancelorder='.$mergelead;

			$message = include 'superticket/timepadspain/letters/payclient_invoiceRUS.php'; 

			$strPriceFinal = '';
			$dateInvoice   = '';

			if ($lang == 'ru') {
				$strPriceFinal = num2str($priceFinal);
				$dateInvoice   = rdate('"d" M Y'); 
				$strPriceFinal = mb_ucfirst($strPriceFinal);
			} else {
				$strPriceFinal = num2strEng($priceFinal);     
				$dateInvoice   = date('"d" F Y');
				$message  	   = include 'superticket/timepadspain/letters/payclient_invoiceENG.php'; 
			}

			$priceNDS = round(($priceFinal / 118) * 18, 2);
			
			if ($lang == 'ru') {
				$htmlinvoice = include 'superticket/timepadspain/letters/invoiceRUS.php'; 
			} else {
				$htmlinvoice = include 'superticket/timepadspain/letters/invoiceENG.php';
			}

			if ($shopId != 'invoice') {
				$message = include 'superticket/timepadspain/letters/payclientRUS.php'; 
				if ($lang != 'ru') {
					$message = include 'superticket/timepadspain/letters/payclientENG.php'; 
				}

			} else {
				require '/var/www/syn.su/public/lib/mpdf/mpdf.php';
				$mpdf = new Mpdf();
				$mpdf->WriteHTML($htmlinvoice);		
			}

			$mailer = new PHPMailer;
	        $mailer->isSMTP();                                         
	    	$mailer->Host         = $configMail['host'];
			$mailer->SMTPAuth     = $configMail['SMTPAuth'];                               
			$mailer->Username     = $configMail['username'];  
			$mailer->Password     = $configMail['password'];  
			$mailer->SMTPSecure   = $configMail['SMTPSecure'];  
			$mailer->Port         = $configMail['port'];
			$mailer->From         = $configMail['from'];
	        $mailer->FromName     = 'SGF 2017';
	        $mailer->CharSet      = $configMail['charset'];
	        $mailer->isHTML(true);                                                
	        $mailer->addAddress($email);
	        $mailer->Subject      = 'Оплата счета SGF';
	        $mailer->Body         = $message;
	        $mailer->addBCC($email_regional);
	        $mailer->addBCC($email_manager);
	        $mailer->addBCC('7200@synergy.ru');
	        if ($lang == 'ru') {
			//	$mailer->addAttachment('superticket/timepadspain/files/oferta_sgf_rus.pdf');  
				$mailer->addAttachment('superticket/timepadspain/files/SGF2017_Brochure_RUS.pdf'); 
			} else {
				$mailer->addAttachment('superticket/timepadspain/files/oferta_sgf_angl.pdf');   
				$mailer->addAttachment('superticket/timepadspain/files/SGF2017_Brochure_ENG.pdf');   
			}
			if ($shopId == 'invoice') {    
				$mpdf->Output($mergelead.'.pdf','F');
				$mailer->addAttachment($mergelead.'.pdf'); 
			}               
			$mailer->send();
			unlink($mergelead.'.pdf');

			$ticketinfo = '';

			if (isset($json->addTicketInfo) && $json->addTicketInfo != '') {
				$ticketinfo = $json->addTicketInfo;
			}

			foreach ($users as $user) {
				$ticketinfo .= '<br>'.$user->ticketInfo.' ID билета: '.$user->seatId;
			}

			$postUsers = array(
				'phone'		     => $phone,
				'email'		     => $email,
				'NAME'		     => $userName,
				'sourceName'     => 'WEB',
				'mergelead'      => $mergelead,
				'ticketinfo'     => $ticketinfo,
				'ticketamount'   => $price,
				'ticketcurrency' => 'USD'
			);

			if (is_dir('superticket/timepadspain/~~uploadsAlignment/'.$mergelead)) {
				$files = scandir('superticket/timepadspain/~~uploadsAlignment/'.$mergelead.'/');
				$ticketdiscountfilename = '';
				foreach ($files as $file) {
					$ticketdiscountfilename = $file;  
				}
				$ticketdiscountfile = chunk_split(base64_encode(file_get_contents('superticket/timepadspain/~~uploadsAlignment/'.$mergelead.'/'.$ticketdiscountfilename)));
				$postUsers = array(
					'phone'		   			 => $phone,
					'email'		   			 => $email,
					'NAME'		   			 => $userName,
					'sourceName'   			 => 'WEB',
					'mergelead'    			 => $mergelead,
					'ticketinfo'   			 => $ticketinfo,
					'ticketamount' 			 => $price,
					'ticketdiscountfilename' => $ticketdiscountfilename,
					'ticketdiscountfile'	 => $ticketdiscountfile,
					'ticketcurrency'		 => 'USD'
				);
			} else {
				$postUsers = array(
					'phone'		   	 => $phone,
					'email'		   	 => $email,
					'NAME'		   	 => $userName,
					'sourceName'   	 => 'WEB',
					'mergelead'    	 => $mergelead,
					'ticketinfo'   	 => $ticketinfo,
					'ticketamount' 	 => $price,
					'ticketcurrency' => 'USD'
				);
			}

			$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postUsers);
			$json = json_decode($response);
			if (isset($json->dealid)) {
				$stmtupdate = $pdo->query("UPDATE `".$config['nametable']."` SET `deal_id` = '".$json->dealid."' WHERE `mergelead` = '".$mergelead."'"); 
				$response = cURLsend('http://stp.sgf2017.com:8080/order.update?mergelead='.$mergelead.'&dealid='.$json->dealid.'&orderid='.$json->orderid, false);
				$jsontimepad = json_decode($response);
				mail("7200@synergy.ru", "Test", $json->dealid. ' orderid='.$json->orderid);
												
			    if ($jsontimepad->error != false) {
			    	$stmtupdate = $pdo->query("UPDATE `".$config['nametable']."` SET `errors` = '".$jsontimepad->error."' WHERE `mergelead` = '".$mergelead."'"); 
			    } else {
			    	echo $additionally;
			    }
			}
		}

		echo $additionally;
		exit();
	}

	if (isset($_REQUEST['superticket'])) {
		if (isset($_REQUEST['cancelorder']) && $_REQUEST['cancelorder'] != '') {
			if (isset($_REQUEST['update'])) {
				if (isset($_REQUEST['status'])) {
					$stmtupd = $pdo->query("UPDATE `".$config['nametable']."` SET `date_order` = '0', `status_code` = '".$_REQUEST['status']."' WHERE `mergelead` = '".$_REQUEST['cancelorder']."'"); 

					$postData = array(
						'mergelead' 		=> $_REQUEST['cancelorder'],
						'ticketdealstatus'	=> '-1'
					);
									
					$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);

					echo "ok";

					$stmtselect = $pdo->query("SELECT * FROM `".$config['nametable']."` where mergelead = '".$_REQUEST['cancelorder']."'")->fetchAll();
					exit();
				}
			}
			exit();
		}
		exit();
	}
			
	echo "YES";
	if (isset($_REQUEST['LMI_PAYEE_PURSE']) && 
		isset($_REQUEST['LMI_PAYMENT_AMOUNT']) &&
		isset($_REQUEST['LMI_PAYMENT_ORIGINAL_AMOUNT']) &&
		isset($_REQUEST['LMI_HASH']) &&
		isset($_REQUEST['LMI_PAYER_PURSE']) &&
		isset($_REQUEST['LMI_PAYER_WM']) &&
		isset($_REQUEST['LMI_SYS_INVS_NO']) &&
		isset($_REQUEST['LMI_SYS_TRANS_NO']) && 
		isset($_REQUEST['LMI_PAYMENT_NO'])) {

		$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` WHERE orderId = ".$_REQUEST['LMI_PAYMENT_NO'])->fetchAll();

		foreach ($stmt as $row) {
			if ($_REQUEST['LMI_PAYMENT_AMOUNT'] == $_REQUEST['LMI_PAYMENT_ORIGINAL_AMOUNT']) {
				if ($_REQUEST['LMI_PAYMENT_AMOUNT'] >= $row['price']) {
					if ($row['shopId'] == $_REQUEST['LMI_PAYEE_PURSE']) {
						$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '2',`date_pay` = now() ,`detail` = 'Заказ успешно оплачен', `transanctionNumber` = '".$_REQUEST['LMI_SYS_TRANS_NO']."' WHERE `orderId` = '".$_REQUEST['LMI_PAYMENT_NO']."'"); 

						if ($row['promocode_id'] != 0 && $row['promocode_id'] != null && $row['promocode_id'] != 151) {
							$stmt = $pdo->query("UPDATE `".$config['tablepromo']."` SET `used` = '1',`dateUsed` = now() WHERE `id` = '".$row['promocode_id']."'"); 
						}

							switch ($row['land']) {
								case 'realcat': {
									$postData = array(
					    				'graccount'  => 'synergy',
					    				'grcampaign' => 'e_mail_chain_cat',
					    				'email' 	 => $row['userEmail'],
					    				'name' 	 	 => $row['userName']
									);
									$response = cURLsend('https://synergy.ru/lander/alm/lander.php?r=land/index&unit=intellectmoney', $postData);
									exit();
								}
								case 'synergyzavod': {
									$postData = array(
						    			'email' => $row['userEmail'],
						    			'name'  => $row['userName'],
						    			'land'  => $row['land']
									);
									$response = cURLsend('https://synergy.ru/lander/alm/lander.php?r=land/index&unit=sbs&type=landpay', $postData);
									break;
								}
								case 'sadovod': {
									if ($row['promocode_id'] == 151) {
										$postData = array(
				  							'mergelead' => $mergelead,
											'comments'  => 'Гринландия'
										);

										$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);
									} else {
										$postData = array(
				  							'mergelead' => $mergelead,
											'comments'  => 'КупиКупон'
										);

										$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);
									}
									break;
								}
							}

							if (isset($_REQUEST['grc']) && isset($_REQUEST['gra']) && $_REQUEST['grc'] != '' && $_REQUEST['gra'] != '') {
							
								$postData = array(
						    		'graccount'  => $_REQUEST['gra'],
						    		'grcampaign' => $_REQUEST['grc'],
						    		'email' 	 => $row['userEmail'],
						    		'name'		 => 'NoName'
								);
								$response = cURLsend('https://synergy.ru/lander/alm/lander.php?r=land/index&unit=intellectmoney', $postData);

								if (isset($_REQUEST['grc2']) && isset($_REQUEST['gra2']) && $_REQUEST['grc2'] != '' && $_REQUEST['gra2'] != '') {
									$postData = array(
						    			'graccount'  => $_REQUEST['gra2'],
						    			'grcampaign' => $_REQUEST['grc2'],
						    			'email' 	 => $row['userEmail'],
						    			'name' 	 	 => 'NoName'
									);
									$response = cURLsend('https://synergy.ru/lander/alm/lander.php?r=land/index&unit=intellectmoney', $postData);
								}
							}

							if ($row['mergelead'] != '') {

								switch ($row['type']) {

									case 'timepadspain': {
										$postData = array(
											'mergelead' 		   => $row['mergelead'],
											'onlinepayamount'	   => $_REQUEST['LMI_PAYMENT_AMOUNT'],
											'onlinepaytransacid'   => $_REQUEST['LMI_SYS_TRANS_NO'],
											'onlinepayproductname' => $row['productName'].' Product_ID = '.$row['product_id']
										);
											
										$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);

										exit();
									}
								
									default: {
										$postData = array(
											'mergelead' 		   => $row['mergelead'],
											'onlinepayamount'	   => $_REQUEST['LMI_PAYMENT_AMOUNT'],
											'onlinepaytransacid'   => $_REQUEST['LMI_SYS_TRANS_NO'],
											'onlinepayproductname' => $row['productName']
										);
										
										$response = cURLsend('https://corp.synergy.ru/api/crm/leads', $postData);

										exit();
									}					
								}
							}
						exit();
					} else {
						$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '3',`detail` = 'Не совпадает магазин' WHERE `orderId` = '".$_REQUEST['LMI_PAYMENT_NO']."'"); 
					}
				} else {
					$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '3',`detail` = 'Не совпадает цена товара с оплатой' WHERE `orderId` = '".$_REQUEST['LMI_PAYMENT_NO']."'"); 
				}
			} else {
				$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET `status` = '3',`detail` = 'Не верная сумма оплаты' WHERE `orderId` = '".$_REQUEST['LMI_PAYMENT_NO']."'"); 
			}
		}
	}
} catch(PDOException $e) {
	$f=@fopen(dirname(__FILE__) . "/logs/error.intellectmoney.log","a+") or
	("error");
	fputs($f,	date("d:m:Y h:i:s").'ОШИБКА! Невозможно соединиться с БД: ' . $e->getMessage()."\n");
	fclose($f);	
	exit();
}

function num2strEng($num) {
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(!$num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine', 'Ten', 'Eleven',
        'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Fixteen', 'Seventeen', 'Eighteen', 'Nineteen');
    $list2 = array('', 'Ten', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion');
    $num_length = strlen($num);
    $levels 	= (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num 	 	= substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ( $hundreds == 1 ? '' : 's' ) . ' ' : '');
        $tens 	  = (int) ($num_levels[$i] % 100);
        $singles  = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens 	 = (int) ($tens / 10);
            $tens 	 = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } 
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    $engStr = implode(' ', $words);
    return $engStr.' US Dollars and zero cent';
}

function num2str($num) {
	$nul = 'ноль';
	$ten = array(
			  array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		      array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
		   );
	$a20 	 = array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens 	 = array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred = array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit 	 = array( 
			      array('цент'    ,'центы'   ,'центов'    ,1),
				  array('доллар'  ,'доллара' ,'долларов'  ,0),
				  array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
				  array('миллион' ,'миллиона','миллионов' ,0),
				  array('миллиард','милиарда','миллиардов',0),
			   );
	
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { 
			if (!intval($v)) 
				continue;
			$uk = sizeof($unit)-$uk-1; 
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
		
			$out[] = $hundred[$i1]; 
			if ($i2 > 1) 
				$out[] = $tens[$i2].' '.$ten[$gender][$i3]; 
			else 
				$out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3]; 
		
			if ($uk > 1) 
				$out[] = morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} 
	}
	else 
		$out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); 
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); 
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n > 10 && $n < 20) 
		return $f5;
	$n = $n % 10;
	if ($n > 1 && $n < 5) 
		return $f2;
	if ($n == 1) 
		return $f1;
	return $f5;
}

function rdate($param, $time=0) {
	if(intval($time) == 0)
		$time = time();
	$MonthNames = array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октября", "Ноября", "Декабря");
	if(strpos($param,'M') === false) 
		return date($param, $time);
	else 
		return date(str_replace('M',$MonthNames[date('n',$time)-1],$param), $time);
}

function sendMail($subject,$message,$addAddress,$addBCC1,$addBCC2) {
	require_once ('/var/www/syn.su/public/worker/new_daemons/lib/PHPMailer/PHPMailerAutoload.php');
	$mailer = new PHPMailer;
	$mailer->isSMTP();                                         
	$mailer->Host         = 'localhost';
	$mailer->SMTPAuth     = false;                               
	$mailer->Username     = '';
	$mailer->Password     = '';
	$mailer->SMTPSecure   = false;
	$mailer->Port         = 25;
	$mailer->From         = 'notice@sbs.edu.ru';
	$mailer->FromName     = 'Super Ticket';
	$mailer->CharSet      = 'UTF-8';
	$mailer->isHTML(true);                                                
	$mailer->addAddress($addAddress);
	if ($addBCC1 != '') {
		$mailer->addBCC($addBCC1);
	}
	if ($addBCC2 != '') {
		$mailer->addBCC($addBCC2);
	}
	$mailer->addBCC('7200@synergy.ru');
	$mailer->Subject      = $subject;
	$mailer->Body         = $message;           
	$mailer->send();
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

mb_internal_encoding("UTF-8");
function mb_ucfirst($text) {
    return mb_strtoupper(mb_substr($text, 0, 1)) . mb_substr($text, 1);
}

function removeDirectory($dir) {
	if ($objs = glob($dir."/*")) {
    	foreach($objs as $obj) {
    is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       	}
    }
	rmdir($dir);
}