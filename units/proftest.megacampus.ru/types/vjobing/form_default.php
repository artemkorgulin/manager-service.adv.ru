<?php
    $DefaultEmailMessage = '
    <h2><font face="Arial, sans-serif">Дорогой предприниматель!</font></h2>
    <font face="Arial, sans-serif">Министерствоо экономического развития Российской Федерации, Федеральное агентство по делам молодёжи, бизнес-студия бари алибасова и WOW-event благодарят Вас за проявленный интерес к нашему форуму.
<br><br>
    Основная часть форума пройдет в Москве в первой российской бизнес-школе - “Синергия”, по адресу: М. Семёновская, Измайловский вал, 1 к.2.
        <br><br>
        <b>Стоимость форума с включённым проживанием в Москве: 19 700 рублей
        <br><br>
    ОПЛАТИТЬ ФОРУМ ВЫ МОЖЕТЕ ПО <a href="http://vjobing.ru/buy.php">ССЫЛКЕ</a>
        <br><br>
    Стоимость всего форума без проживания (питание включено) - 12 700 рублей</b>
        <br><br>
    Для получения этой стоимости перейдите по <a href="http://vjobing.ru/buy.php">ссылке</a> и введите промокод
        <b>NOLIVE</b>
        <br><br>
    Так же  Вы можете оплатить отдельный день. Для этого выберите понравившийся день в программе по ссылке ниже и введите на <a href="http://vjobing.ru/buy.php">странице оплаты</a> соответствующий промокод дня (перечислены ниже):
        <br><br>
        <b>Стоимость 1-го дня (питание включено) - 3 000 рублей</b>
        <br><br>
    ПРОГРАММА ФОРУМА:
    <a href="https://drive.google.com/open?id=1MEk_eegsivjPR8rZM4-Zq5YkLdxWen0x4c5Aj296Z0U">https://drive.google.com/open?id=1MEk_eegsivjPR8rZM4-Zq5YkLdxWen0x4c5Aj296Z0U</a>
        <br><br>
    Промо код на 25 сентября с Бари Алибасовым младшим: <b>NOLIVE25</b>
    Промо код на 26 сентября с Игорем Стояновым: <b>NOLIVE26</b>
    Промо код на 27 сентября с Владимиром Довганем: <b>NOLIVE27</b>
    Промо код на 28 сентября с Иваном Захаровым: <b>NOLIVE28</b>
    Промо код на 29 сентября с БАРИ АЛИБАСОВЫМ старшим: <b>NOLIVE29</b>
        <br><br>
    <b>В последний день включён выезд на загородную вечеринку в честь закрытия форума</b>
        <br><br>
    Если у Вас появятся вопросы - пишите ответственному менеджеру за приём гостей Анастасии Кондаковой <a
            href="mailto:Jrkondakova@gmail.com">Jrkondakova@gmail.com</a>  или звоните по горячей линии +7(499)3 400 400 с 10:00 до 19:00 по московскому времени.<br>
    Ждем Вас!</font>';

    $config['ignore']['bitrix24'] 	= false;

    // Конфигуратор FormMessages
    $config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
    </div>";

    $config['user']['sendduplicate'] = "
    <div class='send-duplicate'>
        <h3>Вы уже отправляли сообщение!</h3>
        <p>Если вам не ответили или не перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой
        номер</a> телефона.</p>
    </div>";

    // Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('JRkondakova@gmail.com'));

	$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда VJOBING.RU";
	$config['mail']['smtp']['cc']['message'] = "
        ФИО: <b>$lead->name</b> <br />
        Телефон: <b>$lead->phone</b> <br />
        Email: <b>$lead->email</b>";

	// Адрес и имя для отправки писем
	$config['mail']['smtp']['from']		= "noreply@vjobing.ru";
	$config['mail']['smtp']['fromname']	= "vjobing.ru";

    $config['ignore']['send_to_user']   = true;
    $config['mail']['smtp']['user']['subject'] 	= "Подтверждение заявки на участие в форуме молодых миллионеров «Междуречье»";
    $config['mail']['smtp']['user']['message']  = $DefaultEmailMessage;