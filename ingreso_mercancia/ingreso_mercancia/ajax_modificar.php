<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['material']) || empty($_POST['cantidad']) || empty($_POST['costo']) || empty($_POST['nfactura']) || empty($_POST['proveedor'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/
	
	$qr = mysql_query("SELECT cantidad FROM ingreso_mercancia WHERE id='" . (int)$_POST['id'] . "'");
	$row = mysql_fetch_array($qr);
	$cantAnt = $row['cantidad'];
	$costoAnt = $row['costo'];

	$sql = sprintf("UPDATE ingreso_mercancia SET id_material='%s', cantidad='%s', costo='%s', nfactura='%s', id_proveedor='%s' where id=%d;",
		fn_filtro($_POST['material']),
		fn_filtro($_POST['cantidad']),
		fn_filtro(str_replace(",","",$_POST['costo'])),
		fn_filtro($_POST['nfactura']),
		fn_filtro($_POST['proveedor']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el ingreso de mercancia:\n$sql";
		
	$qrInv = mysql_query("SELECT cantidad FROM inventario WHERE id = '" . $_POST['material'] . "'") or die(mysql_error());
	$rowInv = mysql_fetch_array($qrInv);
	$cantAntInv = $rowInv['cantidad'] - $cantAnt;
	$cantInv = $rowInv['cantidad'] - $cantAnt + $_POST['cantidad'];
	
	$costoGuardado = conv_valores_monetarios($rowsInventario['costo_unidad']);
	
	$anteriorprecio = (($rowsInventario['cantidad'] * $costoGuardado) - ($cantAnt * $costoAnt))/$cantAntInv;
	
	$nuevoprecio = (($cantAntInv*$anteriorprecio) + ($_POST['cantidad']*$_POST['costo']))/($cantAntInv + $_POST['cantidad']);
	
	$nuevoprecio = "$" . number_format($nuevoprecio, 2, ".", ",");

	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantInv . "' WHERE id = '" . $_POST['material'] . "'") or die(mysql_error());
	
	exit;
?>