<?php
header('Access-Control-Allow-Origin: *');
//define('DEBUG', true);
########################
### Версия: 1.2      ###
### Date: 26.02.2016 ###
########################


define('LN_DIR', __DIR__); //использовать вместо __DIR__ и DOCUMENT_ROOT во всех инклудах и реквайрах
define('DSP', DIRECTORY_SEPARATOR); //использовать вместо DIRECTORY_SEPARATOR

define('USEFUL_DIR', LN_DIR . '/useful/'); // для очень часто используемых функций


/* Функция АнтиСпам защиты */
include_once LN_DIR . DSP . 'lander_spam_defender.php';
lander_spam_defender();

session_start();
include_once LN_DIR . DSP . 'logs.php';
include_once LN_DIR . DSP . 'alm_lander.php';

	$_REQUEST['phone'] = preg_replace('~\D+~','',$_REQUEST['phone']);
		$f=@fopen(dirname(__FILE__) . "/lander.log","a+") or ("error");
		fputs($f,	print_r($_REQUEST,true)."\n");
		fclose($f);	
				$f=@fopen(dirname(__FILE__) . "/server.log","a+") or ("error");
		fputs($f,	print_r($_SERVER,true)."\n");
		fclose($f);	

$_SESSION['Status']=GV::$dublicate ;
if (isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'sms')) {
	GV::$config['ignore']['vrf_by_phone'] = true;
} else {
	GV::$config['ignore']['vrf_by_phone'] = false;
}
        

switch(GV::$route) {
	default:
	$_REQUEST['r'] = 'land\index';
	case 'landindex':
	$req = array();
	foreach ($_REQUEST as $key => $value) {
            $req[$key] = urldecode($value);
	}

	GV::$lead = new Lead();
	GV::$lead = GV::$lead->exchangeData($req);
	break;
	case 'landphone_validate':
	GV::$lead = new Lead();

	GV::$lead = GV::$lead->stateRead();
	GV::$lead->phone_validate = htmlspecialchars($_REQUEST['phone_validate']);
	break;
	case 'landphone_retry':

	GV::$lead = new Lead();
	GV::$lead = GV::$lead->stateRead();
	break;
	case 'landresendsms':

	GV::$lead = new Lead();
	GV::$lead = GV::$lead->stateRead();
	break;
	case 'land_update':

	GV::$lead = new Lead();
	GV::$lead = GV::$lead->stateRead();

	break;
}

$config = GV::$config;
$lead = GV::$lead;
$units = GV::$units;
        

define('UNIT_DIR', LN_DIR.'/units/'.$units[$lead->unit]['path']);
define('TYPE_DIR', LN_DIR.'/units/'.$units[$lead->unit]['path'].'/types/'.htmlspecialchars($_REQUEST['type']));
$new_forms = false;
$rand_log = rand(1000000,9999999).'# ';        

//авто подгрузка форм от значения полей реквеста

//дефолтное значение для юнита.
if(!$new_form && file_exists(UNIT_DIR.'/form_default.php')){
    $log->add_rec($lead->unit, 'unit', $rand_log.'Сработал новый механизм. Форма юнита по умолчанию.', 1, json_encode($_REQUEST).'###########'.json_encode($config['ignore']).'###########'.UNIT_DIR.'###########'.TYPE_DIR);
    include_once(UNIT_DIR.'/form_default.php');
    $new_form = true;
}

