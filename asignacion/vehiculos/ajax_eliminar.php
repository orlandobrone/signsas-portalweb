<?

	include "../../conexion.php";
	include "../extras/php/basico.php";


	$sql1 = "SELECT * FROM vehiculos WHERE id = ".(int)$_POST['id'];
	$pai1 = mysql_query($sql1); 
	$row = mysql_fetch_assoc($pai1);


	foreach(unserialize($row['planillas']) as $file){

		if($file != 'undefined'):

			  $sql4 = "SELECT file FROM `uploads` WHERE id = ".$file;
			  $pai4 = mysql_query($sql4); 
			  $rs_pai4 = mysql_fetch_assoc($pai4);
	
			  $dir = "../../archivos/".$rs_pai4['file'];
	
			  if(file_exists($dir)){ 
				unlink($dir); 
			  } 
			  mysql_query("delete from uploads where id=".$file);
		endif;
	}

	
	$sql = sprintf("UPDATE `vehiculos` SET estado = 3 WHERE id=%d",
		(int)$_POST['id']
	);
	

	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";

	exit;

?>