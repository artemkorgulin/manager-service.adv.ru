<?php 
// Функция антиспам-защиты		
if (!function_exists('lander_spam_defender')) {
	function lander_spam_defender()
	{
    	// Список запрещённых URL
		switch ($_SERVER['REQUEST_URI']) {
			case 'http://synergy.ru:80/':

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_request.log');
				$f = fopen('logs/antispam.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 4.</h4>
            	 </div>");
				break;
		}

		switch ($_REQUEST['utm_source']) {
			case 'infopartners_matritca.kz':
				if (strlen($_REQUEST['analytics_id']) < 5) {
					die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						<h4>СПАМ.</h4>
					</div>");
				}
				break;
		}

		if (strlen($_REQUEST['phone']) < 5 && strlen($_REQUEST['name']) < 5 && strlen($_REQUEST['email']) < 5  && $_REQUEST['unit'] == 'sbs' && $_REQUEST['land'] == 'synergymba' && $_REQUEST['type'] == 'mba') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
			<h4>СПАМ: Блокировка по правилу 3.</h4>
		</div>");
		}
		
		if (strlen($_REQUEST['phone']) < 5 && strlen($_REQUEST['form']) < 2 && $_REQUEST['unit'] == 'sbs' && $_REQUEST['land'] == 'synergymba') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
			<h4>СПАМ: Блокировка по правилу 3.</h4>
		</div>");
		}

		if (empty($_REQUEST['phone']) && $_REQUEST['land'] == 'synergystaff') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                		if (empty($_REQUEST['email']) && $_REQUEST['land'] == 'synergystaff') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                	if ((empty($_REQUEST['name']) || strtolower($_REQUEST['name']) == 'noname' || strtolower($_REQUEST['name']) == 'no-name')  && $_REQUEST['land'] == 'synergystaff') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                	if ((empty($_REQUEST['name']) || strtolower($_REQUEST['name']) == 'noname' || strtolower($_REQUEST['name']) == 'no-name')  && $_REQUEST['land'] == 'tony_london') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                    if (empty($_REQUEST['phone']) && $_REQUEST['land'] == 'tony_london') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                    if ((empty($_REQUEST['name']) || strtolower($_REQUEST['name']) == 'noname' || strtolower($_REQUEST['name']) == 'no-name')  && $_REQUEST['land'] == 'sbs-intensive') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                    if (empty($_REQUEST['phone']) && $_REQUEST['land'] == 'sbs-intensive') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                                      
                                    if ((empty($_REQUEST['name']) || strtolower($_REQUEST['name']) == 'noname' || strtolower($_REQUEST['name']) == 'no-name')  && $_REQUEST['land'] == 'sgf2019_spb2') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}
                
                                    if (empty($_REQUEST['phone']) && $_REQUEST['land'] == 'sgf2019_spb2') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        </div>");
		}

		// Список запрещённых Агентов

		switch (urldecode($_SERVER['HTTP_USER_AGENT'])) {
			case 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)':

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_agent.log');
				$f = fopen('logs/antispam_agent.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 3.</h4>
            	 </div>");
				break;

			case 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:50.0) Gecko/20100101 Firefox/50.0':
			case 'Mozilla/5.0 (Windows NT 5.1; rv:7.0.1) Gecko/20100101 Firefox/7.0.1':
				if (strlen($_REQUEST['piwik_id']) < 5) {
					$content = @file_get_contents('logs/antispam_agent.log');
					$f = fopen('logs/antispam_agent.log', 'w');
					$content = (int)$content;
					fwrite($f, ++$content);
					fclose($f);

					die("<div class='send-success'>
	                 	<h3>Заявка НЕ отправлена!</h3>
	                 	<h4>СПАМ: Блокировка по правилу 3.</h4>
	            	 </div>");
					break;
				}

				break;
		}

    	// Список запрещённых телефонов
		switch ($_REQUEST['phone']) {
			case '555-666-0606':
			case '5234534558':

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_phone.log');
				$f = fopen('logs/antispam.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 1.</h4>
            	 </div>");
				break;
		}
		// Список запрещённых email
		switch ($_REQUEST['email']) {
			case 'mark357177@hotmail.com':
			case 'sample@email.tst':
			case 'jimos4581rt@hotmail.com':
			case 'maks124.00@inbox.ru':
			case 'netsparker@example.com':
			case 'contact39506@tinfoil-fake-site.com':
			case '123michaelbriefmmet@mail.ru':
			case 'su_sulliv@yahoo.com':
                                                      case 'nataly.pavlova89@mail.ru':
                                                      case 'yermakova-anneta@mail.ru':
                                                      case 'rji42@course-fitness.com':
                                                      case 'uyiuiu@mail.ru':
			

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_email.log');
				$f = fopen('logs/antispam_email.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 2.</h4>
            	 </div>");
				break;
		}

		// Список запрещённых URL рефереров
		switch ($_SERVER['HTTP_REFERER']) {
			case 'http://www.mfpa.ru/':

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_referer.log');
				$f = fopen('logs/antispam.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 5.</h4>
            	 </div>");
				break;
		}

		// Список запрещённых URL рефереров
		switch ($_REQUEST['name']) {
			case 'Bradley':
			case 'e':

			// Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_name.log');
				$f = fopen('logs/antispam.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по правилу 6.</h4>
            	 </div>");
				break;
		}

		if ($_REQUEST['form'] == 'kz-national') {
			if (strpos($_SERVER['REMOTE_ADDR'], '146.185.223.') !== false) {
				die("<div class='send-success'>
        	           <h3>Заявка НЕ отправлена!</h3>
        	           <h4>СПАМ: Блокировка по правилу 7.</h4>
        	    </div>");
			}
		}
	
		// Чёрный список IP адресов
		switch ($_SERVER['REMOTE_ADDR']) {
			case '142.4.215.148':
			case '188.165.213.170': // 11.08.2015
			case '188.143.232.70': // 10.08.2015
			case '188.143.232.15': // 13.08.2015
			case '188.165.213.222':
			case '188.165.233.138':
			case '188.143.232.40':
			case '192.99.14.166':
			case '37.187.90.85':
			case '37.59.28.42':
			case '94.23.1.20':
			case '94.23.12.169':
			case '94.23.222.184':
			case '94.23.5.222':
			case '94.23.6.124':
			case '116.246.6.51':
			case '37.48.85.195':
			case '188.17.148.39':
			case '188.143.222.26':
			case '188.143.232.43':
			case '188.143.232.14':
			case '188.143.232.16':
			case '188.143.232.37':
			case '188.143.232.10':
			case '188.143.232.13':
			case '51.15.39.2':
			case '165.231.0.242':
			case '193.201.224.230':
			case '46.161.9.14':
			case '46.242.63.49':
			case '146.185.223.201':
			case '37.21.175.228':
			case '46.161.9.30':
			case '5.248.165.238':
			case '78.137.12.208':
			case '46.118.116.199':
			case '37.21.148.93':
			case '146.185.223.100':
			case '31.184.236.48':
			case '46.50.129.43':
			case '146.185.223.119':
			case '178.43.100.27':
			case '46.118.121.58':
			case '37.21.128.108':
			case '185.202.103.50':
			case '31.130.19.9':
			case '49.228.106.173':
			case '46.211.144.26':
			case '31.130.7.142':
			case '94.25.176.238':
			case '81.17.154.120':
			case '146.185.223.129':
			case '93.170.253.148':
			case '31.10.97.71':
			case '94.25.177.241':
			case '2.95.64.42':
			case '93.188.37.174':
			case '37.21.146.199':
			case '80.85.157.170':
			case '37.112.25.89':
			case '79.173.89.49':
			case '83.217.8.84':
			case '185.86.149.131':
			case '93.188.39.133':
			case '46.161.9.52':
			case '37.21.179.205':
			case '188.163.109.0':
			case '146.185.223.132':
			case '146.185.223.147':
			case '178.159.37.85':
			case '217.23.7.126':
			case '188.92.74.189':
			case '195.3.144.185':
            // Счетчик срабатываний в лог файл
				$content = @file_get_contents('logs/antispam_ip.log');
				$f = fopen('logs/antispam.log', 'w');
				$content = (int)$content;
				fwrite($f, ++$content);
				fclose($f);

				die("<div class='send-success'>
                    <h3>Заявка НЕ отправлена!</h3>
                    <h4>СПАМ: Блокировка по правилу 7.</h4>
            	</div>");
				break;
		}

		if (strpos($_SERVER['HTTP_REFERER'], 'infopartners_ofstrategy.kz_sm') !== false) {

			die("<div class='send-success'>
                    <h3>Заявка НЕ отправлена!</h3>
                    <h4>СПАМ: Блокировка по правилу KZ SPAM.</h4>
            	</div>");
		}

		$white_list = array(
			'' => '',
		);

		// Стоп-слова для comments
		if (isset($_REQUEST['comments']) && $_REQUEST['comments'] != '' && !is_array($_REQUEST['comments'])) {
			// в этот массив вносить стоп-слова
			$stop_words = array(
				'[/url]',
				'XRumer',
				'captcha',
				'Parser',
				'Bot',
				'SEO/SMM',
				'Ckaйп',
				'evg7773',
				'Porn',
				'xxxrutube',
				'https://',
				'http://'
			);

			$white_list = array(
				'synergy.ru' => '',
				'sbs.edu.ru' => ''
			);


			if (preg_match('#(http|https|ftp|ftps)[\:\/]+[^\s]+#ui', $_REQUEST['comments'], $url) || preg_match('#(www)[.]+[^\s]+#ui', $_REQUEST['comments'], $url)) {
				$host = parse_url($url[0]);
				if (!array_key_exists($host['host'], $white_list)) {
					die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						<h4>СПАМ!</h4>
					</div>");
				}
			}

			if (strlen($_REQUEST['comments']) > 250) {
				die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						h4>СПАМ.</h4>
					</div>");
			}

			foreach ($stop_words as $word) {
				if (stripos($_REQUEST['comments'], $word) !== false) {
					die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						<h4>СПАМ.</h4>
					</div>");
				}
			}
		}

		if (isset($_REQUEST['bot']) && $_REQUEST['bot'] != '') {
			die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						<h4>СПАМ.</h4>
				</div>");
		}

		if ($_REQUEST['land'] == 'synergy-digital-forum-2019' && trim($_REQUEST['phone']) == '') {
			die("<div class='send-success'>
					<h3>Заявка НЕ отправлена!</h3>
					<h4>СПАМ.</h4>
				</div>");
		}

		if ($_REQUEST['land'] == 'hakamada-intuition' && trim($_REQUEST['phone']) == '') {
			die("<div class='send-success'>
					<h3>Заявка НЕ отправлена!</h3>
					<h4>СПАМ.</h4>
				</div>");
		}
                                    /* Полная блокировка лидов для hakamada-intuition */
                                    if ($_REQUEST['land'] == 'hakamada-intuition') {
			die("<div class='send-success'>
					<h3>Заявка НЕ отправлена!</h3>
					<h4>СПАМ.</h4>
				</div>");
		}

		$userIP = getIP();
		@include_once(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeo.php');

		if (class_exists('SxGeo', false)) {
			$sxgeo = new SxGeo(__DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'SxGeo' . DIRECTORY_SEPARATOR . 'SxGeoMax.dat');
		}

		if ($sxgeo instanceof SxGeo) {
			$xml = $sxgeo->getCityFull($userIP);
			if ($xml['country']['name_ru'] == 'Латвия') {
				die("<div class='send-success'>
						<h3>Заявка НЕ отправлена!</h3>
						<h4>СПАМ.</h4>
					</div>");
			}
		}
                
                                    if ((empty($_REQUEST['name']) || strtolower($_REQUEST['name']) == 'noname' || strtolower($_REQUEST['name']) == 'no-name')  && $_REQUEST['land'] == 'synergyspeakers') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        <h4>СПАМ.</h4>
                        </div>");
		}
                
                                    if (empty($_REQUEST['phone'])  && $_REQUEST['land'] == 'synergyspeakers') {
			die("<div class='send-success'>
			<h3>Заявка НЕ отправлена!</h3>
                        <h4>СПАМ.</h4>
                        </div>");
		}
	}
}

if (!function_exists('getIP')) {
    function getIP()
    {
        $ip = NULL;
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && $_SERVER['HTTP_CF_CONNECTING_IP'] != '') {
                $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } else {
                if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
                        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                } else {
                $ip = (!isset($ip) && isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : NULL;
                }
        }
        return $ip;
    }
}
