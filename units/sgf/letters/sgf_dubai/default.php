<?php
$body = "
<h3>{$lead->name}, поздравляем!</h3>
<p>Вы&nbsp;зарегистрировались на&nbsp;{$lead->program}. Форум состоится в&nbsp;декабре 2017 года&nbsp;&mdash; совсем скоро мы&nbsp;сообщим точные даты.</p>
<p>Вас ждут выступления спикеров с&nbsp;мировым именем, панельная дискуссия, интенсивный нетворкинг и&nbsp;насыщенная культурная программа. Спасибо, что решили быть с&nbsp;нами!</p>
<p>Держите телефон под рукой: мы&nbsp;позвоним и&nbsp;подробно расскажем вам о&nbsp;том, как забронировать билеты на&nbsp;самолет и&nbsp;оплатить ваше участие в&nbsp;форуме.</p>
";

if ( $_REQUEST['lang'] == 'en' ) {
	$body = "
	<h3>{$lead->name}, congratulations!</h3>
	<p>You have signed up&nbsp;to&nbsp;the Synergy Global Forum Moscow 2017. Forum will be&nbsp;held 20-21 November 2017&nbsp;at CROCUS CITY HALL.</p>
	<p>Performances of&nbsp;the world-renown speakers, panel discussion about&nbsp;US business opportunities, intense networking and rich culture program are scheduled for you. Thank you for the decision to&nbsp;join&nbsp;us!</p>
	<p>Keep your phone at&nbsp;hand: we&rsquo;ll call to&nbsp;tell the details of&nbsp;how to&nbsp;book plane tickets and pay for your participation in&nbsp;the forum.</p>
	";
}

$letter = include 'template.php';
return $letter;