<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['nombre']) || empty($_POST['descri']) || empty($_POST['client']) || empty($_POST['lugeje']) || empty($_POST['estado']) || empty($_POST['fecini'])|| empty($_POST['fecfin'])|| empty($_POST['cotiza'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/
	
	$qrCot1 = mysql_query("SELECT id_cotizacion FROM proyectos WHERE id='" . $_POST['id'] . "'");
	$qrCot2 = mysql_query("UPDATE cotizacion SET id_cotizacion = 'pendiente' WHERE id='" . $_POST['cotiza'] . "'");
	
	if($_REQUEST['estado'] != 'F'):
	
	$sql = sprintf("UPDATE proyectos SET nombre='%s', descripcion='%s', id_cliente=%s, lugar_ejecucion='%s', estado='%s', fecha_inicio='%s', fecha_final='%s', id_cotizacion=%s, id_centroscostos='%s', id_regional='%s' where id=%d;",
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descri']),
		fn_filtro($_POST['client']),
		fn_filtro($_POST['lugeje']),
		fn_filtro($_POST['estado']),
		fn_filtro($_POST['fecini']),
		fn_filtro($_POST['fecfin']),
		fn_filtro($_POST['cotiza']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro($_POST['id_regional']),
		fn_filtro((int)$_POST['id'])
	);
	
	else:
		
		$sql = sprintf("UPDATE proyectos SET nombre='%s', descripcion='%s', id_cliente=%s, lugar_ejecucion='%s', estado='%s', fecha_inicio='%s', fecha_final='%s', fecha_final_real = NOW(), id_cotizacion=%s, , id_centroscostos='%s', id_regional='%s' where id=%d;",
		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descri']),
		fn_filtro($_POST['client']),
		fn_filtro($_POST['lugeje']),
		fn_filtro($_POST['estado']),
		fn_filtro($_POST['fecini']),
		fn_filtro($_POST['fecfin']),
		fn_filtro($_POST['cotiza']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro($_POST['id_regional']),
		fn_filtro((int)$_POST['id'])
		);
			
	endif;
	
	
	if(!mysql_query($sql))
		echo "Error al actualizar el proyecto:\n$sql";
	
	$sql = sprintf("UPDATE cotizacion SET estado='%s' where id=%d;",
		'otorgado',
		fn_filtro((int)$_POST['cotiza'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la cotización:\n$sql";
		
		
	$orden = str_replace(' ', '', $_POST['nombre']);		
	$sql = sprintf("UPDATE `orden_trabajo` SET orden_trabajo='%s', id_regional='%s' ,id_centroscostos='%s' WHERE id_proyecto=%d;",
		fn_filtro($orden),
		fn_filtro($_POST['id_regional']),
		fn_filtro($_POST['centros_costos']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar la cotización:\n$sql";
				
	exit;
?>