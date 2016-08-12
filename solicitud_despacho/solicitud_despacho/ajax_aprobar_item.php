<?

	include "../../conexion.php";

	include "../extras/php/basico.php";

	

	if(!empty($_POST['idDespacho'])):	
	
		$id = (int)$_POST['idDespacho'];

		if($_POST['type'] == 'All'):
		
			/* Verificar si id despacho existe en ingreso de mercancia */
			$sql_im = "	SELECT id
						FROM  `ingreso_mercancia` 
						WHERE `id_despacho` = ".$id;
			$result_im = mysql_query($sql_im); 
			$row_im = mysql_fetch_assoc($result_im);
			$numfilas = mysql_num_rows($result_im);
			
			if($numfilas <= 0):
				$sql_p = sprintf("INSERT INTO `ingreso_mercancia` VALUES (null, 0,0,0,0,0,0,0,0, now(),1,'%s');",
					fn_filtro($id)					
				);
	
				if(!mysql_query($sql_p)){
					echo "Error al crear el padre:\n$sql"; 
					exit;
				} 	  
				$id_ingreso = mysql_insert_id();
			else:
				$id_ingreso = $row_im['id'];
			endif;
			
			/* bucle de temp mercancia con el id despacho */		
			$sql2 = "SELECT t.*, s.id_proyecto, s.id_hito, m.id_material
					 FROM `TEMP_MERCANCIAS` AS t
					 LEFT JOIN solicitud_despacho AS s ON t.id_despacho = s.id
					 LEFT JOIN materiales AS m ON m.id = t.id_item
					 WHERE m.aprobado = 0 AND t.id_despacho = ".$id;
			$pai2 = mysql_query($sql2); 
			
			while( $rs_pai2 = mysql_fetch_assoc($pai2) ):
			
				/* ingreso de los items a ingreso de mercancia con su padre */
				$sql_p = sprintf("INSERT INTO `ingreso_mercancia` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now(), 0,  '%s');",
					fn_filtro($id_ingreso),
					fn_filtro($rs_pai2['id_material']),
					fn_filtro($rs_pai2['id_proyecto']),
					fn_filtro($rs_pai2['id_hito']),
					fn_filtro($rs_pai2['cantidadc']),
					fn_filtro($rs_pai2['costo2']),
					fn_filtro($rs_pai2['iva2']),
					fn_filtro($rs_pai2['orden_compra2']),
					fn_filtro($rs_pai2['id_despacho'])	
				);
				
				if(!mysql_query($sql_p)):
					echo "Error al duplicar:\n$sql_p";
					exit;
				endif;
				
				$sql_i = "	SELECT cantidad
							FROM  `inventario` 
							WHERE  `id` = ".$rs_pai2['id_material'];
				$result_i = mysql_query($sql_i); 
				$row_i = mysql_fetch_assoc($result_i);
				
				$cantidadInv = $row_i['cantidad'] - $rs_pai2['cantidadentinv'];
				$cantidadComp = $rs_pai2['cantidadc'] - $rs_pai2['cantidadentcomp'];
				
				$cantidadT = $cantidadInv +$cantidadComp ; // Cantidad Inv sobrante + cantidad comprada sobrante		
				
				/*----- Promedio ponderado -----*/
				/*$costoUnidad = explode(".",$row_i['costo_unidad']);
				$precioT = ((int)$costoUnidad[0] * (int)$row_i['cantidad']) + ($rs_pai2['cantidadc'] * (int)$rs_pai2['costo2']);
				$precioP = $precioT / ($row_i['cantidad'] + $rs_pai2['cantidadc']);*/
				/*------------------------------*/
						
				$sql = sprintf("UPDATE inventario SET cantidad='%s' WHERE id=%d;",
					fn_filtro($cantidadT),					
					fn_filtro((int)$rs_pai2['id_material'])
				);
			
				if(!mysql_query($sql)):
					echo "Error al actualizar el ingreso de mercancia:\n$sql";
					exit;
				endif;	
				
			endwhile;
		
			$query = "UPDATE `materiales` SET  `aprobado` = '1' WHERE `id_despacho` = ".$id;

		else:
			
			$sql2 = "SELECT t.*, s.id_proyecto, s.id_hito, m.id_material
					 FROM `TEMP_MERCANCIAS` AS t
					 LEFT JOIN solicitud_despacho AS s ON t.id_despacho = s.id
					 LEFT JOIN materiales AS m ON m.id = t.id_item
					 WHERE t.id_item = ".$id. " LIMIT 1";
			$pai2 = mysql_query($sql2); 
			$rs_pai2 = mysql_fetch_assoc($pai2);
			
			$sql_im = "	SELECT id
						FROM  `ingreso_mercancia` 
						WHERE `id_despacho` = ".$rs_pai2['id_despacho'];
			$result_im = mysql_query($sql_im); 
			$row_im = mysql_fetch_assoc($result_im);
			$numfilas = mysql_num_rows($result_im);
			
			if($numfilas <= 0):
				$sql_p = sprintf("INSERT INTO `ingreso_mercancia` VALUES (null, 0,0,0,0,0,0,0,0, now(),1,'%s');",
					fn_filtro($rs_pai2['id_despacho'])					
				);
	
				if(!mysql_query($sql_p)){
					echo "Error al crear el padre:\n$sql"; 
					exit;
				} 	  
				$id_ingreso = mysql_insert_id();
			else:
				$id_ingreso = $row_im['id'];
			endif;
			
			$sql_p = sprintf("INSERT INTO `ingreso_mercancia` VALUES ('', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', now(), 0,  '%s');",
				fn_filtro($id_ingreso),
				fn_filtro($rs_pai2['id_material']),
				fn_filtro($rs_pai2['id_proyecto']),
				fn_filtro($rs_pai2['id_hito']),
				fn_filtro($rs_pai2['cantidadc']),
				fn_filtro($rs_pai2['costo2']),
				fn_filtro($rs_pai2['iva2']),
				fn_filtro($rs_pai2['orden_compra2']),
				fn_filtro($rs_pai2['id_despacho'])	
			);
			
			if(!mysql_query($sql_p)):
				echo "Error al duplicar:\n$sql_p";
				exit;
			endif;
			
			$sql_i = "	SELECT cantidad
						FROM  `inventario` 
						WHERE  `id` = ".$rs_pai2['id_material'];
			$result_i = mysql_query($sql_i); 
			$row_i = mysql_fetch_assoc($result_i);
			
			$cantidadInv = $row_i['cantidad'] - $rs_pai2['cantidadentinv'];
			$cantidadComp = $rs_pai2['cantidadc'] - $rs_pai2['cantidadentcomp'];
			
			$cantidadT = $cantidadInv +$cantidadComp ; // Cantidad Inv sobrante + cantidad comprada sobrante		
			
			/*----- Promedio ponderado -----*/
			/*$costoUnidad = explode(".",$row_i['costo_unidad']);
			$precioT = ((int)$costoUnidad[0] * (int)$row_i['cantidad']) + ($rs_pai2['cantidadc'] * (int)$rs_pai2['costo2']);
			$precioP = $precioT / ($row_i['cantidad'] + $rs_pai2['cantidadc']);*/
			/*------------------------------*/
					
			$sql = sprintf("UPDATE inventario SET cantidad='%s' WHERE id=%d;",
				fn_filtro($cantidadT),
				fn_filtro((int)$rs_pai2['id_material'])
			);
		
			if(!mysql_query($sql)):
				echo "Error al actualizar el ingreso de mercancia:\n$sql";
				exit;
			endif;
						
			$id = (int)$_POST['idMaterial'];
			$query = "UPDATE `materiales` SET  `aprobado` = '1' WHERE `id` = ".$id;

		endif;

		$sql = mysql_query($query) or die("Problemas en la base de datos:".mysql_error());

	endif;

?>