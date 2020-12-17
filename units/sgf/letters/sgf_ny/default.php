<?php
$body = "
<h3>Здравствуйте!</h3>
<p>Мы заметили, что Вы проявили интерес к курсу «Бизнес в Америке. Инструкция по применению», но не оформили заявку. Чтобы вернуться на сайт, просто перейдите по этой <a href='http://synergyglobal.com/usa' target='_blank'>ссылке</a>.</p>
<p><b>Из курса вы узнаете:</b></p>
<ul>
	<li>Как привлечь венчурные инвестиции, бизнес-ангелов и попасть в акселератор</li>
	<li>Как выбрать нишу и зарегистрировать компанию</li>
	<li>Почему стоит выбрать Остин и Даллас, а не Силиконовую долину</li>
	<li>Как выбрать стратегию управления компанией</li>
	<li>Как избежать основных ошибок, убивающих бизнес</li>
</ul>
<p>
	В ближайшее время мы свяжемся с Вами и расскажем обо всех особенностях программы обучения.
</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<div><a href='http://synergyglobal.com'><img src='http://synergyglobal.com/img/letters/share.jpg' alt='' style='width: 100%; margin: auto;'></a></div>
	<h3>Dear {$lead->name},</h3>
	<p>Thank you for your interest in&nbsp;the <a href='http://synergyglobal.com' target='_blank'>Synergy Global Forum New York 2017</a>!</p>
	<p>The Forum is&nbsp;a&nbsp;once-in-a-lifetime opportunity to&nbsp;see world-renowned speakers and lively panel discussions, network with business leaders, and enjoy the cultural riches of&nbsp;New York City.</p>
	<p>Tickets are limited and prices will rise, so&nbsp;don&rsquo;t wait to&nbsp;get your seats!</p>
	<a href='http://synergyglobal.com/#download-program' target='_blank'>&gt;&gt;&gt; Download the agenda &lt;&lt;&lt;</a><br>
	<a href='http://synergyglobal.com/?click={a[href=%22%23compare-packages%22]}' target='_blank'>&gt;&gt;&gt; Compare the Ticket Options &lt;&lt;&lt;</a><br>
	";
}

elseif ( $_REQUEST['lang'] == 'es' ) {
	$body = "
	<h3>&iexcl;{$lead->name}, felicidades!</h3>
	<p>Se&nbsp;ha&nbsp;registrado en&nbsp;Synergy Global Forum New York 2017. El&nbsp;F&oacute;rum se&nbsp;celebrar&aacute; el&nbsp;27-28&nbsp;de octubre de&nbsp;2017&nbsp;en Madison Square Theater.</p>
	<p>Le&nbsp;esperan discursos de&nbsp;ponentes mundialmente conocidos, un&nbsp;panel de&nbsp;discusi&oacute;n sobre oportunidades empresariales de&nbsp;los EEUU, un&nbsp;intensivo networking y&nbsp;un&nbsp;denso programa cultural. &iexcl;Gracias por su&nbsp;decisi&oacute;n de&nbsp;estar con nosotros!</p>
	<p>Mantenga su&nbsp;tel&eacute;fono al&nbsp;alcance de&nbsp;la&nbsp;mano: le&nbsp;llamaremos para informar en&nbsp;detalle de&nbsp;c&oacute;mo reservar billetes de&nbsp;avi&oacute;n y&nbsp;pagar su&nbsp;participaci&oacute;n.</p>
	<p>¡Hasta pronto!</p>
	";
}
if ( $lead->land == 'rusbz' &&  $lead->form == 'course-programm' ) {
$body = "
	<h3>Спасибо за заинтересованность!</h3>
	<p>Во вложении учебный план онлайн-курса  <a href='https://synergyglobal.com/usa/pdf/schedule-curriculum.pdf' target='_blank'>Русский бизнес в Америке</a> <br>
	Надеемся на скорую встречу!</p>
	";
}
if ( $lead->land == 'sgf2018_sid' ) {
$body = "
	<p>Thank you for your interest in Synergy Inspiration Day!</p>
	<p>We appreciate your interest in one-day event with World's Top Motivational Speakers: Les Brown, Nick Vujicic and Marshall Goldsmith in Pier 60, Chelsea Piers, New York, on June 17th, Sunday.</p>
	<p>Synergy Inspiration Day is an engaging program where participants develop the skills required to create a crucial work culture of trust and influence that immediately engages team members and accelerates business results as well as enhance emotional intelligence and improve life achievement.</p>
	<p>Enjoy and expand your emotional intelligence!</p>
	<p>We would like to evaluate this distinguished 1-day Master Classes and our behavior-change process. We are thrilled to invite you, your colleagues, friends and families to attend the event.</p>
	<p>Best regards,<br>Synergy Global Forum Team</p>
	";
} elseif ($lead->land == 'rusbz_kz') {
	$body = "
	<h3>Здравствуйте, {$lead->name}!</h3>
	<p>Мы заметили, что Вы проявили интерес к курсу «Бизнес в Америке», но не оформили заявку. Чтобы вернуться на сайт, просто перейдите по <a href='http://synergyglobal.com/kz'>этой ссылке</a>.</p>
	<p>Из курса вы узнаете:</p>
	<ul>
		<li>Как выбрать нишу и зарегистрировать компанию</li>
		<li>Как выгодно арендовать недвижимость и оборудование</li>
		<li>Как привлечь инвестиции в свой стартап и выйти в прибыль</li>
		<li>Почему стоит выбрать Остин и Даллас, а не Силиконовую долину</li>
		<li>Как найти лучших специалистов и не переплатить</li>
		<li>Как избежать основных ошибок, убивающих бизнес</li>
	</ul>
	<p>В ближайшее время мы свяжемся с Вами и расскажем обо всех особенностях программы обучения.</p>
	";
} elseif ($lead->land == 'sgf-business-mission') {
	$body = "
	<img src='https://i.imgur.com/DayaDn1.jpg' style='width:600px; max-width:100%;'>
	<br>
	<h3>Привет, {$lead->name}!</h3>	
	<p>Вы оставили заявку на участие в бизнес-миссии в США.</p>
	<a href='https://drive.google.com/file/d/1JMAd7knJSjDc8xEaZEmBKdRU5Bn-OmQk/view?usp=sharing' target='_blank'>Подробную программу миссии смотрите по этой ссылке</a>
	<p>Это значит, вы готовы посетить с нами бoгaтейшие компании Америки и мира, учиться в лучших бизнес-школах, чтобы внедрить их опыт и технологии в свой бизнес.</p>
	<p>Поэтому ровно 5 дней, начиная с этого момента, для вас дeйствует самая выгoдная цeна на участие в миссии:</p>
	<ul>
		<li>Cкидка 2100 дoллaров от стоимости поездки;</li>
		<li>Возможность зафиксировать цeну со cкидкoй небольшой предoплaтой в 2000 дoллaров.</li>	
	</ul> 
	<p>Oплaтить участие можно нaличным рaсчeтом и по счeту, все детали расскажет менеджер в ближайшее время.</p>
	<p>С уважением, Школа Бизнеса Синергия</p>
	";
}

$letter = include 'template.php';
return $letter;
