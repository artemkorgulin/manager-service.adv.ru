<?php
if(TYPE_IS_SELECT == false){
    $log->add_rec($lead->unit, 'unit', $rand_log.'Проверяем доп условия пост формы юнита sbs', 1, false);
    if(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'webinar-question')) {
            /* Конфигуратор отправки в Битрикс24 */
            $config['ignore']['bitrix24'] = false;

            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Спасибо!</h3><br/><br/>
                    <p>Ваша заявка успешно отправлена.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";

            /* Конфигуратор GetResponse */
            $config['ignore']['getresponse']    = true;
            $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'sbsedu');
            $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'webinar');
    }

    /* Для ленда http://sbs.edu.ru/lp/selloff/ по заявке https://sd.synergy.ru/task/view/37947 */
    elseif(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'sbs-selloff')) {
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    <p>Cпасибо, мы свяжемся с вами в ближайшее время.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
            </div>
            ";

            if( isset($_REQUEST['partner']) AND ($_REQUEST['partner'] == 'oberezina') ) {
                    $partner_phone = '+7 (831) 414-34-84';
            }

            $config['ignore']['send_to_user']   = true;
            $config['mail']['smtp']['user']['subject']  = "Ваша заявка принята!";
            $config['mail']['smtp']['user']['message'] 	= UNIT_DIR.'/letters/mail_selloff.php';
    }

    elseif(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'whitemap')) {
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Спасибо, ваша заявка принята.</h3>
                    <p>Ссылка на онлайн-трансляцию мероприятия будет направлена на ваш электронный адрес.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script><!-- DEFAULT -->
            </div>
            ";

            $config['ignore']['send_to_user']   = true;
            $config['mail']['smtp']['user']['subject']  = "Ваша заявка принята!";
            $config['mail']['smtp']['user']['message'] 	= UNIT_DIR.'/letters/mail_whitemap.php';
    }

    ###################################
    ##### Формы "Перезвоните мне" #####
    ###################################
    elseif(isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'faq-question')) {
            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Ваш вопрос отправлен. </h3>
                    <p>Вы&nbsp;получите ответ на&nbsp;указанный адрес электронной почты в&nbsp;течение суток.
                      <br>Благодарим вас за&nbsp;ваш интерес к&nbsp;Бизнес-марафону &laquo;Трансформация&raquo;</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";
    }

    ###################################
    ##### Формы "Перезвоните мне" #####
    ###################################    
    elseif(isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'callme')) {
            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Звонок успешно заказан!</h3>
                    <p>Перезвоним вам по номеру <b>{$lead->phone}</b>, в ближайшее время, держите телефон под рукой.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";
    }


}

/* Адрес и имя для отправки писем */
$config['mail']['smtp']['from']		= "notice@sbs.edu.ru";
if(($_REQUEST['land'] !== 'synergyartforum')) {
    $config['mail']['smtp']['fromname']	= "Школа Бизнеса «Синергия»";
}


/* Аккаунт смс-центра */
$config['vrf']['sms']['smsc']['login'] 	= "sbsedu";
$config['vrf']['sms']['smsc']['psw'] 	= "%8XiYb3c^1d%";

if ($lead->land == 'zaryaonline') {

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['fromname']	= 'zaryaonline.ru';
    $config['mail']['smtp']['user']['subject'] = "Спасибо! Ваша заявка отправлена.";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_zaryaonline_txt.php';
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях получения доступа к курсу.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
";
}

if ($lead->land == 'zaryaonline-v3') {

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['fromname']	= 'zaryaonline.ru';
    $config['mail']['smtp']['user']['subject'] = "Спасибо! Ваша заявка отправлена.";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_zaryaonline_txt_3.php';
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях получения доступа к курсу.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
";
}

if ($lead->land == 'zaryaonline-v4') {

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['fromname']	= 'zaryaonline.ru';
    $config['mail']['smtp']['user']['subject'] = "Спасибо! Ваша заявка отправлена.";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_zaryaonline_txt_4.php';
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях получения доступа к курсу.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
";
}

if ($lead->land == 'zaryaonline-v5') {

    $config['ignore']['send_to_user'] = true;
    $config['mail']['smtp']['fromname']	= 'zaryaonline.ru';
    $config['mail']['smtp']['user']['subject'] = "Спасибо! Ваша заявка отправлена.";
    $config['mail']['smtp']['user']['message'] = include_once UNIT_DIR . '/letters/mail_zaryaonline_txt_5.php';
    $config['user']['sendsuccess'] = "
	<div class='send-success'>
	<h3>Спасибо! Ваша заявка отправлена.</h3>
	<p>В ближайшее время мы свяжемся с Вами и расскажем обо всех условиях получения доступа к курсу.</p>
	<script>$('document').ready(function(){Hash.add('send','ok');});</script>
	</div>
";
}