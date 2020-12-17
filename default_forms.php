<?php

$config['user']= array(

            // Форма верификации номера
			'sendsuccess' 			=> "
			<div class='send-success'>
				<form action='lander_new.php?r=landphone_validate' method='post' class='application' data-form='smsver'>
					<h3>На ваш телефон отправлен код подтверждения!.</h3>
					<input type='text' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' autofocus />
					<input type='hidden' value='".session_id()."'' name='code'>
					<input type='hidden' name='version' value='v2'>
			<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
			<input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />
					<input type='submit' value='Подтвердить'>
					<p style='color:#fff;'>Выслать <a href='#' onclick='startAjax(\"lander_new.php?r=land/resendsms\");'>код еще раз</a>.</p>
				</form>
			</div>",

			'sendsuccessvalidation' => "
			<div class='send-success'>
			<div style='display:none'><pre>".print_r(GV::$config['user'],true).print_r($_POST,true)."</pre></div>
                <h3>Проверка пройдена ..</h3>
                <p>Доступ предоставлен.</p>
    
            </div>",

			'sms' 	=> "
			<div class='send-error'>
			<div style='display:none'><pre>".print_r(GV::$config['user'],true).print_r($_POST,true)."</pre></div>
                <h3>Проверка Не пройдена ..</h3>
				<p>Попробуйте <a href='#' onclick='startAjax(\"lander_new.php?r=land/phone_retry\");'>еще раз</a>.</p>
                <p>Выслать <a href='#' onclick='startAjax(\"lander_new.php?r=land/resendsms\");'>код еще раз</a>.</p>
             
            </div>",

			'senderror' 			=> "
			<div class='send-error'>
                <h3>Произошла ошибка!..</h3>
                <div style='display:none'><pre>GV_conf_user<br>".print_r(GV::$config['user'],true).'<hr>post<br>'.print_r($_POST,true).'<hr>session<br>'.print_r($_SESSION,true)."</pre></div>
                <p>Пожалуйста, попробуйте еще раз. Если Вы снова увидите эту ошибку, то пожалуйста, <a href='mailto:admin@synergy.university' title='Отправить сообщение на почту'>напишите нам</a>.</p>
              
            </div>",

			'sendduplicate' 		=> "
			<div class='send-duplicate'>
				<h3>Вы уже отправляли сообщение!</h3>
                <p>Если вам не ответили или не перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой номер</a> телефона.</p>
          
            </div>",
			// Сообщение при недоступости сервиса СМС
			"smscfail" 				=> "
			<div class='send-error'>
			    <h3>Произошла ошибка!..</h3>
			    <div style='display:none'><pre>".print_r(GV::$config['user'],true).print_r($_POST,true)."</pre></div>
			    <p>Вы ввели неверный номер мобильного телефона, или служба отправки смс недоступна. Пожалуйста, попробуйте позже...</p>
			 
			</div>",
			"smscnomoney" 		=> "
			<div class='send-error'>
			    <h3>Произошла ошибка!..</h3>
			    <div style='display:none'><pre>".print_r(GV::$config['user'],true).print_r($_POST,true)."</pre></div>
			    <p>Сервис СМС временно отключен.</p>
			
			</div>"

		
	);
	if(!empty($lead->phone)) {
	if ($_REQUEST['lang'] == 'en' || $_REQUEST['lang'] == 'eng') {

		//Ввод капчи
$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>You already left a request!</h3>
			<p style='text-align:center;'>Please confirm that you are not a robot and press the «Send» button.</p>
			<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
				<input type=\"hidden\" value='duplicate' name=\"version\" />
				<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\"></div></center>
				<!--<input type=\"submit\" class=\"btn\" value=\"Отправить\" />-->
				<button name='sendsmssecure' id='sendsmssecure'>Send</button>
			</form>

		</div>

		";
	}
	else{
//Ввод капчи
$config['user']['sendduplicate'] = "
		<div class='send-duplicate'>
			<h3>Вы уже оставляли заявку!</h3>
			<p style='text-align:center;'> Подтвердите что вы не робот и нажмите кнопку «Отправить».</p>
			<form method=\"post\" action=\"http://synergy.ru{$lead->path}\" id='duplicate-capcha'>
				<input type=\"hidden\" value='{$lead->name}' name=\"name\"  />
				<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
				<input type=\"hidden\" value='{$lead->email}' name=\"email\" />
				<input type=\"hidden\" value='duplicate' name=\"version\" />
				<input type=\"hidden\" value='{$lead->PAPVisitorId}' name=\"PAPVisitorId\" />
				<script src='https://www.google.com/recaptcha/api.js'></script>
				<center><div style=\"margin:10px;\" class=\"g-recaptcha\" data-sitekey=\"6LcfjgsTAAAAAD0xtN9BB1vG2v4qWBhqZUi-cxZj\"></div></center>
				<!--<input type=\"submit\" class=\"btn\" value=\"Отправить\" />-->
				<button name='sendsmssecure' id='sendsmssecure'>Отправить</button>
			</form>

		</div>

		";
	}
}
else{
	$config['user']['sendduplicate'] = "
	<div class='send-duplicate'>
		<h3>Вы уже оставляли свой почтовый адрес.</h3>
		<p></p>
	</div>
	";
}
?>