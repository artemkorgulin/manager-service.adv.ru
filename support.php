<?php 
   if (isset($_GET['ref'])) {
		die("Спасибо. Заявка создана.
	<script>setTimeout('window.location = \"".$_GET['ref']."\";', 3000);</script>");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Сообщить о проблеме</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<style>.form-control{margin-bottom:13px}</style>
<body>
<div class="container">
<div class="row">
 <div class="col-xs-12 col-sm-12 col-md-4 col-md-offset-4 well well-sm">
 <legend>Сообщить о проблеме</legend>
 <form action="https://syn.su/-sd-/api/createTask.php" method="post" class="form" role="form">
	 <input class="form-control" name="name" placeholder="Имя" type="text" required="required"/>
	 <input class="form-control" name="email" placeholder="Email" type="text" required="required"/>
	 <input type="hidden" name="tId" value="1102" />
	 <input type="hidden" name="type" value="form" />
	 <!--<input class="form-control" name="tTask" placeholder="Сообщение" type="text" />-->
	 <textarea name="Task" id="message" class="form-control" rows="9" cols="25" required="required" placeholder="Сообщение"></textarea>
	 <input type="hidden" name="sId" value="264"/>
	 <input type="hidden" name="cId" value="<?=$_GET['cId']?>"/>
	 <div class="g-recaptcha" data-sitekey="6LduhnIUAAAAAAZ_HenHHv2gYiHczVb78hWFkLf-"></div>
	 <button class="btn btn-lg btn-primary btn-block" type="submit">Отправить</button>
 </form>
 </div>
 </div>
</body>
</html>