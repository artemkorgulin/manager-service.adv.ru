<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.4.2/js/dataTables.buttons.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.flash.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.html5.min.js"></script>
  <script src="//cdn.datatables.net/buttons/1.4.2/js/buttons.print.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.2/css/buttons.dataTables.min.css">
 </head>
  <body>
	<script type="text/javascript">
		$(document).ready(function() {
    $('#tableexp').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );




} );
	</script>
	<div id="result">
<?php

$tablename = 'transformReports';
switch ($_REQUEST['table']) {
    case 1:
    case 2:
    case 3:
    case 4:
    case 5:
    case 6:
      $tablename = 'transformReports2';
    break;
  case 7:
      $tablename = 'transformReports';
    break;
  case 8:
      $tablename = 'transformReports3';
    break;
}


$config = array(
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V',
    'nametable'  => $tablename
);


echo load(true,$config);
function load($hide,$config) {
try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      $sql = "SELECT * FROM `".$config['nametable']."`  order by id desc";
      if ($_REQUEST['table'] < 7) {
        $sql ="SELECT * FROM `".$config['nametable']."` where category = '".$_REQUEST['table']."' order by id desc";
      }

			$stmt = $pdo->query($sql)->fetchAll();

		echo '  <div class="">
						       
						<table id="tableexp" class="table table-striped table-bordered">
						<thead>
						<tr>
						   	<th>Имя</th>
                <th>Фамилия</th>
								<th>Телефон</th>
								<th>Email</th>
								<th>ИНН</th>
								<th>Организация</th>
                <th>Дата регистрации</th>
					</tr>
        </thead> <tbody>';
        $table = '';
        foreach ($stmt as $row) {
    			$table .= "<tr><td>".$row['name']."</td>
                  <td>".$row['surname']."</td>
    							<td>".$row['phone']."</td>
    							<td>".$row['email']."</td>
    							<td>".$row['inn']."</td>
    							<td>".$row['orgname']."</td>
                  <td>".$row['createTime']."</td></tr>";
        }
        return $table;

} catch(PDOException $e) {

}
}
?>
</div>