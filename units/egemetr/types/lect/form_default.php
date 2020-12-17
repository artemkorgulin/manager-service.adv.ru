<?php

// Конфигуратор FormMessages
if (isset($_REQUEST['nosms']) && !($lead->land == 'egerf_planb')) {

    $config['user']['sendsuccess'] = " <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>В ближайшее время мы свяжемся с вами и ответим на все вопросы!</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        </div>";


    $config['ignore']['send_to_user']       = true;
    $config['mail']['smtp']['from']		= "notice@xn--c1ad7e.xn--p1ai";
    $config['mail']['smtp']['fromname']	= "ЕГЭ.РФ";
    $config['mail']['smtp']['user']['subject']      = "Добро пожаловать в Центр Довузовской подготовки!";

    if ($lead->land == 'egerf_vebinar_v2'){
        $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_webinar_v2.php';
    } else if ($lead->land == 'egerf_vebinar_v3') {
        $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_webinar_v3.php';
    } else if ($lead->land == 'egerf_vebinar_v4') {
        $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_webinar_v4.php';
    } else if ($lead->land == 'egerf_vebinar_v5') {
        $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_webinar_v5.php';
    } else {
        $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_ege.php';
    }

} elseif (isset($_REQUEST['nosms']) && $lead->land == 'egerf_planb') {

    $config['user']['sendsuccess'] = " <div class='send-success'>
      <h3>Спасибо!</h3>
      <p>В ближайшее время на указанную почту вы получите подробную информацию!</p>
      <script>$('document').ready(function(){Hash.add('send','ok');});</script>
      </div>";

    $config['ignore']['send_to_user']       = true;
    $config['mail']['smtp']['from']		= "notice@xn--c1ad7e.xn--p1ai";
    $config['mail']['smtp']['fromname']	= "ЕГЭ.РФ";
    $config['mail']['smtp']['user']['subject']      = "Регистрация на вебинар подтверждена!";
    $config['mail']['smtp']['user']['message']      = include_once UNIT_DIR.'/types/lect/letters/mail_webinar.php';

} else $config['user']['sendsuccess'] = "
<div class='send-success' id='send-success'>
<form action='http://synergy.ru/lander/alm/lander.php?r=landphone_validate&type=ege' data-form='smsver' method='post' class='application'>
<h3 class='msg_info'>На ваш телефон отправлен код подтверждения!</h3>
<p><input type='text' class='text' name='phone_validate' placeholder='Введите ваш код' id='phone_validate' min='4' reqired autofocus />
<input type='submit' value='Подтвердить' class='btn bluebtn'></p>
<p><span class='msg_text'>Не пришел код в течение 2-ух минут?</span> <input type='button' class='btn' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landresendsms\");' value='Выслать еще раз'></p>
<input type='hidden' name='type' value='proftest'>
<input type='hidden' name='version' value='v2'>
<input type=\"hidden\" value='{$lead->phone}' name=\"phone\" />
<input type=\"hidden\" value='{$lead->vk}' name=\"vk\" />
</form>";

// Верификация успешна
$config['user']['sendsuccessvalidation'] = "
<div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>Подробные инструкции для участия в курсе “Топ-10 ошибок на ЕГЭ” вы получите на вашу почту {$lead->email}, а наш менеджер свяжется с Вами в ближайшее время, и ответит на все вопросы.</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        {$DefaultRedirect}
</div>";

// Верификация провалена
$config['user']['sendfaildvalidation'] = "
<div class='send-error'>
	<h3>СМС код не корректный!</h3>
	<p>Попробуйте <a href='3' onclick='startAjax(\"http://synergy.ru/lander/alm/lander.php?r=landphone_retry&type=proftest\"); return false;'>еще раз</a>.</p>

</div>";

// Неверный номер + смс сервис не доступен
$config['user']['smscfail'] = "
<div class='send-error' id='send-success'>
    <h3>Произошла ошибка!</h3>
    <p>Вы ввели неверный номер мобильного телефона <b>{$lead->phone}</b>, или служба отправки смс недоступна. Пожалуйста, попробуйте позже.</p>

</div>";

// Конфигуратор UserMail

if (!isset($_REQUEST['nosms'])) {
    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['user']['subject'] = "Регистрация на курс \"Топ-10 ошибок на ЕГЭ\"";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR.'/types/lect/letters/mail_default.php';
}

