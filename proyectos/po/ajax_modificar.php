<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(	empty($_POST['id_po']) || 
		empty($_POST['no']) || 
		empty($_POST['fecha_inicio']) || 
		empty($_POST['fecha_final']) || 		
		empty($_POST['id_cliente'])
	){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
		
	$sql = sprintf("UPDATE po SET 
						no='%s', 
						fecha_inicio='%s', 
						fecha_final='%s', 
						valor_mantenimiento='%s' ,
						valor_suministro='%s' ,
						valor_total='%s',
						id_cliente='%s',
						estado='publish'   
					WHERE id=%d;",
					
		fn_filtro($_POST['no']),
		fn_filtro($_POST['fecha_inicio']),
		fn_filtro($_POST['fecha_final']),
		fn_filtro($_POST['valor_mantenimiento']),
		fn_filtro($_POST['valor_suministro']),
		fn_filtro(trim($_POST['valor_total'])),
		fn_filtro(trim($_POST['id_cliente'])),
		fn_filtro((int)$_POST['id_po'])
	);
	
	if(!mysql_query($sql))
		echo "Error al actualizar el P.O:\n$sql";				
	exit;
?>