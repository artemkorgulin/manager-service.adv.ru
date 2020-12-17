<?php
	if ($userName == 'undefined') {
		$url = "Location: http://synergy.ru/students/pay_education?pay=ie";
		header($url);
		exit();
	}
	if ($productName == 'Из наемного в бизнесмены') {
  		header('Location: http://sbs.edu.ru/');
  		exit();
  	}