if( $lead->land == 'egerf_vebinar' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

    // Конфигуратор UserMail

    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        // $config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар подтверждена!";
        // $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
        // 		<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

        // 			<p>Мы знаем, как многие ученики относятся к обществознанию. Не многим лучше, чем к физкультуре и ОБЖ. Но как относиться к этим предметам - дело ваше. Методисты ЕГЭ, которые готовят экзамен - такие критерии не учитывают.</p>
        // 			<p>Поэтому вопросы на экзамене, и особенно результаты - не зависят от важности предмета. </p>
        // 			<p>Мы прекрасно понимаем, что готовиться к ЕГЭ по обществознанию так, как к математике или русскому, ты не будешь. Именно поэтому тебя ждёт короткий вебинар, который поможет тебе избежать глупых ошибок, из-за которых ты можешь провалить экзамен, который, скорее всего, выбрал, чтобы не напрягаться.</p>
        // 			<p><b>25 марта. 13:00. Прямой эфир.</b> Все желающие смогут задать свой вопрос нашему эксперту ЕГЭ. <a href="https://youtu.be/_gK0kbCbztU">https://youtu.be/_gK0kbCbztU</a> (трансляция станет активной в указанное время) </p>
        // 			<p>Помни, самые досадные промахи бывают там, где не ждёшь. </p>

        // 			<hr style="color: #E5E5E5;">
        // 			<p>С уважением, команда ЕГЭ.рф</p>

        // 			<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
        // 			<p><b>8 495 280 37 43</b></p>-->
        // 		</div>
        // 	</div>';
        $config['mail']['smtp']['user']['subject'] = "Бесплатный вебинар от ЕГЭ.рф! Добро пожаловать!";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Теперь ты участник серии бесплатных вебинаров от&nbsp;проекта ЕГЭ. рф!</p>
				<p>Мы представляем серию вебинаров, не&nbsp;ограниченных форматом! Только прямой эфир, самые актуальные темы и&nbsp;самое главное&nbsp;&mdash; ответы на&nbsp;самые острые ответы!</p>
				<p>У&nbsp;нас нет скучных ведущих, мы не&nbsp;поклоняемся ЕГЭ, но&nbsp;мы знаем самое главное&nbsp;&mdash; как сдать экзамен без&nbsp;лишних проблем!</p>
				<p>15 августа в 17.00 - мы ждем тебя! </p>
				<p><a href="https://events.webinar.ru/2344632/534441" target="_blank">>>>Смотреть вебинар<<<</a></p>
				<hr style="color: #E5E5E5;">
				<p>С уважением, команда ЕГЭ.рф</p>

				<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
				<p><b>8 495 280 37 43</b></p>-->
			</div>
		</div>';
    }
}

if( $lead->land == 'egerf_ege' || $lead->land == 'egedovuz') {
    $config['user']['sendsuccess'] = " <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>В ближайшее время мы свяжемся с вами и ответим на все вопросы!</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        </div>";

    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['user']['subject'] = "Новая методика подготовки к ЕГЭ";
    }
}

if( $lead->land == 'egerf_oge' ) {
    $config['user']['sendsuccess'] = " <div class='send-success'>
        <h3>Спасибо!</h3>
        <p>В ближайшее время мы свяжемся с вами и ответим на все вопросы!</p>
        <script>$('document').ready(function(){Hash.add('send','ok');});</script>
        </div>";

    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['user']['subject'] = "Новая методика подготовки к ЕГЭ";
    }
}

if( $lead->land == 'egerf_base' ) {
    $config['user']['sendsuccess'] = "
  <div class='send-success'>
    <h3>Заявка успешно отправлена!</h3>
    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
    {$DefaultRedirect}
  </div>";

    $config['ignore']['send_to_user']       = true;
    $config['mail']['smtp']['from']		= "notice@xn--c1ad7e.xn--p1ai";
    $config['mail']['smtp']['fromname']	= "ЕГЭ.РФ";
    $config['mail']['smtp']['user']['subject']      = "Добро пожаловать в Центр Довузовской подготовки!";
    $config['mail']['smtp']['user']['message']      = include_once UNIT_DIR.'/types/lect/letters/mail_base.php';
}

