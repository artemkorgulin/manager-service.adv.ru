<?php
$config['mail']['smtp']['user']['subject'] = "Thank you for signing up for Synergy Global News Updates";

$config['user']['sendsuccess'] = "
<div class='send-success'>
	<p>
		Thank you! Redirecting to&nbsp;Ticketmaster
	</p>
</div>
<script>location.href = 'https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104';</script>
";

if(true){

		$message = "<div class='send-success'>
			<p>
				Thank you! <br>Please select your payment system:<br>
				<a href='https://www1.ticketmaster.com/synergy-global-forum-october-2728-2017-new-york-new-york/event/3B0052B2CD9B22DF?artistid=2375647&majorcatid=10005&minorcatid=104' target='_blank'><u>Ticketmaster</u></a>
			</p>
		</div>";

	

	

	if($lead->land == 'sgf2017_en_world' || $lead->land == 'sgf2017_en_university'){
		
		$message = "<div class='send-success'>
			<p>
				Thank you! We've sent you email which confirms your successful registration.  
			</p>
		</div>";

	}

	
	$config['user']['sendsuccess'] = $message;

}