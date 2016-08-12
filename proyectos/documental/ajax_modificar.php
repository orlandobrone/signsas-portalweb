<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['codigo']) || empty($_POST['nombre_sitio']) || empty($_POST['cliente']) || empty($_POST['ot_ticket']) || empty($_POST['id_hito']) || empty($_POST['nombre_documentador']) || empty($_POST['fecha_ejecucion_editable'])){
		$array = array('estado'=>false,'error'=>'No haz llenado todo los campos');
		exit;
	}
	
		
	$sql = sprintf("UPDATE documental SET codigo_sitio='%s', nombre_sitio='%s', actividad='%s', cliente='%s', ot_tickets='%s', hito_id='%s', nombre_documentador='%s' ,fecha_ejecucion_editable='%s', estado=%d WHERE id=%d;",
		fn_filtro($_POST['codigo']),
		fn_filtro($_POST['nombre_sitio']),
		fn_filtro($_POST['actividad']),
		fn_filtro($_POST['cliente']),
		fn_filtro($_POST['ot_ticket']),
		fn_filtro($_POST['id_hito']),
		fn_filtro($_POST['nombre_documentador']),
		fn_filtro($_POST['fecha_ejecucion_editable']),
		fn_filtro($_POST['cambio_estado']),
		fn_filtro($_POST['id'])
	);
	
	
	if(!mysql_query($sql))
		echo "Error al actualizar el sitio:\n$sql";
		
		
    $obj = new TaskCurrent();
    $obj->setLogEvento('Documental',$_POST['id'],'MODIFICADO');				
	exit;
?>