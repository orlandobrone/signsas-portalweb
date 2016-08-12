<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	session_start();
	//print_r($_POST['datos']);
	
	$sql = "select valor from prestaciones where id=17";
	$per = mysql_query($sql);
	$rs_per = mysql_fetch_assoc($per);
	
	$codigo = $rs_per['valor'];
	
	foreach($_POST['datos'] as $item):		
		//echo $item['idhito'];		
		$sql = " SELECT id_ps_state, 
				 (SELECT valor_galon FROM items_anticipo WHERE id_hitos = ".$item['idhito']." AND id_anticipo = ".$item['idanticipo']." ) AS valor_galon FROM hitos WHERE id = ".$item['idhito'];
		$per = mysql_query($sql);
		$rs_per = mysql_fetch_assoc($per);
		
		$sql2 = "SELECT id_regional,cedula_consignar,nombre_responsable, 
				 (SELECT name FROM ps_state WHERE id = ".$rs_per['id_ps_state'].") AS departamento,
				 (SELECT cantidad FROM inventario WHERE id = 1539 ) AS cantidad_galones
				 FROM anticipo WHERE id = ".$item['idanticipo'];
		$per2 = mysql_query($sql2);
		$rs_per2 = mysql_fetch_assoc($per2);
		
		// Agregar al inventario 
		/*$sql = sprintf("INSERT INTO `inventario` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', now());",
			fn_filtro('ACPM'),
			fn_filtro('Reintegro ACPM'),
			fn_filtro($item['galr']),
			fn_filtro($rs_per['valor_galon']),//costo acpm
			fn_filtro($codigo),
			fn_filtro(utf8_encode($rs_per2['departamento']))//departamento
		);
		mysql_query($sql);
		$ultimo_inv = mysql_insert_id();	*/
		
		$total_galones = $item['galr'] + $rs_per2['cantidad_galones'];
				
		/*$sql = sprintf("UPDATE inventario SET cantidad=%d, costo_unidad=%d, ubicacion='%s', fecha=NOW() WHERE id=1539",
			fn_filtro($total_galones),
			fn_filtro($rs_per['valor_galon']),
			fn_filtro(utf8_encode($rs_per2['departamento']))
		);
		mysql_query($sql);*/
		
		$sql = sprintf("INSERT INTO `inventario_acpm` VALUES ('',%d,%d,%d,'%s',%d,%d,'%s',%d,%d,%d,now(),0,%d,0);",
			fn_filtro(17), // codigo acpm id 17 prestaciones
			fn_filtro($rs_per['id_ps_state']),//departamento
			fn_filtro($rs_per2['id_regional']),//region anticipo
			fn_filtro($rs_per2['cedula_consignar']),//nombre beneficiario
			fn_filtro($item['idhito']),//id hito
			fn_filtro($item['idanticipo']),//id idanticipo
			fn_filtro(utf8_encode($rs_per2['nombre_responsable'])),//nombre_responsable
			fn_filtro($ultimo_inv),//id inventario
			fn_filtro($rs_per['valor_galon']),//costo acpm
			fn_filtro($item['galr']),//costo acpm	
			fn_filtro((int)$_POST['idreintegro'])//idreintegro acpm	
		);
		if(!mysql_query($sql)):
			echo "Error al insertar el acpm:\n$sql";
			exit;
		endif;	
		
		
		//vincula los items al anticipo de reintegro creado
		$totalCostoAnnticipo = 0;
		$acpm = (int)$item['valor_galon'] * $item['galr'];
		$totalCostoAnnticipo += $acpm;
		
		$sql = sprintf("INSERT INTO `items_anticipo` VALUES ('', '%s', '%s', '%s', '%s', '%s', %d, NULL, 1, %d, NOW(), %d, %d, %d);",
			fn_filtro($_POST['idanticipogirado']),
			fn_filtro($item['idhito']),
			fn_filtro(((int)$acpm * -1).',00'),
			fn_filtro(0),
			fn_filtro(0),
			fn_filtro($acpm * -1),
			fn_filtro($_SESSION['id']),
			fn_filtro($item['galr']),
			fn_filtro((int)$item['valor_galon']),
			fn_filtro(0)
			//fn_filtro(str_replace('.','',$_POST['valor_hito']))	
		);	
		if(!mysql_query($sql)){
			echo "Error al insertar un nuevo item:\n$sql";
			exit;	
		}
			
	endforeach;	
	
	
	$query = "UPDATE `anticipo` SET `total_anticipo` = '".($totalCostoAnnticipo * -1).",00' WHERE `id` = ".(int)$_POST['idanticipogirado'];
	mysql_query($query);
	
    $data = array('estado' => true);
    echo json_encode($data);
	
?>