//ищем тип
if(htmlspecialchars($_REQUEST['type']) != '' && $units[$lead->unit]['path'] != '' && is_dir(TYPE_DIR)){
    $log->add_rec($lead->unit, 'unit', $rand_log.'Работаем с путём '.TYPE_DIR,1,false);
    //дефолтное значение для типа.
    if(file_exists(TYPE_DIR.'/form_default.php')){
        include_once(TYPE_DIR.'/form_default.php'); 
        $log->add_rec($lead->unit, 'unit', $rand_log.'Сработала форма по умолчанию '.TYPE_DIR.'/form_default.php', 1, json_encode($config['ignore']));
        $new_form = true;
    }
    
    //ищем формы
    $types_incl_file = array('form');
    foreach($types_incl_file as $tpf){
        $log->add_rec($lead->unit, 'unit', $rand_log.'Ищем '.TYPE_DIR.'/'.$tpf.'_'.htmlspecialchars($_REQUEST[$tpf]).'.php',1,false);
        if(file_exists(TYPE_DIR.'/'.$tpf.'_'.htmlspecialchars($_REQUEST[$tpf]).'.php')){
            include_once(TYPE_DIR.'/'.$tpf.'_'.htmlspecialchars($_REQUEST[$tpf]).'.php');
            define('TYPE_IS_SELECT',true);//гребаный костыль, так как не только тайпы но и формы сначал могут быть и ленды которые запихнул в form_after
            $new_form = true;
            $log->add_rec($lead->unit, 'unit', $rand_log.'Обработали '.TYPE_DIR.'/'.$tpf.'_'.htmlspecialchars($_REQUEST[$tpf]).'.php', 1, json_encode($config['ignore']));
        }
        else{
            define('TYPE_IS_SELECT',false);//гребаный костыль, так как не только тайпы но и формы сначал могут быть и ленды которые запихнул в form_after
        }
    }
    
    //иногда надо какие то дополнительные телодвижения по типу
    if($new_form && file_exists(TYPE_DIR.'/form_after.php')){
        $log->add_rec($lead->unit, 'unit', $rand_log.'Обработали постфому типа', 1, json_encode($config['ignore']));
        include_once(TYPE_DIR.'/form_after.php');
    }    
    
}
//иногда надо какие то дополнительные телодвижения по юниту после
if($new_form && file_exists(LN_DIR.'/units/'.$units[$lead->unit]['path'].'/form_after.php')){
    $log->add_rec($lead->unit, 'unit', $rand_log.'Обработали постфому юнита', 1, json_encode($config['ignore']));
    include_once(LN_DIR.'/units/'.$units[$lead->unit]['path'].'/form_after.php');
}  


//старое

//swith case убран в базу в таблицу db_units, вообще скоро и этого не будет. см. код выше
if(!$new_form && is_file(LN_DIR.'/'.$units[$lead->unit]['dir_name'])){
    
    $log->add_rec($lead->unit, 'unit', 'Сработал старый механизм '.$lead->unit, 1, json_encode($_REQUEST));
    include_once LN_DIR.'/'.$units[$lead->unit]['dir_name'];
}
elseif(!$new_form){
    /* Если UNIT не определен, выдавать ошибку и отправлять письмо админу */
    /* Конфигуратор FormMessages */ 
	$config['user']['sendsuccess'] = "
	<div class='send-success'>
		<h3 style='color:red'>Внимание, ошибка!</h3>
		<p style='color:red'>Сообщение отправлено, но <u style='font-weight:bold;'>не распределено</u>!</p>

	</div>
	";
	/* Конфигуратор MessageForCallCentre  AOdintsov*/
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('aodintsov@synergy.ru'));
	$config['mail']['smtp']['cc']['subject'] = "Лид попал вникуда...";
	$config['mail']['smtp']['cc']['message'] = "
	<p>
		<b>Браузер: $lead->browser</b>
		<br />Ленд: $lead->land
		<br />Версия: $lead->version
		<br />Форма: $lead->form
		<br />Action формы: $lead->path
		<br />-----
		<br />Имя: <b>$lead->name</b>
		<br />Телефон: <b>$lead->phone</b>
		<br />Email: <b>$lead->email</b>
		<br />-----
		<br />Город: <b>$lead->city</b>
		<br />Источник: <b>$lead->source</b>
		<br />Адрес страницы: $lead->url
		<br />-----------------------------------------
	</p>
	<p style='font-size:11px;'>Реферер: $lead->refer</p>
	";
}

/* Система пропуска заявок если юзер уже подавал с ленда заявку, через капчу.
*/

