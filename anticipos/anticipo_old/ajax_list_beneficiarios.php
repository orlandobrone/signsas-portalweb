<?php

session_start();

include '../../conexion.php';

$total = 0;
$acpmIngreso = false;

if($_GET['tipo_item'] == 'd'):
	$sqlPry = "SELECT * FROM beneficiarios ORDER BY identificacion ASC"; 
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
									'beneficiario'=>utf8_encode($row['beneficiario']),
									'entidad'=>utf8_encode($row['entidad']),
									'num_cuenta'=>utf8_encode($row['num_cuenta']),
									'tipo_cuenta'=>utf8_encode($row['tipo_cuenta']),
									'total'=>$data['total_gal']
								 );
			endif;
			
		endwhile;	
		
	else:
		while($row = mysql_fetch_assoc($qrPry)):
		  $entry[] = array(	'identificacion'=>$row['identificacion'],
							  'beneficiario'=>utf8_encode($row['beneficiario']),
							  'entidad'=>utf8_encode($row['entidad']),
							  'num_cuenta'=>utf8_encode($row['num_cuenta']),
							  'tipo_cuenta'=>utf8_encode($row['tipo_cuenta']) );
		endwhile;		
	endif;

endif;

echo json_encode($entry); 