if( $lead->land == 'egerf_vebinar_ru' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

    // Конфигуратор UserMail
    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        $config['mail']['smtp']['user']['subject'] = "Регистрация на вебинар подтверждена!";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Поздравляем! Ты&nbsp;сделал правильный выбор и&nbsp;зарегистрировался на&nbsp;подготовительный вебинар <a href="http://xn--c1ad7e.xn--p1ai/vebinar_ru/">&laquo;3&nbsp;месяца до&nbsp;ЕГЭ по&nbsp;Русскому языку&raquo;</a></p>
				<p>На&nbsp;самом деле, не&nbsp;имеет значения, сколько времени осталось до&nbsp;ЕГЭ. Очевидно одно&nbsp;&mdash; экзамен неизбежен. И&nbsp;когда время придёт&nbsp;&mdash; ты&nbsp;будешь рад любой минуте, которую потратил на&nbsp;подготовку.</p>
				<p>Бесплатный вебинар содержит подробные инструкции, и&nbsp;расскажет 10&nbsp;правил, которые будут с&nbsp;тобой в&nbsp;самый ответственный момент. Не&nbsp;пропусти!</p>

				<hr style="color: #E5E5E5;">
				<p>С уважением, команда ЕГЭ.рф</p>

				<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
				<p><b>8 495 280 37 43</b></p>-->
			</div>
		</div>';
    }
}


if( $lead->land == 'marafon.ege__v1' || $lead->land == 'marafon.ege__v2' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

    // Конфигуратор UserMail
    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        $config['mail']['smtp']['user']['subject'] = "Добро пожаловать на марафон подготовки к ЕГЭ";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Привет! <br>Квантовый скачок&nbsp;&mdash; означает переход на&nbsp;другой уровень. Мы гарантируем тебе новый уровень знаний по&nbsp;окончанию нашего многонедельного марафона.</p>
				<h3>Эксперты ЕГЭ</h3>
				<p>Только лучшие специалисты с&nbsp;опытом&nbsp;ЕГЭ</p>

				<h3>Лайфхаки</h3>
				<p>Хитрости и&nbsp;секреты, которые помогут тебе на&nbsp;экзамене.</p>

				<h3>Интерактивный формат</h3>
				<p>Задавай вопросы онлайн, и&nbsp;получай ответы в&nbsp;прямом эфире!</p>

				<hr style="color: #E5E5E5;">

				<p><strong>Начало марафона: ' . $lead->dater . '</strong></p>

				<p>Ждём тебя на&nbsp;квантовом уровне: <br><a href="https://events.webinar.ru/event/395077" target="_blank">>>> Перейти <<<</a></p>

				<hr style="color: #E5E5E5;">
				<p>С&nbsp;уважением, команда ЕГЭ. рф</p>
			</div>
		</div>';
    }
}


if( $lead->land == 'egerf_failed' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	 </div>";

    // Конфигуратор UserMail
    $config['ignore']['send_to_user'] = false;
}
if( $lead->land == 'egerf_failed_18' ) {
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
      <h3>Заявка успешно отправлена!</h3>
      <script>$('document').ready(function(){Hash.add('send','ok');});</script>
     </div>";

    // Конфигуратор UserMail
    $config['ignore']['send_to_user'] = false;
}



if( $lead->land == 'egerf_vebinar_ru_new' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

    // Конфигуратор UserMail
    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        $config['mail']['smtp']['user']['subject'] = "Бесплатный вебинар от ЕГЭ.рф! Добро пожаловать!";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Теперь ты&nbsp;участник серии бесплатных вебинаров от&nbsp;проекта ЕГЭ.рф!</p>
				<p>Мы&nbsp;представляем серию вебинаров, не&nbsp;ограниченных форматом и&nbsp;цензурой! Только прямой эфир, самые актуальные темы и&nbsp;самое главное&nbsp;&mdash; ответы на&nbsp;самые острые вопросы!</p>
				<p>Бесплатный вебинар содержит подробные инструкции, и&nbsp;расскажет 10&nbsp;правил, которые будут с&nbsp;тобой в&nbsp;самый ответственный момент. Не&nbsp;пропусти!</p>
				<p>У&nbsp;нас нет скучных ведущих, мы&nbsp;не&nbsp;поклоняемся ЕГЭ, но&nbsp;мы&nbsp;знаем самое главное&nbsp;&mdash; как сдать экзамен без лишних проблем!</p>
				<p>27&nbsp;августа в&nbsp;14:00 &laquo;10&nbsp;жирных точек в&nbsp;ЕГЭ. Русский язык&raquo;&nbsp;&mdash; мы&nbsp;ждём тебя!</p>

				<p><a href="https://events.webinar.ru/3121685/560395" target="_blank">>>>Смотреть вебинар<<<</a></p>

				<hr style="color: #E5E5E5;">
				<p>С уважением, команда ЕГЭ.рф</p>

				<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
				<p><b>8 495 280 37 43</b></p>-->
			</div>
		</div>';

    }
}

