<?php 

	$html = cURLsend('http://synergyglobal.com/?version=belfort',false);

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


	$html = str_replace('ny_usa.js', 'ny_world.js', $html);


	$old_price_economy = 	'$750';
	$old_price_general = 	'$1900';
	$old_price_standard = 	'$2400';
	$old_price_business = 	'$3300';
	$old_price_vip = 		'$4900';
	$old_price_premium = 	'$10000';

	$old_price_economy_summ = 	(int)str_replace('$','',$old_price_economy);
	$old_price_general_summ = 	(int)str_replace('$','',$old_price_general);
	$old_price_standard_summ = 	(int)str_replace('$','',$old_price_standard);
	$old_price_business_summ = 	(int)str_replace('$','',$old_price_business);
	$old_price_vip_summ = 		(int)str_replace('$','',$old_price_vip);
	$old_price_premium_summ = 	(int)str_replace('$','',$old_price_premium);

	$promocode = $_REQUEST['promocode'];
	switch ($promocode) {
		case 'ASTJB':
		case 'SMJB':

			$sale = 0;

		break;
		case 'ASTJB10':
		case 'SMJB10':

			$sale = 10;

		break;
		case 'ASTJB20':
		case 'SMJB20':

			$sale = 20;

		break;
		case 'ASTJB30':
		case 'SMJB30':

			$sale = 30;

		break;
		case 'ASTJB40':
		case 'SMJB40':

			$sale = 40;

		break;
		case 'ASTJB50':
		case 'SMJB50':

			$sale = 50;

		break;
		case 'ASTJB60':
		case 'SMJB60':

			$sale = 60;

		break;
		case 'ASTJB70':
		case 'SMJB70':

			$sale = 70;

		break;
		default: 

			$sale = 0;

		break;
	}

	$sale = $sale/100;

	$price_economy = 	'$' . ( $old_price_economy_summ - ($old_price_economy_summ * $sale) );
	$price_general = 	'$' . ( $old_price_general_summ - ($old_price_general_summ * $sale) );
	$price_standard = 	'$' . ( $old_price_standard_summ - ($old_price_standard_summ * $sale) );
	$price_business = 	'$' . ( $old_price_business_summ - ($old_price_business_summ * $sale) );
	$price_vip = 		'$' . ( $old_price_vip_summ - ($old_price_vip_summ * $sale) );
	$price_premium = 	'$' . ( $old_price_premium_summ - ($old_price_premium_summ * $sale) );

	$html = str_replace($old_price_economy, $price_economy, $html);
	$html = str_replace($old_price_general, $price_general, $html);
	$html = str_replace($old_price_standard, $price_standard, $html);
	$html = str_replace($old_price_business, $price_business, $html);
	$html = str_replace($old_price_vip, $price_vip, $html);
	$html = str_replace($old_price_premium, $price_premium, $html);

	//$html = str_replace('land=sgf2017_en&', 'land=sgf2017_en&hash='.$_REQUEST['hash'].'&', $html);
	//$html = str_replace('data-form="please_register"', 'data-form="buy-ticket"', $html);
	//$html = str_replace('//synergy.ru/lander/alm/js/lander.js', 'https://syn.su/js/lander.js', $html);
	//$html = str_replace('data-package="premium">', 'data-package="premium" data-hash="'.$_REQUEST['hash'].'">', $html);
	//$html = str_replace('data-package="economy">', 'data-package="economy" data-hash="'.$_REQUEST['hash'].'">', $html);
	//$html = str_replace('data-package="general">', 'data-package="general" data-hash="'.$_REQUEST['hash'].'">', $html);
	//$html = str_replace('data-package="standard">', 'data-package="standard" data-hash="'.$_REQUEST['hash'].'">', $html);
	//$html = str_replace('data-package="business">', 'data-package="business" data-hash="'.$_REQUEST['hash'].'">', $html);
	//$html = str_replace('data-package="vip">', 'data-package="vip" data-hash="'.$_REQUEST['hash'].'">', $html);
	/*$html = str_replace('<script src="js/common.js"></script>', '<script>'.file_get_contents("http://synergyglobal.com/js/common.js").'</script>', $html);
	//$html = str_replace('https://', '//', $html);
	$html = str_replace('<link href="css/fonts.css" rel="stylesheet">', '<style>'.file_get_contents('http://synergyglobal.com/css/fonts.css').'</style>', $html);
	//$html = str_replace("url('font/", '', $html);
	//$html = str_replace("http://synergyglobal.com/font/", "//syn.su/sgfsales/font/", $html);
	$html = str_replace("url('font/", "url('https://syn.su/sgfsales/font/", $html);
	$html = str_replace('<link href="css/style.css?2017-10-08" rel="stylesheet">', '<style>'.file_get_contents('http://synergyglobal.com/css/style.css').'</style>', $html);
	$html = str_replace('<link href="css/responsive.css?2017-10-08" rel="stylesheet" media="(max-width: 1199px)">', '<style>'.file_get_contents('http://synergyglobal.com/css/responsive.css').'</style>', $html);
	$html = str_replace('http://synergyonline.ru/lander/alm/', 'https://synergy.ru/lander/alm/', $html);

	$html = str_replace('</head>', '<script>//setInterval(console.clear, 500)</script></head>', $html);*/

	echo $html;

?>