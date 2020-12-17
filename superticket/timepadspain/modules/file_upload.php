<?php
	return '<!DOCTYPE html>
				<html>
					<head>
						<meta charset="utf-8"/>
						<title>Upload Files</title>
						<!--<link href="http://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700" rel="stylesheet" />-->
						<!--[if lt IE 9]><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script><![endif]-->
						<!--[if gte IE 9]><!--><script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script><!--<![endif]-->
						<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>
						<script src="sgf/timepadspain/js/scriptupload.js"></script>	
						<link href="sgf/timepadspain/css/uploadfile.css" rel="stylesheet">
					</head>
					<body>
						<div id="fileUpload">
							<input type="file" name="upl" id="fileupl" multiple="multiple"  accept=".pdf"/>
							<input type="hidden" name="fileupload" id="fileupload" value="'.$_REQUEST['fileupload'].'"/>
							<a href="#" id="loadfile">Загрузить</a>
						</div>
					</body>
			</html>';