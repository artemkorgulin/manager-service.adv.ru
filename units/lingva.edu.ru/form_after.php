<?php
if(TYPE_IS_SELECT == false){
    ##################
    ##### i-camp #####
    ##################
    if(isset($_REQUEST['land']) && $_REQUEST['land'] == 'english-online'){
            if(isset($_REQUEST['version']) && $_REQUEST['version'] == 'jobsmarket'){
                    $config['user']['sendsuccess'] = "
                    <div class='send-success'>
                            <h3>Заявка успешно отправлена!</h3>
                            <p>Наш менеджер скоро с вами свяжется.</p>
                    </div>";
            }
    }
    ###################################
    ##### Формы "Перезвоните мне" #####
    ###################################
    elseif(isset($_REQUEST['form']) AND ($_REQUEST['form'] == 'callme')) {
            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    <p>Перезвоним вам по номеру <b>{$lead->phone}</b>, в ближайшее время, держите телефон под рукой.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";
    }
    ###########################
    ##### i-camp mc #####
    ###########################
    elseif(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'i-Camp MC')) {
                    $config['user']['sendsuccess'] = "
                    <div class='send-success'>
                            <h3>Заявка успешно отправлена!</h3>
                            <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с дальнейшими инструкциями.</p>
                            <script>$('document').ready(function(){Hash.add('send','ok');});</script>
                    </div>";
                    /* Конфигуратор UserMail */
                    $config['ignore']['send_to_user'] 	= true;
                    $config['mail']['smtp']['user']['subject'] 	= "Ваша заявка получена!";
                    $config['mail']['smtp']['user']['message'] 	= '
                    <table style="width: 800px; font-weight: normal; border-collapse: collapse; background: #fff; border: 1px solid #eee; margin: 0 auto" cellpadding="0" cellspacing="0">
                            <tr>
                                    <td style="width: 600px; height: 80px; background: #ff3a41; padding-left: 40px;"><img src="http://lingva.edu.ru/texts/img/logo.jpg" alt="Университет «Синергия» | Языковой центр"></td>
                                    <td style="width: 200px; height: 80px; color: #fff; background: #1e2337; font-size: 24px; font-weight: bold; text-align: center; ">8 (495) 663-93-62</td>
                            </tr>

                            <tr>
                                    <td colspan=2 style="height: 300px;">
                                            <img src="http://lingva.edu.ru/texts/img/top-ic.jpg" alt="i-Camp MC">
                                    </td>
                            </tr>

                            <tr>
                                    <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                            <h1 style="font-size: 32px; line-height: 32px; font-weight: bold; color: #ff3a41; font-weight: bold; text-transform: uppercase;">Добрый день!</h1>
                                            <h3 style="font-size: 22px; line-height: 22px; font-weight: normal; padding-top: 10px; color: #ff3a41;">Мы рады видеть Вас среди участников языковой творческой <br>программы i-Camp!</h3>
                                            <p style="line-height: 20px;">i-Camp, это уникальный проект, который не имеет аналогов в России. i-Camp для тех, кто хочет выйти за рамки стандартных форм изучения английского языка, повысить свой творческий потенциал, найти новых друзей, пообщаться с людьми из разных стран.
                                            </p><p style="line-height: 20px;">
                                            Мы объединили в нем все самое актуальное:
                                            <ul>
                                                    <li> Развитие бизнес-мышления</li>
                                                    <li> Развитие навыков английского языка</li>
                                                    <li> Занятия с носителями языка</li>
                                                    <li> Самые позитивные вожатые и кураторы</li>
                                                    <li> Обучающие тренинги и семинары</li>
                                                    <li> Яркие творческие мероприятия</li>
                                                    <li> Работа в команде</li>
                                                    <li> Море положительных эмоций и много новых друзей и впечатлений</li>
                                            </ul>
                                            <br />
                                            --------------------------------------------------------------------------------<br /><br />
                                    </p>
                                    <p style="padding: 25px 0px; line-height: 20px;">
                                            В ближайшее время вам перезвонит наш менеджер, и расскажет о проекте, а пока посмотрите интересные материалы о лагере i-Camp.
                                    </p>
                                    <p>
                                            Чем полезен лагерь i-Camp - <a href="http://youtu.be/yrz4clru1e0" target="_blank">смотреть</a><br />
                                            В нашей группе в ВКонтакте ты прочтешь о впечатлениях участников - <a href="http://vk.com/i_camp">перейти</a><br />
                                            Как проходит подготовка педагогического отряда -  <a href="http://youtu.be/o58tc8OlaJQ">ссылка на&nbsp;видео</a><br />
                                            Как проходили прошлые выезды – <a href="http://lingva.edu.ru/o-nas/fotogalereya/">смотреть фото</a><br /><br /><br />
                                    </p>
                            </td>
                    </tr>

                    <tr>
                            <td style="width: 500px; font-size: 18px; line-height: 18px; font-weight: normal; font-style: italic; padding-left: 30px; padding-bottom: 50px;">
                                    Руководитель проекта i-Camp<br>Языкового центра Университета «Синергия»
                            </td>
                            <td style="width: 300px; font-size: 18px; line-height: 18px; font-weight: normal; font-style: italic; padding-bottom: 50px;">
                                    С уважением,<br>Михайлова Светлана Сергеевна
                            </td>
                    </tr>
            </table>

            <table style="margin: 0 auto; border: 1px solid #1e2337; width: 813px; border-collapse: collapse; background: #1e2337;   " cellpadding="0" cellspacing="0">
                    <tr>
                            <td style="width: 420px; height: 80px; padding-left: 40px;">
                                    <img src="http://lingva.edu.ru/texts/img/logo_footer.jpg">
                            </td>
                            <td style="width: 150px; font-size: 12px; line-height: 12px; color: #a4a7ae;"><p>Наши страницы<br>в социальных сетях:</p></td>
                            <td style="width: 35px;"><a href="https://www.facebook.com/lingvaedu"><img src="http://lingva.edu.ru/texts/img/fb.jpg"></a></td>
                            <td style="width: 35px;"><a href="https://vk.com/lingvaedu"><img src="http://lingva.edu.ru/texts/img/vk.jpg"></a></td>
                            <td style="width: 35px;"><a href="http://instagram.com/lingvaedu"><img src="http://lingva.edu.ru/texts/img/in.jpg"></a></td>
                            <td style="width: 35px; padding-right: 40px;"><a href="https://www.youtube.com/playlist?list=PLqW3u411sCU5ix3XoGOeJa9vcu2wr59L6"><img src="http://lingva.edu.ru/texts/img/yt.jpg"></a></td>
                    </tr>
            </table>
            ';
    }
    elseif(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'online_english')) {
            /* Конфигуратор UserMail */
            $config['user']['sendsuccess'] = "
            <div class='send-success'>
                    <h3>Заявка успешно отправлена!</h3>
                    <p>Проверьте вашу почту <b>{$lead->email}</b>, на&nbsp;которую придет письмо с дальнейшими инструкциями.</p>
                    <script>$('document').ready(function(){Hash.add('send','ok');});</script>
            </div>";

            $config['ignore']['send_to_user']   = true;
            $config['mail']['smtp']['user']['subject']  = "Ваша заявка получена!";
            $config['mail']['smtp']['user']['message']  = '
            <table style="width: 800px; font-weight: normal; border-collapse: collapse; background: #fff; border: 1px solid #eee; margin: 0 auto" cellpadding="0" cellspacing="0">
                    <tr>
                            <td style="width: 600px; height: 80px; background: #ff3a41; padding-left: 40px;"><img src="http://new.slingva.syndev.ru/texts/img/logo.jpg" alt="Университет «Синергия» | Языковой центр"></td>
                            <td style="width: 200px; height: 80px; color: #fff; background: #1e2337; font-size: 24px; font-weight: bold; text-align: center; ">8 (495) 663-93-62</td>
                    </tr>

                    <tr>
                            <td colspan=2 style="height: 300px;">
                                    <img src="http://new.slingva.syndev.ru/texts/img/top-en.jpg" alt="'.$lead->landname.'">
                            </td>
                    </tr>

                    <tr>
                            <td colspan=2 style="color: #000; font-size: 18px; font-weight: normal; line-height: 20px; padding: 30px 30px;">
                                    <h1 style="font-size: 32px; line-height: 32px; font-weight: bold; color: #ff3a41; font-weight: bold; text-transform: uppercase;">Здравствуйте, '.$lead->name.' !</h1>
                                    <h3 style="font-size: 22px; line-height: 22px; font-weight: normal; padding-top: 10px; color: #ff3a41;">Благодарю Вас за проявленный интерес к Языковому центру Университета «Синергия»!</h3>
                                    <p style="line-height: 20px;">Если Вы обратились к нам за помощью в изучении английского языка, то 50% успеха уже у вас в кармане! Ведь наш Центр — это первоклассная команда настоящих профессионалов в области образования.
                                    </p><p style="line-height: 20px;">
                                    Мы используем самые передовые методики обучения и готовы помочь каждому, кто хочет говорить на&nbsp;иностранном языке! Мы стараемся сделать процесс обучения максимально
                                    интересным и эффективным. Согласитесь, очень приятно изучать английский язык, когда ты находишься в весёлой и дружеской обстановке, а сам процесс обучения построен так, что скучать не придётся! Мы подобрали для Вас лучших преподавателей и множество программ обучения!
                            </p>
                            <p style="padding: 25px 0px; line-height: 20px;">Наши консультанты обязательно свяжутся с Вами в ближайшее время.<br>Хотите узнать больше прямо сейчас? Позвоните нам: <b>+7 (495) 663-93-62</b><br>Так же предлагаю Вам ознакомиться с <a href="http://lingva.edu.ru/o-centre/otzyvy/" style="color:#000; text-decoration: underline">отзывами наших клиентов</a>.</p>
                    </td>
            </tr>

            <tr>
                    <td style="width: 580px; font-size: 18px; line-height: 18px; font-weight: normal; font-style: italic; padding-left: 30px; padding-bottom: 50px;">
                            Академический Директор<br>Языкового центра Университета «Синергия»
                    </td>
                    <td style="width: 220px; font-size: 18px; line-height: 18px; font-weight: normal; font-style: italic; padding-bottom: 50px;">
                            С уважением.<br>Инна Пеньковская
                    </td>
            </tr>
    </table>

    <table style="margin: 0 auto; border: 1px solid #1e2337; width: 813px; border-collapse: collapse; background: #1e2337;   " cellpadding="0" cellspacing="0">
            <tr>
                    <td style="width: 420px; height: 80px; padding-left: 40px;">
                            <img src="http://new.slingva.syndev.ru/texts/img/logo_footer.jpg">
                    </td>
                    <td style="width: 150px; font-size: 12px; line-height: 12px; color: #a4a7ae;"><p>Наши страницы<br>в социальных сетях:</p></td>
                    <td style="width: 35px;"><a href="https://www.facebook.com/lingvaedu"><img src="http://new.slingva.syndev.ru/texts/img/fb.jpg"></a></td>
                    <td style="width: 35px;"><a href="https://vk.com/lingvaedu"><img src="http://new.slingva.syndev.ru/texts/img/vk.jpg"></a></td>
                    <td style="width: 35px;"><a href="http://instagram.com/lingvaedu"><img src="http://new.slingva.syndev.ru/texts/img/in.jpg"></a></td>
                    <td style="width: 35px; padding-right: 40px;"><a href="https://www.youtube.com/playlist?list=PLqW3u411sCU5ix3XoGOeJa9vcu2wr59L6"><img src="http://new.slingva.syndev.ru/texts/img/yt.jpg"></a>
                    </td>
            </table>
            ';
    }
    elseif(isset($_REQUEST['land']) AND ($_REQUEST['land'] == 'i-camp-zima')) {
            if(isset($_REQUEST['version']) AND ($_REQUEST['version'] == 'bm')){
                    $config['user']['sendsuccess'] = "
                    <div class='send-success'>
                            <h3>Заявка успешно отправлена!</h3>
                            <p>НАШИ МЕНЕДЖЕРЫ ВАМ ПЕРЕЗВОНЯТ</p>
                    </div>".$redirect;

                    $config['ignore']['getresponse']    = true;
                    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
                    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_engblend');
            }

            if(isset($_REQUEST['version']) AND ($_REQUEST['version'] == 'newyear')){
                    $config['user']['sendsuccess'] = "
                    <div class='send-success'>
                            <h3>Заявка успешно отправлена!</h3>
                            <p>НАШИ МЕНЕДЖЕРЫ ВАМ ПЕРЕЗВОНЯТ</p>
                            <p>Москва, м. &laquo;Семеновская&raquo;, ул. Измайловский Вал, д.&nbsp;2. Форма одежды&nbsp;&mdash; свободная</p>
                    </div>".$redirect;

                    $config['ignore']['getresponse']    = true;
                    $config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
                    $config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_engblend');
            }
    }	
}

/* Адрес и имя для отправки писем */
$config['mail']['smtp']['from']		= "notice@lingva.edu.ru";
$config['mail']['smtp']['fromname']	= "Центр языковой подготовки";

##########################
##### GRcampaign for land = i-camp-leto #####
##########################
if(isset($_REQUEST['land']) AND $_REQUEST['land'] == 'i-camp-leto'){
	/* Конфигуратор GetResponse */
	$config['ignore']['getresponse']    = true;
	$config['newsletter']['getresponse']['account']  = (!empty($lead->graccount)  ? $lead->graccount  : 'synergy');
	$config['newsletter']['getresponse']['campaign'] = (!empty($lead->grcampaign) ? $lead->grcampaign : 'e_mail_chain_icampleto');
}