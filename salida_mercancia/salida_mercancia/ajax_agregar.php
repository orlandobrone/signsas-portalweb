<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['material']) || empty($_POST['cantidad']) || empty($_POST['costo']) || empty($_POST['proyecto']) || empty($_POST['solicitud_despacho'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO `salida_mercancia` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['material']),
		fn_filtro($_POST['cantidad']),
		fn_filtro($_POST['costo']),
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['solicitud_despacho'])
	);

	if(!mysql_query($sql))
		echo "Error al guardar la salida de mercancia.\n";
		
	$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $_POST['material'] . "'");
	$rowsInventario = mysql_fetch_array($qrInventario);
	$cantidad = $rowsInventario['cantidad'] - $_POST['cantidad'];
	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantidad . "' WHERE id = '" . $_POST['material'] . "'");
	
	$fecha_ingreso = date('Y-m-d H:i:s');
	
	$sql = sprintf("INSERT INTO `proyecto_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['proyecto']),
		fn_filtro(28),
		fn_filtro(utf8_encode($rowsInventario['nombre_material'])),
		fn_filtro($fecha_ingreso),
		fn_filtro($_POST['costo'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar el costo al proyecto.\n";
		
	exit;
?>