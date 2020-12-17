<?php

$config = array(
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V',
    'nametable'  => 'transformation_view'
);

if ($_REQUEST['exportUpdate'] == true) {
	$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	if (isset($_REQUEST['email']) && $_REQUEST['email'] != '') {
		$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET view = 1  where email ='".$_REQUEST['email']."'");
	}
}

if ($_REQUEST['changeHide'] == true) {
	if ($_REQUEST['chechStatus'] == 1) {
		echo load(true,$config);
	} else {
		echo load(false,$config);
	}
}
if ($_REQUEST['updateRow'] == true) {
	if ($_REQUEST['id'] > 0) {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		if ($_REQUEST['statusView'] == 1) {
			$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET view = 1  where id =".$_REQUEST['id']);
		} else {
			$stmt = $pdo->query("UPDATE `".$config['nametable']."` SET view = 0  where id =".$_REQUEST['id']);
		}
	}
}
function load($hide,$config) {
try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		if ($hide) {
			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."`  order by id desc")->fetchAll();
		} else {
			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where view = 0  order by id desc")->fetchAll();
		}


		echo '  <div class="">
						<table id="tableexp" class="table table-striped table-bordered">
						<thead>
						<tr>
						   		<th >Имя</th>
								<th >Email</th>
								<th >Цена</th>
								<th >Дата оплаты</th>
					<th >Просмотрено</th>
					</tr>
        </thead> <tbody>';
        $table = '';
        foreach ($stmt as $row) {
        	$checkStatus = "checked";
			if ($row['view'] == 0) {
				$checkStatus = "";	
			} else {
				$checkStatus = "checked";
			}
			$table .= "<tr><td>".$row['name']."</td>
							<td>".$row['email']."</td>
							<td>".$row['price']."</td>
							<td>".$row['dateCreate']."</td>
							<td><input type='checkbox' class='checkView' data-id='".$row['id']."' ".$checkStatus."></td></tr>";
	
	

        }
        	return $table;

} catch(PDOException $e) {

}
}
?>