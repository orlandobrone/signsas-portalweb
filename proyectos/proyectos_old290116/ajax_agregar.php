<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['client']) || empty($_POST['lugeje']) || empty($_POST['estado']) || empty($_POST['fecini'])|| empty($_POST['fecfin'])|| empty($_POST['cotiza'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	$fecini = explode("/", $_POST['fecini']);
	$fecini = date('Y-m-d', strtotime($fecini[2] . "-" . $fecini[1] . "-" . $fecini[0]));
	
	$fecfin = explode("/", $_POST['fecfin']);
	$fecfin = date('Y-m-d', strtotime($fecfin[2] . "-" . $fecfin[1] . "-" . $fecfin[0]));
	
	$sql = sprintf("INSERT INTO `proyectos` (nombre,descripcion,id_cliente,lugar_ejecucion,estado,fecha_inicio,fecha_final,id_cotizacion,id_centroscostos,id_regional,fecha) VALUES ('%s', '%s', %s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descri']),
		fn_filtro($_POST['client']),
		fn_filtro($_POST['lugeje']),
		fn_filtro($_POST['estado']),
		fn_filtro($_POST['fecini']),
		fn_filtro($_POST['fecfin']),
		fn_filtro($_POST['cotiza']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro($_POST['id_regional'])
	);
	
	

	if(!mysql_query($sql)){
		echo "Error al insertar un nuevo proyecto:\n$sql"; 
		exit;
	}
	
	$id_proyecto = mysql_insert_id();

	$sql = sprintf("UPDATE cotizacion SET estado='%s' where id=%d;",
		'otorgado',
		fn_filtro((int)$_POST['cotiza'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la cotización:\n$sql";
		
	$orden = str_replace(' ', '', $_POST['nombre']);		
	$sql = sprintf("INSERT INTO `orden_trabajo` (orden_trabajo,cliente,id_regional,id_centroscostos, id_proyecto) VALUES ('%s', '', '%s', '%s', '%s');",
		fn_filtro($orden),
		fn_filtro($_POST['id_regional']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro($id_proyecto)
	); 

	if(!mysql_query($sql))
		echo "Error al insertar OTs\n$sql";
	exit;
?>