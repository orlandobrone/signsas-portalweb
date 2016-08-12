<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['codigo']) || empty($_POST['nombre_sitio']) || empty($_POST['cliente']) || empty($_POST['ot_ticket']) || empty($_POST['id_hito']) || empty($_POST['nombre_documentador']) || empty($_POST['fecha_ejecucion_editable'])){
		$array = array('estado'=>false,'error'=>'No haz llenado todo los campos');
		exit;
	}
	
		
	$sql = sprintf("INSERT INTO `documental` (fecha_creacion,codigo_sitio,nombre_sitio, actividad, cliente,ot_tickets,hito_id,nombre_documentador,fecha_ejecucion_editable,detalle_actividad) VALUES (NOW(), '%s', '%s', '%s', '%s', '%s',%d,'%s','%s','%s');",
		fn_filtro($_POST['codigo']),
		fn_filtro($_POST['nombre_sitio']),
		fn_filtro($_POST['actividad'].'-'.$_POST['subactividad']),
		fn_filtro($_POST['cliente']),
		fn_filtro($_POST['ot_ticket']),
		fn_filtro($_POST['id_hito']),
		fn_filtro($_POST['nombre_documentador']),
		fn_filtro($_POST['fecha_ejecucion_editable']),
		fn_filtro($_POST['detalle_actividad'])
	);

	if(!mysql_query($sql)):
		$array = array('estado'=>false,'error'=>'error de sql');
	else:
		$ultimo = mysql_insert_id();
		$obj = new TaskCurrent();
		$obj->setLogEvento('Documental',$ultimo,'CREADO');
		$array = array('estado'=>true,'id'=>$ultimo);
	endif;
	
	echo json_encode($array);		
		
		
	exit;
?>