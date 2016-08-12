<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['nombre']) || empty($_POST['descri']) || 
		
		empty($_POST['client']) || 
		empty($_POST['id_regional']) ||
		empty($_POST['actividad']) ||
		empty($_POST['subactividad']) ||
		empty($_POST['mes']) ||		
		
		empty($_POST['lugeje']) ||
	    empty($_POST['fecini']) || empty($_POST['fecfin']) ){

			echo "Usted no a llenado todos los campos";
		exit;
	}

	//inicia el estado en ejecucion
	$_POST['estado'] = 'E';

	$fecini = explode("/", $_POST['fecini']);
	$fecini = date('Y-m-d', strtotime($fecini[2] . "-" . $fecini[1] . "-" . $fecini[0]));	

	$fecfin = explode("/", $_POST['fecfin']);
	$fecfin = date('Y-m-d', strtotime($fecfin[2] . "-" . $fecfin[1] . "-" . $fecfin[0]));
	
	
	$sql = "SELECT numero FROM proyectos 
			WHERE mes = '".$_POST['mes']."' AND id_regional = ".$_POST['id_regional']." ORDER BY numero DESC LIMIT 1";
	$pai = mysql_query($sql);
	$rs_pai = mysql_fetch_assoc($pai);
	$ultimoNumero = $rs_pai['numero'] + 1;	
	
	if($ultimoNumero <= 9){
		$ultimoNumero = '0'.$ultimoNumero;
	}
	
	
	$_POST['nombre'] = substr($_POST['nombre'],0, -1);
	$_POST['nombre'] = $_POST['nombre'].''.$ultimoNumero;
	
	$sql = sprintf("INSERT INTO `proyectos` (nombre,descripcion,id_cliente,lugar_ejecucion,estado,fecha_inicio,fecha_final,id_cotizacion,id_centroscostos,id_regional,fecha, linea_negocio_id,actividad_id,mes,numero) VALUES ('%s', '%s', %s, '%s', '%s', '%s', '%s', '%s', '%s', '%s', now(), %d,%d,'%s',%d);",

		fn_filtro($_POST['nombre']),
		fn_filtro($_POST['descri']),
		fn_filtro($_POST['client']),
		fn_filtro($_POST['lugeje']),
		fn_filtro($_POST['estado']),
		fn_filtro($_POST['fecini']),
		fn_filtro($_POST['fecfin']),

		fn_filtro(0),
		fn_filtro($_POST['actividad']),

		fn_filtro($_POST['id_regional']),		
		fn_filtro($_POST['actividad']),
		fn_filtro($_POST['subactividad']),
		fn_filtro($_POST['mes']),
		fn_filtro($ultimoNumero)
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

		fn_filtro($_POST['actividad']),

		fn_filtro($id_proyecto)

	); 



	if(!mysql_query($sql))

		echo "Error al insertar OTs\n$sql";

	exit;

?>