/*Если отправляем смс, код для капчи отдельный*/
if(!empty($lead->phone)) {
	if ($_REQUEST['lang'] == 'en' || $_REQUEST['lang'] == 'eng') {
		$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>You already left a request!</h3>
			<p style='text-align:center;'>Please confirm that you are not a robot and press the «Send» button.</p>
			<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
				<input type=\"hidden\" value='{$lead->version}' name=\"version\" />
				<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
				<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />

				<script src='https://www.google.com/recaptcha/api.js'></script>
				<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\"></div></center>
				<input type=\"submit\" class=\"btn\" value=\"Send\" />
			</form>
		</div>
		";
	}
	else{
		if (isset($_REQUEST['promo'])) {
			$config['user']['sendduplicate'] = "
			<div class='send-duplicate'>
				<h3>Вы уже оставляли заявку!</h3>".$URLZ."
				<p style='text-align:center;'>Пожалуйста, подтвердите что вы не робот и нажмите кнопку «Отправить».</p>
				<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
					<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
					<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
					<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
					<input type=\"hidden\" value='{$_SESSION['md_5']}' name=\"someid\" />
					<input type=\"hidden\" value='{$lead->version}' name=\"version\" />
					<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
					<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />
					<input type=\"hidden\" name=\"piwik_id\" value=\"{$lead->owa_visitorId}\"/>
					<input type=\"hidden\" name=\"analytics_id\" value=\"{$lead->analytics_id}\"/>
					<input type=\"hidden\" name=\"promo\" value=\"{$_REQUEST['promo']}\"/>
					<script src='https://www.google.com/recaptcha/api.js'></script>
					<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\" data-callback=\"recaptchaCallback\"></div></center>
					<input type=\"submit\" class=\"btn\" value=\"Отправить\" />
				</form>
			</div>
			<script>
			function recaptchaCallback() {
				$('#duplicate-capcha :submit').addClass('recaptcha-success');
			};
			</script>
			";
		} else {
			$config['user']['sendduplicate'] = "
			<div class='send-duplicate'>
				<h3>Вы уже оставляли заявку!</h3>".$URLZ."
				<p style='text-align:center;'>Пожалуйста, подтвердите что вы не робот и нажмите кнопку «Отправить».</p>
				<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
					<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
					<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
					<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
					<input type=\"hidden\" value='{$_SESSION['md_5']}' name=\"someid\" />
					<input type=\"hidden\" value='{$lead->version}' name=\"version\" />
					<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
					<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />
					<input type=\"hidden\" name=\"piwik_id\" value=\"{$lead->owa_visitorId}\"/>
					<input type=\"hidden\" name=\"analytics_id\" value=\"{$lead->analytics_id}\"/>
					<script src='https://www.google.com/recaptcha/api.js'></script>
					<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\" data-callback=\"recaptchaCallback\"></div></center>
					<input type=\"submit\" class=\"btn\" value=\"Отправить\" />
				</form>
			</div>
			<script>
			function recaptchaCallback() {
				$('#duplicate-capcha :submit').addClass('recaptcha-success');
			};
			</script>
			";
		}
	}
}
else{
	/*$config['user']['sendduplicate'] = "
	<div class='send-duplicate'>
		<h3>Вы уже оставляли свой почтовый адрес.</h3>
		<p></p>
	</div>
	";*/

	if ($_REQUEST['lang'] == 'en' || $_REQUEST['lang'] == 'eng') {
		$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>You already left a request!</h3>
			<p style='text-align:center;'>Please confirm that you are not a robot and press the «Send» button.</p>
			<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
				<input type=\"hidden\" value='{$lead->version}' name=\"version\" />
				<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
				<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />

				<script src='https://www.google.com/recaptcha/api.js'></script>
				<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\"></div></center>
				<input type=\"submit\" class=\"btn\" value=\"Send\" />
			</form>
		</div>
		";
	}
	else{
		$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>Вы уже оставляли заявку!</h3>".$URLZ."
			<p style='text-align:center;'>Пожалуйста, подтвердите что вы не робот и нажмите кнопку «Отправить».</p>
			<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
				<input type=\"hidden\" value='{$_SESSION['md_5']}' name=\"someid\" />
				<input type=\"hidden\" value='{$lead->version}' name=\"version\" />
				<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
				<input type=\"hidden\" value='{$lead->mergelead}' name=\"mergelead\" />
				<input type=\"hidden\" name=\"piwik_id\" value=\"{$lead->owa_visitorId}\"/>
				<input type=\"hidden\" name=\"analytics_id\" value=\"{$lead->analytics_id}\"/>
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<center><div style=\"margin:10px 0 10px -15px; transform:scale(0.9);transform-origin:0;-webkit-transform:scale(0.7);
transform:scale(0.7);-webkit-transform-origin:0 0;transform-origin:0 0;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\" data-callback=\"recaptchaCallback\"></div></center>
				<input type=\"submit\" class=\"btn\" value=\"Отправить\" />
			</form>
		</div>
		<script>
		function recaptchaCallback() {
			$('#duplicate-capcha :submit').addClass('recaptcha-success');
		};
		</script>
		";
	}

}


