<?php
	return '<!DOCTYPE html>
			<html>
				<head>
					<meta charset="utf-8"/>
					<title>Upload Tickets</title>
					<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet" />
					<!--[if lt IE 9]><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><![endif]-->
					<!--[if gte IE 9]><!--><script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--<![endif]-->
					<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
					<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.4.0/jszip.js"></script>
					<script src="sgf/timepadspain/js/script.js"></script>	
					<script src="sgf/timepadspain/js/jquery.knob.js"></script>
					<script src="sgf/timepadspain/js/jquery.ui.widget.js"></script>
					<script src="sgf/timepadspain/js/jquery.iframe-transport.js"></script>
					<script src="sgf/timepadspain/js/jquery.fileupload.js"></script>
					<script src="sgf/timepadspain/js/mprogress.min.js"></script>
					<script src="sgf/timepadspain/js/zepto.min.js"></script>
					<link href="sgf/timepadspain/css/style.css" rel="stylesheet" />
					<link href="sgf/timepadspain/css/style.css" rel="stylesheet" />
					<link href="sgf/timepadspain/css/mprogress.min.css" rel="stylesheet" />
				</head>
				<body>
				<div id="start"  style="width: 50%; margin: 150px auto; text-align: center;">
				<button id="start" class="great_btn" href="#">Start Upload</button>
				</div>
				<div id="dragdrop">
					<form id="upload" method="post" action="http://synergy.ru/lander/alm/intellectmoneyPay.php" enctype="multipart/form-data">
						<div id="drop">
							To uppload tickets, drag to this area files or select them on the computer by clicking the "browse".<br>
							<a>browse</a>
							<input type="file" name="upl" multiple />
							<input type="hidden" name="startId" id="startId" />
							<input type="hidden" name="ticketsupload" value="'.$_REQUEST['ticketsupload'].'"/>
						</div>
						<ul>						
						</ul>
					</form>
					<div id="addTicket"  style="width:300px; height:300px; margin:auto; text-align: center">
						<form id ="create" method="post" action="http://synergy.ru/lander/alm/intellectmoneyPay.php">
							<input type="hidden" name="addTicketets" id="finishId" />
							<input type="hidden" name="ticketsupload" value="'.$_REQUEST['ticketsupload'].'" />
							<a id="finish" href="#" >Finish Upload</a>
							<div id="progress" class="demo-bar mprogress-custom-parent"></div>
							</div>
						</form>
					</div>
				</body>
			</html>';