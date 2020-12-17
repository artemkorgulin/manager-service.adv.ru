<?php
if (isset($_POST['email']) && $_POST['email'] != '') {
	$postData = [
		'email' 	    => $_POST['email'], 
		'name'  	    => $_POST['email'],
		'id' 		    => rand(0,3).time(),
		'land'  	    => 'manager',
		'ip' 		    => $_SERVER['REMOTE_ADDR'],
		'dateCreated' 	=> time(),
		'listId'	    => $_POST['forum'] 
	];	
	$response = cURLsend("https://syn.su/worker/daemon-expertsender.php",$postData);
	die($response);
}

function cURLsend($url,$postData) {
	$curl = curl_init($url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_FOLLOWLOCATION,true);
	if ($postData != false) {
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
	}
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	$response = curl_exec($curl);
	curl_close($curl);
	return $response;
}
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
	<title></title>
</head>
<body>
	<br><br><br>
<div class="container">	
<form action="#" id="formCreate">
<input type="text" class="form-control" id="InputEmail" name="email" placeholder="email">
<br>
<select class="form-control" id="forum">
	<option value="33">SDF</option>
	<option value="34">ART</option>
</select>
<br>
<input type="submit" class="form-control" name="Добавить">
</form>
<div id="result"></div>
<script type="text/javascript">
$(document).ready(function(){  
 	$('#formCreate').submit(function(){  
 		var postData = {"email":$("#InputEmail").val(),"forum":$("#forum").val()};
        $.ajax({
	          type: 'POST',
	          url: 'emailSave.php',
	          data: postData,
	          success: function(data) {
	            $('#result').html(data);
	          }
         });  
      	 return false;  
	});              
});  
</script>
</body>
</html>

