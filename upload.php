<?php
include 'conexion.php';

// A list of permitted file extensions
$allowed = array('png', 'jpg', 'gif','zip', 'pdf');

if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

	$extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

	if(!in_array(strtolower($extension), $allowed)){
		echo '{"status":"error"}';
		exit;
	}
	
	$file = rand(0, 15000).'_'.$_FILES['upl']['name'];
	
	if(move_uploaded_file($_FILES['upl']['tmp_name'], 'archivos/'.$file)){
		//echo  '{"status":"success", "id":"1020"}';
		$resultado = mysql_query("INSERT INTO `uploads` (
									`id` ,
									`file` ,
									`size` ,
									`fecha`
								   )
								   VALUES (
									NULL ,  '".$file."',  '".$_FILES['upl']['size']."',  now() );") or die(mysql_error());
		
		
		echo json_encode(array('status'=>'success', 'id'=>mysql_insert_id()));
		exit;
	}
}

echo '{"status":"error"}';
exit;