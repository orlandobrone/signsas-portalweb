<?php

include '../../conexion.php';

$total = 0;
$acpmIngreso = false;

if($_GET['tipo_item'] == 'd'):
	if($_GET['tipo_persona'] == 'interno'): 
		$sqlPry = "SELECT * FROM beneficiarios ORDER BY identificacion ASC"; 
	elseif($_GET['tipo_persona'] == 'contratista'):
		$sqlPry = "SELECT * FROM orden_servicio WHERE aprobado = 1"; 
	endif;
else:
	$sqlPry = "	SELECT DISTINCT inventario_acpm.beneficiarios, beneficiarios. * , inventario_acpm.cant_galones, 
				(SELECT SUM( cant_salida_gal ) FROM salida_inventario_acpm WHERE salida_inventario_acpm.id_inventario_acpm = inventario_acpm.id
				) AS salidos
				FROM inventario_acpm
				LEFT JOIN beneficiarios ON beneficiarios = identificacion
				WHERE inventario_acpm.estado != 1
				ORDER BY identificacion ASC ";
	$acpmIngreso = true;
endif;	

	
$qrPry = mysql_query($sqlPry);
$total = mysql_num_rows($qrPry);

$entry = [];

if($total > 0):
	
	$obj = new TaskCurrent;

	if($acpmIngreso):
	
		while($row = mysql_fetch_assoc($qrPry)):			
	
			//Only cell's with named keys and matching columns are order independent.
			$entra = true;			
			$data = $obj->getPromedioTotalGal();
			
			if( $data['total_gal'] <= 0 ):
				$entra = false;
			endif;
			
			
			if($entra):
				$entry[] = array(	'identificacion'=>$row['identificacion'],
									'beneficiario'=>utf8_encode($row['nombre']),
									'entidad'=>utf8_encode($row['entidad']),
									'num_cuenta'=>utf8_encode($row['num_cuenta']),
									'tipo_cuenta'=>utf8_encode($row['tipo_cuenta']),
									'total'=>$data['total_gal']
								 );
			endif;
			
		endwhile;	
		
	else:
		//Persona internas
		if($_GET['tipo_persona'] == 'interno'): 
			while($row = mysql_fetch_assoc($qrPry)):
			  $entry[] = array(	'identificacion'=>$row['identificacion'],
								'beneficiario'=>utf8_encode($row['nombre']),
								'entidad'=>utf8_encode($row['entidad']),
								'num_cuenta'=>utf8_encode($row['num_cuenta']),
								'tipo_cuenta'=>utf8_encode($row['tipo_cuenta']),
								
								'contacto'=>utf8_encode($row['contacto']),
								'telefono'=>utf8_encode($row['telefono']), 
								'regimen'=>utf8_encode($row['regimen']), 
								'correo'=>utf8_encode($row['correo']), 
								'num_contrato'=>utf8_encode($row['num_contrato']),
								'id_os'=>'',
								'estado'=>$row['estado'],
								'clinton'=>$row['clinton'],
								'sgss'=>$row['sgss'],
								'tipo_trabajo'=>$row['tipo_trabajo'] );
			endwhile;
		//personas contratistas con una orden de servicio aprobada
		elseif($_GET['tipo_persona'] == 'contratista'):
			while($row = mysql_fetch_assoc($qrPry)):
			  $entry[] = array(	'identificacion'=>$row['cedula_contratista'],
								'beneficiario'=>utf8_encode($row['nombre_contratista']),
								'entidad'=>utf8_encode($row['banco_contratista']),
								'num_cuenta'=>utf8_encode($row['numcuenta_contratista']),
								'tipo_cuenta'=>utf8_encode($row['tipocuenta_contratista']),
								
								'contacto'=>utf8_encode($row['contacto_contratista']),
								'telefono'=>utf8_encode($row['telefono_contratista']), 
								'regimen'=>utf8_encode($row['regimen_contratista']), 
								'correo'=>utf8_encode($row['correo_contratista']), 
								'num_contrato'=>utf8_encode($row['observaciones_contratista']),
								'id_os'=>(int)$row['id'],
								'estado'=>$row['estado'],
								'clinton'=>$row['clinton'],
								'sgss'=>$row['sgss'],
								'tipo_trabajo'=>$row['tipo_trabajo'] );
			endwhile;
		endif;		
	endif;

endif;

echo json_encode($entry); 