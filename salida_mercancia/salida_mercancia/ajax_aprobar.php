<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	$sql ="UPDATE materiales SET aprobado = 1 WHERE id = '" . $_POST['IdMaterial'] . "'";
		
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	exit;
	
	/*
	$qrMaterial = mysql_query("SELECT * FROM materiales WHERE id = '" . $_POST['IdMaterial'] . "'");
	$rowsMaterial = mysql_fetch_array($qrMaterial);
	$cantidadMaterial = $rowsMaterial['cantidad'];
	$costoMaterial = $rowsMaterial['costo'];
	
	$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $_POST['IdMaterial'] . "'");
	$rowsInventario = mysql_fetch_array($qrInventario);
	$cantidad = $rowsInventario['cantidad'] - $cantidadMaterial;
	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantidad . "' WHERE id = '" . $_POST['IdMaterial'] . "'");
	
	$fecha_ingreso = date('Y-m-d H:i:s');
	
	$sql = sprintf("INSERT INTO `proyecto_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['proyecto']),
		fn_filtro(28),
		fn_filtro(utf8_encode($rowsInventario['nombre_material'])),
		fn_filtro($fecha_ingreso),
		fn_filtro($costoMaterial)
	);

	if(!mysql_query($sql)):
		echo "Error al insertar el costo al proyecto.\n";
	else:
		alertaCostos($_POST['proyecto']);
	endif;
	exit;*/
?>