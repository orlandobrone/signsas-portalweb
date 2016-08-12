<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(	empty($_POST['id_proyecto']) || 
		empty($_POST['id_po']) ||
		empty($_POST['id_cliente']) ||
		empty($_POST['id_ingreso']) 
	){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("UPDATE ingresos SET 
										id_proyecto='%s', 
										id_po='%s', 
										gr='%s',
										id_cliente='%s',
										estado='publish'   
					WHERE id=%d;",
					
		fn_filtro($_POST['id_proyecto']),
		fn_filtro($_POST['id_po']),
		fn_filtro($_POST['gr']),
		fn_filtro($_POST['id_cliente']),
		fn_filtro((int)$_POST['id_ingreso'])
	);
	
	if(!mysql_query($sql))
		echo "Error al actualizar el P.O:\n$sql";	 		
	exit;
?>