<?

	include "../../conexion.php";
	include "../extras/php/basico.php";
	/*verificamos si las variables se envian*/

	/*if(empty($_POST['id'])

		|| empty($_POST['hitos'])

		){

		echo json_encode(array('estado'=>false, 'message'=>"No han llegado todos los campos"));

		exit;

	}*/

	$sql = sprintf("INSERT INTO `apu_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s')", 
		fn_filtro($_POST['tipo_costo']), 
		fn_filtro($_POST['valor_a_la_fecha']),		
		'NOW()',
		fn_filtro($_POST['id_apu']),
		fn_filtro($_POST['costo_id'])
	);

	if(!mysql_query($sql)){
		//echo "Error al insertar un nuevo item:\n$sql";
		echo json_encode(array('estado'=>false, 'message'=>"Error al insertar un nuevo item:\n$sql"));
		exit;
	}else{
		echo json_encode(array('estado'=>true));
	}
?>