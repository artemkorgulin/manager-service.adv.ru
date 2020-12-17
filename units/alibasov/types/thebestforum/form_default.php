<?php
$DefaultEmailMessage = '
    <h2>Дорогой владелец бизнеса!</h2>

<p>Благодарим Вас за&nbsp;проявленный интерес к&nbsp;главному событию 2016&nbsp;года для&nbsp;современных предпринимателей.</p>

<p>Форум молодых миллионеров стал преемником культового форума &laquo;Селигер&raquo;, теперь с&nbsp;комфортным проживанием в&nbsp;загородном отеле вместо палаток, берегом Волги вместо озера Селигер и&nbsp;участниками только из&nbsp;числа действующих предпринимателей.</p>
<p>В&nbsp;2015&nbsp;году предпринимательское сообщество уже назвало Форум молодых миллионеров &laquo;Междуречье&raquo;&nbsp;&mdash; золотым стандартом делового события и&nbsp;в&nbsp;этом году на&nbsp;&laquo;Поволжье&raquo; мы удивим Вас ещё сильнее.</p>
<p>Приехав на&nbsp;форум вы за&nbsp;5&nbsp;дней найдёте в&nbsp;одном месте всё для&nbsp;прокачки бизнеса, искушённого отдыха и&nbsp;приятных знакомств. Узнайте что кроется за&nbsp;форматами:</p>
<ul>
    <li>КУХНЯ МИЛЛИАРДЕРА</li>
    <li><span style="white-space:nowrap;">VIP-ЛЕКТОРИЙ</span></li>
    <li>КУЗНИЦА ПРОРЫВОВ</li>
    <li><span style="white-space:nowrap;">БИЗНЕС-ИГРИЩА</span></li>
    <li>ТЕРРИТОРИЯ СВОБОДНОГО ОБУЧЕНИЯ</li>
    <li>ПРАЗДНИК&nbsp;ТЕЛА</li>
    <li>НОЧНЫЕ САТУРНАЛИИ</li>
    <li>WOWEVENT</li>
</ul>

<p><a href="https://docs.google.com/document/d/1vz28tgwOx99iGFwy1khvIOQKOloriQoVkKHlw1SU5Bs/edit" target="_blank">Ссылка на актуальную программу</a></p>

<p>ВНИМАНИЕ! Со 2 августа состоится повышение цен. Купите билет заранее по низкой стоимости! <br>
ОПЛАТИТЬ ФОРУМ ВЫ МОЖЕТЕ ПО <a href="https://thebestforum.ticketforevent.com/ru/" target="_blank">ССЫЛКЕ</a> </p>

<p>В подарок за Ваш интерес Мы хотим бесплатно предоставить Вам полный мастер-класс одного из хедлайнеров форума Бари Алибасова младшего: <a href="https://www.youtube.com/watch?v=iPImBEcTuPE">“Бизнес модели будущего”</a> </p>

<p>До встречи 22 августа!</p>

<p>С улыбкой к Вам <br>
Команда форума</p>
';

	$config['ignore']['bitrix24'] 	= false;

	// Конфигуратор FormMessages
	$config['user']['sendsuccess'] = "
    <div class='send-success'>
        <h3>Заявка успешно отправлена!</h3>
        <p>{$lead->name}, вы успешно зарегистрировались на мероприятие, проверьте вашу почту <b>{$lead->email}</b>, на которую придет письмо с дальнейшими инструкциями.</p>
    </div>
    {$redirect}";

	$config['user']['sendduplicate'] = "
    <div class='send-duplicate'>
        <h3>Вы уже отправляли сообщение!</h3>
        <p>Если вам не ответили или не перезвонили, пожалуйста, напишите нам еще раз, указав <a href='%s'>другой
        номер</a> телефона.</p>
    </div>";

	// Конфигуратор MessageForCallCentre
	$config['ignore']['send_to_cc'] = true;
	$config['mail']['smtp']['cc']['emails'] = array(array('b.alibasov@gmail.com','admin@koleso-rf.ru'));

	$config['mail']['smtp']['cc']['subject'] = "Заявка с ленда THEBESTFORUM.RU";
	$config['mail']['smtp']['cc']['message'] = "
        ФИО: <b>$lead->name</b> <br />
        Телефон: <b>$lead->phone</b> <br />
        Email: <b>$lead->email</b>";

	// Адрес и имя для отправки писем
	$config['mail']['smtp']['from']		= "noreply@thebestforum.ru";
	$config['mail']['smtp']['fromname']	= "TheBestForum";

	$config['ignore']['send_to_user']   = true;
	$config['mail']['smtp']['user']['subject'] 	= "Подтверждение заявки на участие в Форуме молодых миллионеров «Поволжье»";
	$config['mail']['smtp']['user']['message']  = $DefaultEmailMessage;