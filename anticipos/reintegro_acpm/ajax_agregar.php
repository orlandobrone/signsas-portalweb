<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

/*verificamos si las variables se envian*/

	session_start();

	if(empty($_POST['id_anticipo'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$query = "INSERT INTO anticipo (fecha,prioridad,nombre_responsable,cedula_responsable,id_regional,id_centroscostos,giro,v_cotizado,total_anticipo,banco,tipo_cuenta,num_cuenta,cedula_consignar,beneficiario,observaciones,id_ordentrabajo,id_usuario,id_legalizacion,estado,fecha_edit,publicado,fecha_aprobado,tipo_banco,banco_trans) 
SELECT fecha,prioridad,nombre_responsable,cedula_responsable,id_regional,id_centroscostos,giro,v_cotizado,total_anticipo,banco,tipo_cuenta,num_cuenta,cedula_consignar,beneficiario,observaciones,id_ordentrabajo,id_usuario,id_legalizacion,estado,fecha_edit,publicado,fecha_aprobado,tipo_banco,banco_trans FROM anticipo AS a WHERE a.id = ".(int)$_POST['id_anticipo'];

	if(!mysql_query($query)){
		echo "Error al insertar la nueva asosaci&oacute;n:\n$query"; 
		exit;
	}	
	$ultimo_id = mysql_insert_id(); 	
	
	$query = "UPDATE `anticipo` SET  `prioridad` = 'GIRADO', fecha_creacion = NOW() WHERE `id` = ".(int)$ultimo_id;
	mysql_query($query);
		
	// ingresa en la tabla de reintegros de ACPM
	$sql = sprintf("INSERT INTO `reintegros_acpm` (id_reintegro_anticipo,id_aplicado_anticipo,galones,id_user,fecha_creacion) VALUES (%d,%d,%d,%d,NOW());",
		fn_filtro($ultimo_id),
		fn_filtro($_POST['id_anticipo']),
		fn_filtro($_POST['CantGalones']),
		fn_filtro($_SESSION['id'])
	);
	if(!mysql_query($sql))
		$data = array( 'estado' => false,'msj' => "Error al insertar un nuevo reintro ACPM:\n$sql");
	else
		$data = array( 'estado' => true, 'idreintegro' => mysql_insert_id(), 'idanticipogirado' => $ultimo_id);
		
	echo json_encode($data);
	exit;

?>