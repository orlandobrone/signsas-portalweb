<?
	include "../../conexion.php";
	include "../../funciones.php";
	include "../../ingreso_mercancia/extras/php/basico.php";
	
	function aprobarMaterial($idMaterial){
		$sql ="UPDATE materiales SET aprobado = 2 WHERE id =".$idMaterial;
			
		if(!mysql_query($sql))
			echo "Ocurrio un error\n$sql";
	}
	
	
	function addCosto($idDespacho, $total){
		
		/*$qrInventario = mysql_query("SELECT * FROM inventario WHERE id = '" . $idMaterial . "'");
		$rowsInventario = mysql_fetch_array($qrInventario);
		
		$cantidad = $rowsInventario['cantidad'] - $cantidadMaterial;
		
		$qrUpdateInv = mysql_query("UPDATE inventario SET cantidad = '" . $cantidad . "' WHERE id = '" . $idMaterial . "'");*/
		$fecha_ingreso = date('Y-m-d H:i:s');
		
		$sql = sprintf("INSERT INTO `proyecto_costos` VALUES ('', '%s', '%s', '%s', '%s', '%s', now());",
			fn_filtro($_POST['id_proyecto']),
			fn_filtro(28),
			fn_filtro(utf8_decode('Solicitud de despacho No: '.$idDespacho)),
			fn_filtro($fecha_ingreso),
			fn_filtro($total)
		);
	
		if(!mysql_query($sql)):
			echo "Error al insertar el costo al proyecto.\n";
			return false;
		else:
			alertaCostos($_POST['id_proyecto']);
			return true;
		endif;
	}
	
	function procesoInvetario($idMaterial, $cantidad){
		$sql ="UPDATE  `inventario` SET  `cantidad` =  `cantidad` - ".$cantidad." WHERE `id` = " . $idMaterial;
			
		if(!mysql_query($sql))
			echo "Ocurrio un error\n$sql";
		exit;
	}
	

	
	if(!empty($_POST['id']) && !empty($_POST['id_proyecto'])):	
	
		$idDespacho  = (int)$_POST['id'];

		$qrMaterial = mysql_query("SELECT * FROM materiales WHERE aprobado = 1 AND id_despacho = '" . $idDespacho . "'");
		
		if(mysql_num_rows($qrMaterial) > 0 ):
			
			$suma = 0;
			
			while($rowsMaterial = mysql_fetch_array($qrMaterial)):
				
					aprobarMaterial($rowsMaterial['id']);
					
					$despacho = $rowsMaterial['id_despacho'];
					
					$suma = $suma + $rowsMaterial['costo'];		
					
					$sql ="UPDATE  `inventario` SET  `cantidad` =  `cantidad` - ".$rowsMaterial['cantidad']." WHERE `id` = " . $rowsMaterial['id_material'];
			
					if(!mysql_query($sql))
						echo "Ocurrio un error\n$sql";
			
			endwhile;	
					
			if(addCosto($despacho, $suma)):
				echo 'Guardado';
				exit;
			endif;
		else:
			echo 'No se puede realizar la operación hasta aprobar un item de mercancia o esta mercancia ya fue aprobada.';
		endif;

	else:
	
	 	echo 'ocurrio un error faltan variables IDProyecto:'.$_POST['id_proyecto'].' | IDDespacho:'.$_POST['id'];
		exit;
	
	endif;
?>