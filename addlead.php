<?php



if (isset($_REQUEST) && !empty($_REQUEST)) {
    
	switch ($_REQUEST['idadd']) {
        case '162379':
            $f = fopen("/var/www/syn.su/public/logs/addlead.log","a+") or die("error");
            fputs($f,   date("d:m:Y h:i:s").print_r($_REQUEST,true)."\n");
            fclose($f);
            if (isset($_REQUEST['phone']) && isset($_REQUEST['email']) && isset($_REQUEST['name'])) {
                $request = array(
                    'land'          => 'sbd2',
                    'unit'          => 'sbs',
                    'phone'         => urldecode($_REQUEST['phone']),
                    'email'         => urldecode($_REQUEST['email']),
                    'name'          => $_REQUEST['name'],
                    'comments'      => $_REQUEST['roistat'],
                    'ip'            => isset($_SERVER['REMOTE_ADDR'])  ? $_SERVER['REMOTE_ADDR'] : '',
                    'partner'       => '',
                    'r'             => 'land\\index',
                    'source'        => 'test',
                    'utm_source'    => '',
                    'campaign'      => ''  
                );
                
                $_REQUEST = array_merge($_REQUEST, $request);

                ob_start();
                include('/var/www/syn.su/public/lander.php');
                $resp = ob_get_clean();
            }
            break;
	}
}


