<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	session_start();
	
	/*verificamos si las variables se envian*/
	if(empty($_REQUEST['idsalida']) || empty($_REQUEST['idhito']) || empty($_REQUEST['idproyecto'])){
		echo json_encode(array("estado"=>false,"msj"=>"Usted no a llenado todos los campos"));
		exit;
	}
	
	if($_REQUEST['ot_cliente'] != 'PENDIENTE'):
		$obj = new TaskCurrent;
		if( $obj->existOTinHito($_REQUEST['ot_cliente'],0) ):
			echo json_encode(array("estado"=>false,"msj"=>"La OT Cliente Ingresado ya existe"));
			exit;
		endif;
	endif;
	
	$sql = sprintf("INSERT INTO `reintegros` VALUES ('', %d, %d, %d, 0, now(), 1, %d);",
		fn_filtro($_REQUEST['idsalida']),
		fn_filtro($_REQUEST['idproyecto']),
		fn_filtro($_REQUEST['idhito']),
		fn_filtro($_SESSION['id'])
	);

	if(!mysql_query($sql))
		echo json_encode(array("estado"=>false,"msj"=>"Error al crear un reintegro"));
	else
		echo json_encode(array("estado"=>true, 'idreintegro'=>mysql_insert_id()));
	
	exit;
?>