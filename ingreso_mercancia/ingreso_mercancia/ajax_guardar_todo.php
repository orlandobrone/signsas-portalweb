<?php
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	$sql = "SELECT cantidad, id_material, costo FROM ingreso_mercancia WHERE id_ingreso = ".$_POST['id_ingreso'];
	$result = mysql_query($sql);
	
	while ($row = mysql_fetch_assoc($result)):
	
		$sqli = "SELECT cantidad FROM inventario WHERE id = ".$row['id_material'];
		$resulti = mysql_query($sqli);
		$rowi = mysql_fetch_assoc($resulti);
		
		$cantidadT = $rowi['cantidad'] + $row['cantidad'];
	
		$sql = sprintf("UPDATE `inventario` SET cantidad = ".$cantidadT.", costo_unidad = %d  WHERE id = %d ",
			fn_filtro($row['costo']),
			fn_filtro($row['id_material'])
		);
	
		if(!mysql_query($sql)) 
			echo "Error al actualizar el nuevo material:\n$sql";
		
		
	endwhile;
	
	
	/*$sql = sprintf("UPDATE `inventario` AS i, ingreso_mercancia AS n SET i.costo_unidad = ((i.costo_unidad)*(i.cantidad/(i.cantidad+n.cantidad))+(n.costo)*(n.cantidad/(i.cantidad+n.cantidad))), i.cantidad = (i.cantidad+n.cantidad) WHERE n.id_ingreso = %s AND i.id = n.id_material",
		fn_filtro($_POST['id_ingreso'])
	);*/
	
	/*$sql = sprintf("UPDATE `inventario` SET cantidad = (SELECT SUM(cantidad) FROM ingreso_mercancia WHERE id_ingreso = ".$_POST['id_ingreso'].") 
					WHERE id_ingreso = %s",
		fn_filtro($_POST['id_ingreso'])
	);

	if(!mysql_query($sql)) 
		echo "Error al actualizar el nuevo material:\n$sql";

	/*$sql = sprintf("UPDATE `ingreso_mercancia` SET parent = 1 WHERE id_ingreso = %s;",
		fn_filtro($_POST['id_ingreso'])
	);

	if(!mysql_query($sql)) 
		echo "Error al actualizar el nuevo material:\n$sql";*/
		
	/*$sql = sprintf("DELETE FROM `ingreso_mercancia` WHERE id_ingreso = %s AND id_material = 0;",
		fn_filtro($_POST['id_ingreso'])
	);

	if(!mysql_query($sql)) 
		echo "Error al actualizar el nuevo material:\n$sql";

	exit;*/
	
	
?>