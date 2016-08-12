<?
    //include "../../restrinccion.php";
	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";	
	
	$query = "SELECT *,
		      	hu.cant_galones AS hu_cant_galones,
				hu.po AS hu_po,
				hu.gr AS hu_gr,
				hu.factura AS hu_factura,
				hu.valor_facturado AS hu_valor_facturado,
				hu.fecha_facturado AS hu_fecha_facturado
			  FROM hitos_upload AS hu
			  LEFT JOIN hitos AS h ON h.id = hu.id_hito
			  WHERE hu.id_hito != 0 ORDER BY hu.id ASC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	$num_filas = mysql_num_rows($result);
	 
	$cadena = '';
	$no_ingresados = 0;
	while($row = mysql_fetch_assoc($result)):
	
		  //validacion de PO1
		  if( $row['po'] == $row['hu_po'] && 
			  $row['factura'] == $row['hu_factura'] && 
			  $row['gr'] == $row['hu_gr'] && 
			  $row['valor_facturado'] == $row['hu_valor_facturado'] && 
			  $row['fecha_facturado1'] == $row['hu_fecha_facturado'] ):
			  
			  $cadena .= '-----------------  PO1 YA Ingresado ------------------<br>
						  Hito ID = '.$row['id_hito'].'<br>
						  po = '.$row['po'].'<br>
						  gr = '.$row['gr'].'<br>
						  factura = '.$row['factura'].'<br>
						  valor_facturado = '.$row['valor_facturado'].'<br>
						  fecha_facturado1 = '.$row['fecha_facturado'].'<br>';	
		  
		  elseif( $row['po2'] == $row['hu_po'] && 
				  $row['factura2'] == $row['hu_factura'] && 
				  $row['gr2'] == $row['hu_gr'] && 
				  $row['valor_facturado2'] == $row['hu_valor_facturado'] && 
				  $row['fecha_facturado2'] == $row['hu_fecha_facturado'] ):
				  
				  $cadena .= '-----------------  PO2 YA Ingresado ------------------<br>
							  Hito ID = '.$row['id_hito'].'<br>
							  po2 = '.$row['po'].'<br>
							  gr2 = '.$row['gr'].'<br>
							  factura2 = '.$row['factura'].'<br>
							  valor_facturado2 = '.$row['valor_facturado'].'<br>
							  fecha_facturado2 = '.$row['fecha_facturado'].'<br>';	
							  
		  elseif( $row['po2'] == $row['hu_po'] && 
				  $row['factura2'] == $row['hu_factura'] && 
				  $row['gr2'] == $row['hu_gr'] && 
				  $row['valor_facturado2'] == $row['hu_valor_facturado'] && 
				  $row['fecha_facturado2'] == $row['hu_fecha_facturado'] ):
				  
				  $cadena .= '-----------------  PO3 YA Ingresado ------------------<br>
							  Hito ID = '.$row['id_hito'].'<br>
							  po3 = '.$row['po3'].'<br>
							  gr3 = '.$row['gr3'].'<br>
							  factura3 = '.$row['factura3'].'<br>
							  valor_facturado3 = '.$row['valorfacturado3'].'<br>
							  fecha_facturado3 = '.$row['fecha_facturado3'].'<br>';	
							  
		  elseif( $row['po4'] == $row['hu_po'] && 
				  $row['factura4'] == $row['hu_factura'] && 
				  $row['gr4'] == $row['hu_gr'] &&  
				  $row['valor_facturado4'] == $row['hu_valor_facturado'] && 
				  $row['fecha_facturado4'] == $row['hu_fecha_facturado'] ):
				  
				  $cadena .= '-----------------  PO4 YA Ingresado ------------------<br>
							  Hito ID = '.$row['id_hito'].'<br>
							  po4 = '.$row['po4'].'<br>
							  gr4 = '.$row['gr4'].'<br>
							  factura4 = '.$row['factura4'].'<br>
							  valor_facturado4 = '.$row['valorfacturado4'].'<br>
							  fecha_facturado4 = '.$row['fecha_facturado4'].'<br>';	
				  
		  else:
		  
		  	  $cadena .= '<strong>-----------------  PO NO Ingresado ------------------</strong><br>
						  Hito ID = '.$row['id_hito'].'<br>
						  po4 = '.$row['hu_po'].'<br>
						  gr4 = '.$row['hu_gr'].'<br>
						  factura4 = '.$row['hu_factura'].'<br>
						  valor_facturado4 = '.$row['hu_valorfacturado'].'<br>
						  fecha_facturado4 = '.$row['hu_fecha_facturado'].'<br>';
			  $no_ingresados++;	
		  	
		  endif;	
	endwhile;	
	
	
	if(!empty($cadena)):
		echo '<strong>Total de PO NO Ingresados: '.$no_ingresados.'</strong><br><br>';
		echo $cadena;
	endif;
	
	
	exit;
	
?>