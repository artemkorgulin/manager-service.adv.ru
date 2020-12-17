<?php 

	$html = file_get_contents('http://synergyglobal.com');

	$html = str_replace('ny_usa.js', 'ny_world.js', $html);
	$html = str_replace('land=sgf2017_en&', 'land=sgf2017_en&hash='.$_REQUEST['hash'].'&', $html);
	$html = str_replace('data-form="please_register"', 'data-form="buy-ticket"', $html);
	$html = str_replace('http://synergyonline.ru/lander/alm/js/lander.js', 'https://syn.su/js/lander.js', $html);
	$html = str_replace('<script src="js/common.js"></script>', '<script>'.file_get_contents("http://synergyglobal.com/js/common.js").'</script>', $html);
	//$html = str_replace('https://', '//', $html);
	$html = str_replace('<link href="css/fonts.css" rel="stylesheet">', '<style>'.file_get_contents('http://synergyglobal.com/css/fonts.css').'</style>', $html);
	//$html = str_replace("url('font/", '', $html);
	//$html = str_replace("http://synergyglobal.com/font/", "//syn.su/sgfsales/font/", $html);
	$html = str_replace("url('font/", "url('https://syn.su/sgfsales/font/", $html);
	$html = str_replace('<link href="css/style.css?2017-10-08" rel="stylesheet">', '<style>'.file_get_contents('http://synergyglobal.com/css/style.css').'</style>', $html);
	$html = str_replace('<link href="css/responsive.css?2017-10-08" rel="stylesheet" media="(max-width: 1199px)">', '<style>'.file_get_contents('http://synergyglobal.com/css/responsive.css').'</style>', $html);
	$html = str_replace('http://synergyonline.ru/lander/alm/', 'https://synergy.ru/lander/alm/', $html);

	$html = str_replace('</head>', '<script>//setInterval(console.clear, 500)</script></head>', $html);

	echo $html;

?>