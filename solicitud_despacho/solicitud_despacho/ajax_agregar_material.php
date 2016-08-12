<?

	include "../../conexion.php";

	include "../../ingreso_mercancia/extras/php/basico.php";

	

	/*verificamos si las variables se envian*/

	if(empty($_POST['material']) || empty($_POST['id_despacho']) ){

		echo "Usted no a llenado todos los campos"; 

		exit;

	}
	
	if($_POST['presupuesto'] <= 0){
		echo "El presupuesto debe ser mayor a 0"; 
		exit;
	}


	$search  = array('.', '$', ',');
	$replace = array('');	

	$costo = str_replace($search, $replace, $_POST['costo_solicitado']);
	$presupuesto = (!empty($_POST['presupuesto']))? str_replace($search, $replace, $_POST['presupuesto']):0;


	/*if($_POST['cantidadPendiente'] > 0 ):	

			

		$sqlMat = sprintf("SELECT * FROM inventario WHERE id = ".$_POST['material']);

		$perMat = mysql_query($sqlMat);

		$rs_per_mat = mysql_fetch_assoc($perMat);

	

		$estado = 3; // Pendiente

		

		

		//$para = "ingsistemas.ordonez@gmail.com";

		$para = "andrea.rojas@signsas.com, ivan.conrado@signsas.com";



		// subject

		$titulo = 'Material Pendiente';

		

		// message

		$mensaje = '

		<html>

		<head>

		  <title>Se ingreso un excedente de material</title>

		</head>

		<body>

		  <p>Material: '.$rs_per_mat['nombre_material'].'</p>

		  <p>Cantidad Pendiente: '.$_POST['cantidadPendiente'].'</p>	

		  <p>Cantidad Existente: '.$rs_per_mat['cantidad'].'</p>	

		  <p>Costo Inventario: '.$rs_per_mat['costo_unidad'].'</p>	  

		  <p>Descripción: '.$rs_per_mat['descripcion'].'</p>	

		  <p>Observación: '.$_POST['observacion'].'</p>	  
		  
		  <p>ID Hito: '.$_POST['id_hito'].'</p>
		  
		  <p>Nombre Hito: '.$_POST['nom_hito'].'</p>

		</body>

		</html>';

		

		// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse

		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";

		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		

		// Cabeceras adicionales

		$cabeceras .= 'To: replay <replay@signsas.com>' . "\r\n";

		

		

		mail($para, $titulo, $mensaje, $cabeceras);

	else:

		$estado = 0;

	endif;*/



	$sql = sprintf("INSERT INTO `materiales` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', %d, 0, 0);",
		fn_filtro($_POST['id_despacho']),
		fn_filtro($_POST['material']),
		fn_filtro($_POST['cantidad']),
		fn_filtro($costo),
		fn_filtro($estado),
		fn_filtro($_POST['observacion']),
		fn_filtro($presupuesto)	
	);	


	if(!mysql_query($sql)){

		echo "Error al guardar la salida de mercancia. test10441\n";

	}

	

	/*$total_inventario = $_POST['cantidadInv'] - $_POST['cantidad'];	

		

	$sql2 = sprintf("UPDATE inventario SET cantidad='%s' WHERE id=%d;",

		fn_filtro($total_inventario), 	

		fn_filtro((int)$_POST['material'])

	);

		

	if(!mysql_query($sql2))

		echo "Error al actualizar el inventario. error110s111s\n.$sql";*/

		

	

?>