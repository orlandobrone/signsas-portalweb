<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['material']) || empty($_POST['cantidad']) || empty($_POST['costo']) || empty($_POST['nfactura']) || empty($_POST['proveedor'])){
		echo "Usted no a llenado todos los campos";
		exit;
	}

	$sql = sprintf("INSERT INTO `ingreso_mercancia` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
		fn_filtro($_POST['material']),
		fn_filtro($_POST['cantidad']),
		fn_filtro(str_replace(",","",$_POST['costo'])),
		fn_filtro($_POST['nfactura']),
		fn_filtro($_POST['proveedor'])
	);

	if(!mysql_query($sql))
		echo "Error al insertar el ingreso de mercancia:\n$sql";
	
	/*$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $_POST['material'] . "'");
	$rowsInventario = mysql_fetch_array($qrInventario);
	$cantidad = $rowsInventario['cantidad'] + $_POST['cantidad'];
	
	$costoGuardado = conv_valores_monetarios($rowsInventario['costo_unidad']);
	
	$nuevoprecio = (($rowsInventario['cantidad']*$costoGuardado) + ($_POST['cantidad']*$_POST['costo']))/($rowsInventario['cantidad'] + $_POST['cantidad']);
	
	$nuevoprecio = "$" . number_format($nuevoprecio, 2, ".", ",");
	
	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantidad . "', costo_unidad = '" . $nuevoprecio . "' WHERE id = '" . $_POST['material'] . "'");
	*/
	exit;
?>