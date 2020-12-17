<?php
$config['user']['sendsuccess'] = "
<div class='title-block'>
	<div class='formtitle'>Thank you!</div>
</div><!-- title-block -->
<div class='form-block'>
	We&rsquo;ll сontact you soon for planning your weekend in&nbsp;New York.
	<a href='https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104'><u>Click here</u></a> to&nbsp;buy the ticket.
</div><!-- form-block -->
";

if ( $_REQUEST['lang'] == 'ru' ) {
	$config['user']['sendsuccess'] = "
	<div class='title-block'>
		<div class='formtitle'>Спасибо!</div>
	</div><!-- title-block -->
	<div class='form-block'>
		В&nbsp;ближайшее время мы&nbsp;свяжемся с&nbsp;вами для&nbsp;планирования ваших выходных в&nbsp;Нью-Йорке.
	</div><!-- form-block -->
	";
}

$config['ignore']['send_to_user'] = false;