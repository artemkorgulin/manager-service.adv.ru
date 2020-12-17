<?php
	
if ($_POST['token'] == 'asdSqg44nun1NNsq12') {
	$message = urlencode($_REQUEST['message']);
	$phone = $_REQUEST['phone'];
	$var = file_get_contents ('http://gateway.api.sc/get/?user=Sinergi&pwd=dHsdpcr0&sadr=Synergy&dadr='.$phone.'&text='.$message);
	echo $var;
}

?>