<?

	include "../../conexion.php";

	include "../../ingreso_mercancia/extras/php/basico.php";

	

	if(!empty($_POST['id'])):	

	

		$id = (int)$_POST['id'];

		

		$sql = mysql_query("  SELECT aprobado
							  FROM materiales 
							  WHERE id_despacho = ".$id,$con) or

		die("Problemas en la base de datos:".mysql_error());


		$eliminar = true;

		while($row = mysql_fetch_array($sql)):
				if($row['aprobado'] == 1):
					$eliminar = false;
				endif;
		endwhile;

		

		if($eliminar):
		
			$sql = sprintf("UPDATE `solicitud_despacho` SET estado = 'ELIMINADO' WHERE id=%d",
				(int)$_POST['id']
			);	
			if(!mysql_query($sql))
				echo "Ocurrio un error\n$sql";
				
			
			$sql = sprintf("UPDATE `materiales` SET estado = 1 WHERE id=%d",(int)$_POST['id']);
			if(!mysql_query($sql))
				echo "Ocurrio un error\n$sql";

			exit;

		else:

			echo 'No se puede eliminar este despacho, ya fue aprobado';			

		endif;

	

	endif;

?>