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

     $('.checkView').change(function() {
     	var statusView= false;

         var msg = {"updateRow":"true","id":$(this).attr('data-id'),"statusView":this.checked-0};

    	 $.ajax({
	          type: 'POST',
	          url: 'transformViewRes.php',
	          data: msg,
	          success: function(data) {
	

	          }
         }); 
    });
    $('#hideCheck').change(function() {

    	var msg = {"changeHide":"true","chechStatus":this.checked-0};
    	 $.ajax({
	          type: 'POST',
	          url: 'transformViewRes.php',
	          data: msg,
	          success: function(data) {
	
	        
	        	
	              $('#result').html(data);
	               $('#tableexp').DataTable( {
				        dom: 'Bfrtip',
				        buttons: [
				            'copy', 'csv', 'excel', 'pdf', 'print'
				        ]
				    } );

	                  $('.checkView').change(function() {
     	var statusView= false;

         var msg = {"updateRow":"true","id":$(this).attr('data-id'),"statusView":this.checked-0};

    	 $.ajax({
	          type: 'POST',
	          url: 'transformViewRes.php',
	          data: msg,
	          success: function(data) {
	

	          }
         }); 
    });

	          }
         });  
    });
	$('a').click(function(){
	  if ($(this).attr('class') == 'dt-button buttons-excel buttons-html5 processing') {
	  	var table = $('#tableexp').DataTable();
 
		var data = table
		    .rows()
		    .data();
		for (var i = 0; i <data.length; i++) {
			var msg = {"updateRow":"true","email":data[i][1],"exportUpdate":true};
			$.ajax({
	          type: 'POST',
	          url: 'transformViewRes.php',
	          data: msg,
	          success: function(data) {
	          }
         	}); 
		}
	  }
	});



} );
	</script>
	Показывать все <input type="checkbox" id="hideCheck" > <br>  
	<div id="result">
<?php
$config = array(
    'host' 	     => 'localhost',
    'name' 	     => 'lander',
    'user' 	     => 'lander_user',
    'password'   => 'PRp26V',
    'nametable'  => 'transformation_view'
);


echo load(true,$config);
function load($hide,$config) {
try {
		$pdo = new PDO("mysql:host={$config['host']};dbname={$config['name']}", $config['user'], $config['password'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		if ($hide) {
			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."` where view =0 order by id desc")->fetchAll();
		} else {
			$stmt = $pdo->query("SELECT * FROM `".$config['nametable']."`   order by id desc")->fetchAll();
		}
		echo '  <div class="">
						       
						<table id="tableexp" class="table table-striped table-bordered">
						<thead>
						<tr>
						   		<th >Имя</th>
								<th >Email(платежный)</th>
								<th >Email(из формы)</th>
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
							<td>".$row['email2']."</td>
							<td>".$row['price']."</td>
							<td>".$row['dateCreate']."</td>
							<td><input type='checkbox' class='checkView' data-id='".$row['id']."' ".$checkStatus."></td></tr>";
	
	

        }
        	return $table;

} catch(PDOException $e) {

}
}
?>
</div>