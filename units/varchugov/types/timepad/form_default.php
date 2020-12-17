<?php 

$config['ignore']['getresponse'] = false;
$config['ignore']['send_to_user']   = false;

$config['user']['sendsuccess'] = "<script>window.open('http://timepad.varchugov.dev02.synergy.ru/?name={$lead->name}&email={$lead->email}&phone={$lead->phone}&mergelead={$lead->mergelead}')</script>";
		
?>