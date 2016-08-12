<?
	include "../../conexion.php";
	include "../extras/php/basico.php";

	
	/*verificamos si las variables se envian*/

	if( empty($_POST['descri']) || empty($_POST['estado']) || empty($_POST['fecini'])|| empty($_POST['fecfin'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}

	

	/*modificar el registro*/
	if( $_REQUEST['estado'] != 'E'):
	
		$sqlr = "SELECT estado FROM hitos WHERE id_proyecto = ".$_POST['id'];
		$pair = mysql_query($sqlr); 
		
		$pendientes = 0;
		$liquidado = 0;
		
		while($rs_pair = mysql_fetch_assoc($pair)):
			
			switch($rs_pair['estado']):
				case 'PENDIENTE':
				case 'EN EJECUCION':
				case 'INFORME ENVIADO':
					$pendientes++;
				break;
				case 'LIQUIDADO':
					$liquidado++;
				break;
			endswitch;
			
		endwhile;
		
		if($pendientes > 0 || $liquidado > 0):
			echo 'No se puede facturar el proyecto, existe #Hitos pendientes: '.$pendientes.', #Hitos Liquidados: '.$liquidado;
			exit;
		endif;

	endif;

	$sql = sprintf("UPDATE proyectos SET  descripcion='%s', estado='%s', fecha_inicio='%s', fecha_final='%s' WHERE id=%d;",

		fn_filtro($_POST['descri']),

		fn_filtro($_POST['estado']),

		fn_filtro($_POST['fecini']),

		fn_filtro($_POST['fecfin']),

		fn_filtro((int)$_POST['id'])

	);

	
	if(!mysql_query($sql))

		echo "Error al actualizar el proyecto:\n$sql";
		
	if($_POST['estado'] != 'ELIMINADO'){
	
		$sql = sprintf("UPDATE `orden_trabajo` SET estado = 0 WHERE id_proyecto=%d",
			(int)$_POST['id']
		);
		if(!mysql_query($sql))
			echo "Ocurrio un error\n$sql";
	}


	/*$orden = str_replace(' ', '', $_POST['nombre']);		

	$sql = sprintf("UPDATE `orden_trabajo` SET orden_trabajo='%s', id_regional='%s' ,id_centroscostos='%s' WHERE id_proyecto=%d;",

		fn_filtro($orden),

		fn_filtro($_POST['id_regional']),

		fn_filtro($_POST['centros_costos']),

		fn_filtro((int)$_POST['id'])

	);

	if(!mysql_query($sql))
		echo "Error al actualizar la cotización:\n$sql";*/

				

	exit;

?>