<?php 
// Функция антиспам-защиты		
if(!function_exists ('lander_spam_defender')) {
    function lander_spam_defender() 	
    {
    	// Список запрещённых URL
		switch($_REQUEST['url']){
			case 'http://synergy.ru:80/':

			// Счетчик срабатываний в лог файл
			$content = @file_get_contents('antispam.log');
	        $f = fopen('antispam.log','w');
	        $content = (int)$content;
			fwrite($f,++$content);
			fclose($f);

			die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по URL.</h4>
            	 </div>");
			break;
		}

    	// Список запрещённых телефонов
		switch($_REQUEST['phone']){
			case '555-666-0606':

			// Счетчик срабатываний в лог файл
			$content = @file_get_contents('antispam.log');
	        $f = fopen('antispam.log','w');
	        $content = (int)$content;
			fwrite($f,++$content);
			fclose($f);

			die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по номеру телефона.</h4>
            	 </div>");
			break;
		}

		// Список запрещённых URL рефереров
		switch($_SERVER['HTTP_REFERER']){
			case 'http://www.mfpa.ru/':

			// Счетчик срабатываний в лог файл
			$content = @file_get_contents('antispam.log');
	        $f = fopen('antispam.log','w');
	        $content = (int)$content;
			fwrite($f,++$content);
			fclose($f);

			die("<div class='send-success'>
                 	<h3>Заявка НЕ отправлена!</h3>
                 	<h4>СПАМ: Блокировка по REFERER.</h4>
            	 </div>");
			break;
		}
	
		// Чёрный список IP адресов
        switch ($_SERVER['REMOTE_ADDR']) {
            case '142.4.215.148':
            case '188.165.213.170':
            case '188.165.213.222':
            case '188.165.233.138':
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
            //case '10.12.120.144': // Synergy test

            // Счетчик срабатываний в лог файл
            $content = @file_get_contents('antispam.log');
	        $f = fopen('antispam.log','w');
	        $content = (int)$content;
			fwrite($f,++$content);
			fclose($f);

            die("<div class='send-success'>
                    <h3>Заявка НЕ отправлена!</h3>
                    <h4>СПАМ: Блокировка по IP.</h4>
            	</div>");
            break;
        } 
    }
}