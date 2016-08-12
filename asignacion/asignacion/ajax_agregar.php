<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$obj = new TaskCurrent;

	$sqlPryA = "SELECT a.hora_inicio, a.hora_final, t.cargo AS cargo_tecnico, t.estado AS estado_tecnico 
				FROM asignacion AS a 
				LEFT JOIN tecnico AS t ON a.id_tecnico = t.id  
				WHERE a.fecha_ini = '".$_POST['fecini']."' AND a.id_tecnico = ".$_POST['tecnicos']; 
	$qrPryA = mysql_query($sqlPryA);
	$filas = mysql_num_rows($qrPryA);
	
	
	$sqlt = "SELECT estado FROM tecnico WHERE id = ".$_POST['tecnicos']; 
	$qrt = mysql_query($sqlt);
	$rst = mysql_fetch_assoc($qrt);
	
	if( $rst['estado'] == 0 ):
		echo "El técnico seleccionado esta Inactivo.";
		exit;
	endif;
	
	
	if($filas > 0):
		
		while($rsPryA = mysql_fetch_assoc($qrPryA)):	
			
			if($rsPryA['cargo_tecnico'] == 'CONTRATISTA')
				break;				
			//echo $rsPryA['hora_inicio'].'-'.$rsPryA['hora_final'].'<br>';
			// Verifica si la hora de inicio esta dentro del rango
			if($obj->dentro_de_horario($rsPryA['hora_inicio'],$rsPryA['hora_final'],$_POST['hora_inicio']) == 1):
				echo "La hora de inicio ya fue asignada en el rango de trabajo del tecnico. ";
				exit;
			endif;
			
			// Verifica si la hora final esta dentro del rango
			if($obj->dentro_de_horario($rsPryA['hora_inicio'],$rsPryA['hora_final'],$_POST['hora_final']) == 1):
				echo "La hora final ya fue asignada en el rango de trabajo del tecnico. ";
				exit;
			endif;
						
		endwhile;
	endif;

	

	/*verificamos si las variables se envian*/

	//if(empty($_POST['fecini']) || empty($_POST['fecfin'])){
	if(empty($_POST['fecini'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}
	
	
	
	$horastrab = $obj->calcular_horas($_POST['hora_final'],$_POST['hora_inicio']);
	
	if($_POST['almuerzo'])
		$horastrab-=1;
	

	$libre = $_POST['disponible'];
	
	if($_POST['vehiculos'] != ''):


		$sql = sprintf("INSERT INTO `asignacion` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s' , '%s', '%s' , '%s', %s, NOW(), 0 );",

			fn_filtro($_POST['hitos']),

			fn_filtro($_POST['tecnicos']),

			fn_filtro($_POST['vehiculos']),

			fn_filtro($_POST['id_ordonetrabajo']),

			fn_filtro($libre),

			fn_filtro($_POST['observacion']),

			fn_filtro($_POST['fecini']),

			fn_filtro($_POST['fecfin']),

			fn_filtro($_POST['hora_inicio']),

			fn_filtro($_POST['hora_final']),
			
			fn_filtro($horastrab)

		);

	

	else:

		

		$sql = sprintf("INSERT INTO `asignacion` VALUES ('', '%s', '%s', '0', '%s', '%s', '%s', '%s' , '%s','%s','%s',%s,NOW(), 0);",

			fn_filtro($_POST['hitos']),

			fn_filtro($_POST['tecnicos']),

			fn_filtro($_POST['id_ordonetrabajo']),

			fn_filtro($libre),

			fn_filtro($_POST['observacion']),

			fn_filtro($_POST['fecini']),

			fn_filtro($_POST['fecfin']),

			fn_filtro($_POST['hora_inicio']),

			fn_filtro($_POST['hora_final']),
			
			fn_filtro($horastrab)

		);

	endif;

	if(!mysql_query($sql)){
		echo "Error al insertar la nueva asosaci&oacute;n:\n$sql";
		exit;
	}
	
	if($obj->setTempDelModulo(mysql_insert_id(),'Asignaciones'))
		echo "Error en el set temp delte"; exit; 
		
	$sqlPry = "SELECT fecha_inicio_ejecucion AS fecha FROM hitos WHERE id = ".$_POST['hitos']; 
	$qrPry = mysql_query($sqlPry);
	$rsPry = mysql_fetch_assoc($qrPry);
	
	if($_POST['fecini']<$rsPry['fecha'] || empty($rsPry['fecha'])){
		$sql = "UPDATE hitos SET fecha_inicio_ejecucion = '".$_POST['fecini']."' WHERE id = ".$_POST['hitos'];
		
		if(!mysql_query($sql))
			echo "Ocurrio un error\n$sql";
	}

	exit;

?>