GV::$config = $config;
GV::$lead = $lead;


run();
if(DEBUG){
	echo '<h3>КОД - '.decrypt($_REQUEST['vk']).'('.strlen($_REQUEST['vk']) .')</h3><h3>('.$GLOBALS ["valcodez"] .')</h3><p style="background:#300; color:#fff"><pre>
	<b>POST</b><br>name: ['.$_POST['name'].']<br>phone: ['.$_POST['email'].']<br>md5: ['.$_POST['vk'].']<br></pre></p><hr>';

	echo '<p style="background:#300; color:#fff"><pre>
	<b>LEAD</b><br>name: ['.GV::$lead->name.']<br>phone: ['.GV::$lead->phone.']<br>md5: ['.GV::$lead->vk.']<br></pre></p><hr>';
	echo '<div style="font-size:8px"><hr><p>_GET vk: '.$_GET['vk'].'</p>';
	echo '<div style="font-size:8px"><hr><p>_POST:'.print_r($_POST,true).'</p>';
	echo '<p>_GET:'.print_r($_GET,true).'</p>';
	echo '<p>_SESSION:'.print_r($_SESSION,true).'</p></div>';
}


function trace($var){
	echo '<pre>';
	var_export($var);
	echo '</pre>';
}

function encrypt($text) {
	$key = "EzqegRKncgL2bPgVNuvVpHdC";/* 24 bit Key */
	$iv = "Qkp4TKJh";/* 8 bit IV */
	$bit_check=8;/* bit amount for diff algor. */

	$text_num =str_split($text,$bit_check);
	$text_num = $bit_check-strlen($text_num[count($text_num)-1]);
	for ($i=0;$i<$text_num; $i++) {$text = $text . chr($text_num);}
		$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
	mcrypt_generic_init($cipher, $key, $iv);
	$decrypted = mcrypt_generic($cipher,$text);
	mcrypt_generic_deinit($cipher);
	return base64_encode($decrypted);
}

function decrypt($encrypted_text){
	$key = "EzqegRKncgL2bPgVNuvVpHdC";/* 24 bit Key */
	$iv = "Qkp4TKJh";/* 8 bit IV */
	$bit_check=8;/* bit amount for diff algor. */

	$cipher = mcrypt_module_open(MCRYPT_TRIPLEDES,'','cbc','');
	mcrypt_generic_init($cipher, $key, $iv);
	$decrypted = mdecrypt_generic($cipher,base64_decode($encrypted_text));
	mcrypt_generic_deinit($cipher);
	$last_char=substr($decrypted,-1);
	for($i=0;$i<$bit_check-1; $i++){
		if(chr($i)==$last_char){
			$decrypted=substr($decrypted,0,strlen($decrypted)-$i);
			break;
		}
	}
	return $decrypted;
}
