<?php 
include "conexion.php"; 


function aprobadoDesapacho($idDespacho){
	$qrMaterial = mysql_query("SELECT * FROM materiales WHERE aprobado = 2 AND id_despacho = '" . $idDespacho . "'");
	return (mysql_num_rows($qrMaterial) > 0 ) ? true : false;
}

function alertaCostos($proyecto){
	
	//utiulidad acumulada
	//$proyecto = (isset($_REQUEST['proyecto'])) ? $_REQUEST['proyecto'] : '';

	$costoReal= '';	
	$vowels = array(",");	
	
	if ($proyecto != '*' && $proyecto != ''):
	
		$sql = "SELECT *, proyect.nombre AS nombre, proyect.descripcion AS description					
				FROM proyectos AS proyect
				LEFT JOIN cotizacion AS coti ON coti.id = proyect.id_cotizacion
				WHERE proyect.id = {$proyecto} ";
				
		$qrCostos = mysql_query($sql); 
		$rowsCostos = mysql_fetch_array($qrCostos);			
		
		$nombreProyecto = $rowsCostos['nombre'];			
		$descriptionProyect = $rowsCostos['description'];
		
		  /* Variable de Costo propuesto reporte 3*/ 
		  $costoReal =    (int)str_replace($vowels, "", $rowsCostos['transportes'])
						+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos'])
						+ (int)str_replace($vowels, "", $rowsCostos['imprevistos'])
						+ (int)str_replace($vowels, "", $rowsCostos['ica'] )
						+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero']) 
						+ (int)str_replace($vowels, "", $rowsCostos['acarreos'] )							
						+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos'] )
						+ (int)str_replace($vowels, "", $rowsCostos['reparaciones'])
						+ (int)str_replace($vowels, "", $rowsCostos['profesionales'])
						+ (int)str_replace($vowels, "", $rowsCostos['seguros'])
						+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular'])
						+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia'])
						+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica'])
						+ (int)str_replace($vowels, "", $rowsCostos['envios_correos'])
						+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios'])
						+ (int)str_replace($vowels, "", $rowsCostos['combustible'])
						+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo'])
						+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje'])
						+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos'])
						+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria'])
						+ (int)str_replace($vowels, "", $rowsCostos['papeleria'])
						+ (int)str_replace($vowels, "", $rowsCostos['internet'])
						+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses'])
						+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos'])
						+ (int)str_replace($vowels, "", $rowsCostos['caja_menor'])
						+ (int)str_replace($vowels, "", $rowsCostos['peajes'])
						+ (int)str_replace($vowels, "", $rowsCostos['polizas'])
						+ (int)str_replace($vowels, "", $rowsCostos['materiales'])	
						+ (int)str_replace($vowels, "", $rowsCostos['MOD'])	
						+ (int)str_replace($vowels, "", $rowsCostos['MOI'])	
						+ (int)str_replace($vowels, "", $rowsCostos['TOES']);
	
		$costos     =    (int)str_replace($vowels, "", $rowsCostos['transportes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['alquileres_vehiculos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['imprevistos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['ica2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['coste_financiero2']) 
							+ (int)str_replace($vowels, "", $rowsCostos['acarreos2'] )							
							+ (int)str_replace($vowels, "", $rowsCostos['arrendamientos2'] )
							+ (int)str_replace($vowels, "", $rowsCostos['reparaciones2'])
							+ (int)str_replace($vowels, "", $rowsCostos['profesionales2'])
							+ (int)str_replace($vowels, "", $rowsCostos['seguros2'])
							+ (int)str_replace($vowels, "", $rowsCostos['comunicaciones_celular2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_vigilancia2'])
							+ (int)str_replace($vowels, "", $rowsCostos['asistencia_tecnica2'])
							+ (int)str_replace($vowels, "", $rowsCostos['envios_correos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['otros_servicios2'])
							+ (int)str_replace($vowels, "", $rowsCostos['combustible2'])
							+ (int)str_replace($vowels, "", $rowsCostos['lavado_vehiculo2'])
							+ (int)str_replace($vowels, "", $rowsCostos['gastos_viaje2'])
							+ (int)str_replace($vowels, "", $rowsCostos['tiquetes_aereos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['aseo_cafeteria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['papeleria2'])
							+ (int)str_replace($vowels, "", $rowsCostos['internet2'])
							+ (int)str_replace($vowels, "", $rowsCostos['taxis_buses2'])
							+ (int)str_replace($vowels, "", $rowsCostos['parqueaderos2'])
							+ (int)str_replace($vowels, "", $rowsCostos['caja_menor2'])
							+ (int)str_replace($vowels, "", $rowsCostos['peajes2'])
							+ (int)str_replace($vowels, "", $rowsCostos['polizas2'])
							+ (int)str_replace($vowels, "", $rowsCostos['materiales2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOD2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['MOI2'])	
							+ (int)str_replace($vowels, "", $rowsCostos['TOES2']);
		
		$utilidad = $costos - $costoReal;
		
		$porcentaje = round(($costoReal /($utilidad + $costoReal))*100);	
							
		/*-----------------------------------------------------------------------------------------------------------------------*/					
		
		$sql = "SELECT proyect.nombre AS nombre, 
						   proyect.descripcion AS description,  
						   SUM( costo.valor ) AS SumaCostos,
						   SUM( ingre.valor ) AS SumaUtilidad
					FROM proyectos AS proyect
					LEFT JOIN proyecto_ingresos AS ingre ON proyect.id = ingre.id_proyecto
					LEFT JOIN proyecto_costos AS costo ON proyect.id = costo.id_proyecto
					WHERE proyect.id = {$proyecto}";
					
			$qrCostos = mysql_query($sql); 
			$rowsCostos = mysql_fetch_array($qrCostos);
			
			$vowels = array(",");	
			
			$nombreProyecto = $rowsCostos['nombre'];			
			$descriptionProyect = $rowsCostos['description'];
			
			
			$sqlU = "SELECT proyect.nombre AS nombre, 
						   proyect.descripcion AS description,  
						   SUM( ingre.valor ) AS SumaUtilidad
					FROM proyectos AS proyect
					LEFT JOIN proyecto_ingresos AS ingre ON proyect.id = ingre.id_proyecto
					WHERE proyect.id = {$proyecto}";
			
			$qrUtili = mysql_query($sqlU); 
			$rowsUtili = mysql_fetch_array($qrUtili);
			
			$costos = (int)$rowsCostos['SumaCostos']; // Variable de costo acomulado reporte 4 Utilidad acomulada
			$ingresos = (int)$rowsUtili['SumaUtilidad'];
			
			if(($ingresos - $costos)<0)
				$utilidad = 0;
			else
				$utilidad = $ingresos - $costos; //FGR Nueva Variable utilidad
				
				
		$porcentaje2 = round(($costos /($utilidad + $costos))*100);		
		
		if($costos > $costoReal):
			enviar_mensaje($name_proyecto, $porcentaje2, $porcentaje);				
		endif;	
				
	endif;
}
		
		
function enviar_mensaje($name_proyecto,$pcostoa, $pcosto){
	
	$asunto = 'Los costos del proyecto '.$name_proyecto.' han excedido el máximo permitido';
	
	$codigohtml = '
	<html>
		<head>
			<title>Alerta de Costos</title>
		</head>
		<body>
			<h3>'.$name_proyecto.'</h3>
			<p>Los costos del proyecto abarcan el '.$pcostoa.'% sobre un máximo de '.$pcosto.'% permitido.</p>
		</body>
	</html>
	';
	
	$email = 'fgomez@ingecall.com';
	$email2 = 'rafael.cadena@signsas.com';
	$email3 = 'isabel.alfaro@signsas.com';
	
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= 'From: <noreply@ingecall.com>' . "\r\n";
	$headers .= 'Cc: info@ingecall.com' . "\r\n";
	
	mail($email,$asunto,$codigohtml,$headers);
	mail($email2,$asunto,$codigohtml,$headers);
	mail($email3,$asunto,$codigohtml,$headers);
}
		