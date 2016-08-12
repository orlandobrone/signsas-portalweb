<?
	include "../../conexion.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	/*verificamos si las variables se envian*/
	if(empty($_POST['material']) || empty($_POST['cantidad']) || empty($_POST['costo']) || empty($_POST['proyecto']) || empty($_POST['solicitud_despacho']) || empty($_POST['id'])){
		echo "Usted no ha llenado todos los campos";
		exit;
	}
	
	/*modificar el registro*/
	
	$qr = mysql_query("SELECT cantidad FROM salida_mercancia WHERE id='" . (int)$_POST['id'] . "'");
	$row = mysql_fetch_array($qr);
	$cantAnt = $row['cantidad'];
	
	$sql = sprintf("UPDATE salida_mercancia SET id_material='%s', cantidad='%s', costo='%s', id_proyecto='%s', id_solicitud_despacho='%s' where id=%d;",
		fn_filtro($_POST['material']),
		fn_filtro($_POST['cantidad']),
		fn_filtro($_POST['costo']),
		fn_filtro($_POST['proyecto']),
		fn_filtro($_POST['solicitud_despacho']),
		fn_filtro((int)$_POST['id'])
	);
	if(!mysql_query($sql))
		echo "Error al actualizar el ingreso de mercancia:\n$sql";
		
	$qrInv = mysql_query("SELECT cantidad FROM inventario WHERE id = '" . $_POST['material'] . "'") or die(mysql_error());
	$rowInv = mysql_fetch_array($qrInv);
	$cantInv = $rowInv['cantidad'] + $cantAnt - $_POST['cantidad'];
	
	$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantInv . "' WHERE id = '" . $_POST['material'] . "'") or die(mysql_error());
	exit;
?>