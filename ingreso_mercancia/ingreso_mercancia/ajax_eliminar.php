<?

	include "../../conexion.php";
	include "../extras/php/basico.php";

	$sql = "SELECT id_material, cantidad, costo FROM ingreso_mercancia WHERE parent = 0 AND id_ingreso=".(int)$_POST['id'];
  	$resultado = mysql_query($sql) or die(mysql_error());

	while($row = mysql_fetch_assoc($resultado)):
	
		$cantAnt = $row['cantidad'];
		$costoAnt = $row['costo'];
		
		$sqlI = "SELECT cantidad, costo_unidad FROM inventario WHERE id = ".$row['id_material'];
		$qrInv = mysql_query($sqlI) or die(mysql_error());
		$rowInv = mysql_fetch_array($qrInv);
		
		$cantInv = $rowInv['cantidad'] - $cantAnt;	
		$costoUnidadI = explode('.',$rowInv['costo_unidad']);	
		$costoGuardado = (int)$costoUnidadI[0]; 		
		
		$anteriorprecio = ( ($rowInv['cantidad'] * $costoGuardado) - ($cantAnt * $costoAnt) )/$cantInv;		
		
		$nuevoprecio = $anteriorprecio;
		$nuevoprecio = "$" . number_format($nuevoprecio, 2, ".", ",");	
		
		$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantInv . "' WHERE id = '" . $row['id_material'] . "'") or die(mysql_error());	
		
		
		
	endwhile;
	
	
	$sql = "delete from ingreso_mercancia WHERE id_ingreso = ".(int)$_POST['id']." || id= ".(int)$_POST['id'];
	if(!mysql_query($sql))
		echo "Ocurrio un error\n$sql";
	
	exit;
?>