if( $lead->land == 'egerf_vebinar_mat_new' ) {
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

    // Конфигуратор UserMail
    if (!isset($_REQUEST['nosms'])) {
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        $config['mail']['smtp']['user']['subject'] = "Бесплатный вебинар от ЕГЭ.рф! Добро пожаловать!";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Теперь ты&nbsp;участник серии бесплатных вебинаров от&nbsp;проекта ЕГЭ.рф!</p>
				<p>Мы&nbsp;представляем серию вебинаров, не&nbsp;ограниченных форматом и&nbsp;цензурой! Только прямой эфир, самые актуальные темы и&nbsp;самое главное&nbsp;&mdash; ответы на&nbsp;самые острые вопросы!</p>
				<p>У&nbsp;нас нет скучных ведущих, мы&nbsp;не&nbsp;поклоняемся ЕГЭ, но&nbsp;мы&nbsp;знаем самое главное&nbsp;&mdash; как сдать экзамен без лишних проблем!</p>
				<p>26&nbsp;сентября в&nbsp;18:00 &laquo;Ловушки ЕГЭ-2017 по профильной математике&raquo;&nbsp;&mdash; мы&nbsp;ждём тебя!</p>

				<p><a href="https://events.webinar.ru/2344632/574915" target="_blank">>>>Смотреть вебинар<<<</a></p>

				<hr style="color: #E5E5E5;">
				<p>С уважением, команда ЕГЭ.рф</p>

				<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
				<p><b>8 495 280 37 43</b></p>-->
			</div>
		</div>';
    }
}

if( $lead->land == 'egerf_vebinar_ob_new' ) {
    if (!isset($_REQUEST['nosms'])) {
        $config['user']['sendsuccess'] = "
	<div class='send-success'>
	  <h3>Заявка успешно отправлена!</h3>
	  <script>$('document').ready(function(){Hash.add('send','ok');});</script>
	  {$DefaultRedirect}
	</div>";

        // Конфигуратор UserMail
        $config['ignore']['send_to_user'] = true;
        $config['mail']['smtp']['from'] = "notice@xn--c1ad7e.xn--p1ai";
        $config['mail']['smtp']['fromname'] = "ЕГЭ.РФ";
        $config['mail']['smtp']['user']['subject'] = "Бесплатный вебинар от ЕГЭ.рф! Добро пожаловать!";
        $config['mail']['smtp']['user']['message'] = '<div style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:15px;">
			<div style="margin: 0 auto; width: 540px; padding: 30px; background: #FAFAFA; border:1px solid #D0D0D0; border-radius:6px;">

				<p>Теперь ты&nbsp;участник серии бесплатных вебинаров от&nbsp;проекта ЕГЭ.рф!</p>
				<p>Мы&nbsp;представляем серию вебинаров, не&nbsp;ограниченных форматом и&nbsp;цензурой! Только прямой эфир, самые актуальные темы и&nbsp;самое главное&nbsp;&mdash; ответы на&nbsp;самые острые вопросы!</p>
				<p>У&nbsp;нас нет скучных ведущих, мы&nbsp;не&nbsp;поклоняемся ЕГЭ, но&nbsp;мы&nbsp;знаем самое главное&nbsp;&mdash; как сдать экзамен без лишних проблем!</p>
				<p>15&nbsp;сентября в&nbsp;18:00 &laquo;Итоги ЕГЭ-2017: что случилось на самом деле? Обществознание&raquo;&nbsp;Мы&nbsp;ждём тебя!</p>

				<p><a href="https://events.webinar.ru/2344632/585473" target="_blank">>>>Смотреть вебинар<<<</a></p>

				<hr style="color: #E5E5E5;">
				<p>С уважением, команда ЕГЭ.рф</p>

				<!--<p><b><a href="http://xn--c1ad7e.xn--p1ai">ЕГЭ.РФ</a></b></p>
				<p><b>8 495 280 37 43</b></p>-->
			</div>
		</div>';
    }
}
