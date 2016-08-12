<?
    //include "../../restrinccion.php";
	include "../../conexion.php";
	include "../../funciones.php";
	include "../extras/php/basico.php";	
	include '../../phpMailer/class.phpmailer.php';
	include '../../phpMailer/class.smtp.php';
	
	
	$query = "SELECT * FROM hitos_upload WHERE 1 ORDER BY id ASC";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	//$row = mysql_fetch_array($result, MYSQL_ASSOC);
	 
	$cadena = '';
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)):
			
		$cadena = '';
		$query2 = "SELECT * FROM hitos WHERE id = ".$row['id_hito'];
		$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error().' SQL: '.$query2);
		$row_h = mysql_fetch_array($result2, MYSQL_ASSOC);
		
		//cantidad de galones 
		if($row_h['cant_galones_h'] == 0 && $row['cant_galones'] > 0):
			$cadena .= ' cant_galones_h = '.$row['cant_galones'].',';
		endif;
		
		
		//validacion de todos los campos
		if(!$_REQUEST['allfields']):
			//validacion de PO
			if($row_h['factura'] == 'N/A' || $row_h['factura'] == 'PENDIENTE' || empty($row_h['factura'])):
				$cadena .= 'po = "'.$row['po'].'", 
							gr = "'.$row['gr'].'", 
							factura = "'.$row['factura'].'", 
							valor_facturado = "'.$row['valor_facturado'].'", 
							fecha_facturado1 = "'.$row['fecha_facturado'].'",';
							 
			elseif($row_h['factura2'] == 'N/A' || $row_h['factura2'] == 'PENDIENTE' || empty($row_h['factura2'])):
				$cadena .= 'po2 = "'.$row['po'].'", 
							gr2 = "'.$row['gr'].'", 
							factura2 = "'.$row['factura'].'", 
							valor_facturado2 = "'.$row['valor_facturado'].'", 
							fecha_facturado2 = "'.$row['fecha_facturado'].'",';
							
			elseif($row_h['factura3'] == 'N/A' || $row_h['factura3'] == 'PENDIENTE' || empty($row_h['factura3'])):
				$cadena .= 'po3 = "'.$row['po'].'", 
							gr3 = "'.$row['gr'].'", 
							factura3 = "'.$row['factura'].'", 
							valorfacturado3 = "'.$row['valor_facturado'].'", 
							fecha_facturado3 = "'.$row['fecha_facturado'].'",';
				
			elseif($row_h['factura4'] == 'N/A' || $row_h['factura4'] == 'PENDIENTE' || empty($row_h['factura4'])):
				$cadena .= 'po4 = "'.$row['po'].'",
							gr4 = "'.$row['gr'].'", 
							factura4 = "'.$row['factura'].'",
							valorfacturado4 = "'.$row['valor_facturado'].'", 
							fecha_facturado4 = "'.$row['fecha_facturado'].'",';
			endif;	
		else:
			
			echo '|--------------------------- ID Hito:'.$row['id_hito'].' | ID Upload:'.$row['id'].'------------------------------------------|<br>';
			echo 'Resultado PO1 <br>';
			//PO1
			$po_fields1 = true;				
			if($row_h['po']=='N/A' || $row_h['po']=='PENDIENTE' || empty($row_h['po'])):
				
				echo 'no tiene po1 <br>';
				
				if($row_h['gr']=='N/A' || $row_h['gr']=='PENDIENTE' || empty($row_h['gr'])):
					
					echo 'no tiene gr1 <br>';
				
					if($row_h['factura']=='N/A' || $row_h['factura']=='PENDIENTE' || empty($row_h['factura'])):
						echo 'no tiene factura1 <br>';
						
						if($row_h['valor_facturado']=='N/A' || $row_h['valor_facturado']=='0.00' || empty($row_h['valor_facturado'])):
							
							echo 'no tiene valor faturado1 <br>';
						
							if($row_h['fecha_facturado1']=='0000-00-00' || empty($row_h['fecha_facturado1'])):
								echo 'no tiene fecha factura1 <br>';
								$po_fields1 = true;
							else:
								$po_fields1 = false;	
							endif;								
						else:							
							echo 'Tiene valor Factura = '.$row_h['valor_facturado'].'<br/>';
							$po_fields1 = false;	
						endif;							
					else:
						$po_fields1 = false;
					endif;
				else:
					$po_fields1 = false;
				endif;				
			else:
				$po_fields1 = false;
			endif;	
			
			if($po_fields1):
			
				$cadena .= 'po = "'.$row['po'].'", 
							gr = "'.$row['gr'].'", 
							factura = "'.$row['factura'].'", 
							valor_facturado = "'.$row['valor_facturado'].'", 
							fecha_facturado1 = "'.$row['fecha_facturado'].'",';
							
			else://pasa al segundo PO			
				//PO2
				echo 'Si tiene PO1 <br>';
				echo 'Resultado PO2 <br>';
				$po_fields2 = true;				
				if($row_h['po2']=='N/A' || $row_h['po2']=='PENDIENTE' || empty($row_h['po2'])):
					
					echo 'no tiene po2 <br>';
					
					if($row_h['gr2']=='N/A' || $row_h['gr2']=='PENDIENTE' || empty($row_h['gr2'])):
						
						echo 'no tiene gr2 <br>';
						
						if($row_h['factura2']=='N/A' || $row_h['factura2']=='PENDIENTE' || empty($row_h['factura2'])):
							if($row_h['valor_facturado2']=='N/A' || $row_h['valor_facturado2']=='0.00' || empty($row_h['valor_facturado2'])):
							
								echo 'no tiene valor factura2 <br>';
							
								if($row_h['fecha_facturado2']=='0000-00-00' || empty($row_h['fecha_facturado2'])):
									echo 'no tiene fecha facturado2 <br>';
									$po_fields2 = true;
								else:
									$po_fields2 = false;	
								endif;								
							else:
								$po_fields2 = false;	
							endif;							
						else:
							$po_fields2 = false;
						endif;
					else:
						$po_fields2 = false;
					endif;				
				else:
					$po_fields2 = false;
				endif;						
				
				if($po_fields2):
					$value_row = true;
					$cadena .= 'po2 = "'.$row['po'].'", 
								gr2 = "'.$row['gr'].'", 
								factura2 = "'.$row['factura'].'", 
								valor_facturado2 = "'.$row['valor_facturado'].'", 
								fecha_facturado2 = "'.$row['fecha_facturado'].'",';
				else://pasa al tercer PO
					echo 'Si tiene PO2 <br>';
					echo 'Resultado PO3 <br>';
					$po_fields3 = true;				
					if($row_h['po3']=='N/A' || $row_h['po3']=='PENDIENTE' || empty($row_h['po3'])):
						
						echo 'no tiene po3 <br>';
		
						if($row_h['gr3']=='N/A' || $row_h['gr3']=='PENDIENTE' || empty($row_h['gr3'])):
							
							echo 'no tiene gr3 <br>';
						
							if($row_h['factura3']=='N/A' || $row_h['factura3']=='PENDIENTE' || empty($row_h['factura3'])):
								echo 'no tiene factura3 <br>';
								
								if($row_h['valorfacturado3']=='N/A' || $row_h['valorfacturado3']=='0.00' || empty($row_h['valorfacturado3'])):
									
									echo 'no tiene valorfacturado3 <br>';
								
									if($row_h['fecha_facturado3']=='0000-00-00' || empty($row_h['fecha_facturado3'])):
										$po_fields3 = true;
									else:
										$po_fields3 = false;	
									endif;								
								else:
									$po_fields3 = false;	
								endif;							
							else:
								$po_fields3 = false;
							endif;
						else:
							$po_fields3 = false;
						endif;				
					else:
						//echo 'si tiene po3 <br>';
						$po_fields3 = false;
					endif;
					
					
					if($po_fields3):					
						$cadena .= 'po3 = "'.$row['po'].'", 
									gr3 = "'.$row['gr'].'", 
									factura3 = "'.$row['factura'].'", 
									valorfacturado3 = "'.$row['valor_facturado'].'", 
									fecha_facturado3 = "'.$row['fecha_facturado'].'",';
					else://pasa al cuarto PO	
						echo 'Si tiene PO3 <br>';
						echo 'Resultado PO4 <br>';					
						$po_fields4 = true;		
								
						if($row_h['po4']=='N/A' || $row_h['po4']=='PENDIENTE' || empty($row_h['po4'])):
							
							echo 'no tiene po4 <br>';
							
							if($row_h['gr4']=='N/A' || $row_h['gr4']=='PENDIENTE' || empty($row_h['gr4'])):
								echo 'no tiene gr4 <br>';
								
								if($row_h['factura4']=='N/A' || $row_h['factura4']=='PENDIENTE' || empty($row_h['factura4'])):	
									echo 'no tiene factura4 <br>';
									if($row_h['valorfacturado4']=='N/A' || $row_h['valorfacturado4']=='0.00' || empty($row_h['valorfacturado4'])):
									
										echo 'no tiene valorfacturado4 <br>';
										if($row_h['fecha_facturado4']=='0000-00-00' || empty($row_h['fecha_facturado4'])):
											echo 'no tiene fecha_facturado4 '.$row_h['fecha_facturado4'].' <br>';
											$po_fields4 = true;
										else:
											echo 'si tiene fecha_facturado4 '.$row_h['fecha_facturado4'].' <br>';
											$po_fields4 = false;	
										endif;								
									else:
										echo 'si tiene valorfacturado4 '.$row_h['valorfacturado4'].'<br>';
										$po_fields4 = false;	
									endif;							
								else:
									$po_fields4 = false;
								endif;
							else:
								$po_fields4 = false;
							endif;				
						else:
							echo 'Si tiene PO4 <br>';
							$po_fields4 = false;
						endif;	
						
						if($po_fields4):
							$value_row = true;
								$cadena .= 'po4 = "'.$row['po'].'",
											gr4 = "'.$row['gr'].'", 
											factura4 = "'.$row['factura'].'",
											valorfacturado4 = "'.$row['valor_facturado'].'", 
											fecha_facturado4 = "'.$row['fecha_facturado'].'",';
						else://pasa al cuarto PO	
								$enviar_registros = true;
															
								$cuerpo .= 'hito ID = '.$row['id_hito'].'<br>
											po = '.$row['po'].'<br>
											gr = '.$row['gr'].'<br> 
											factura = '.$row['factura'].'<br>
											valorfacturado = '.$row['valor_facturado'].'<br> 
											fecha_facturado = '.$row['fecha_facturado'].'<br>
											-------------------------------------------------<br>';						
						endif;//fin del cuarto PO
					endif;//fin del tercer PO
				endif;//fin del segundo PO				
			endif;//fin del primer PO	
		
		endif;
		
		
		$cadena = substr($cadena,0, -1);
		$query_update = "UPDATE hitos SET ".$cadena." WHERE id = ".$row['id_hito'];
		echo '<br>';
		
		if(!empty($cadena)):
		
			//actualizo el hito			
			mysql_query($query_update) or die("SQL Error 4: " . mysql_error().' SQL: '.$query_update);
		
			// seleccionar la mayor fecha
			$query2 = "SELECT * FROM hitos WHERE id = ".$row['id_hito'];
			$result2 = mysql_query($query2) or die("SQL Error 1: " . mysql_error().' SQL: '.$query2);
			$row_h = mysql_fetch_array($result2, MYSQL_ASSOC);
			
			$fechas = array($row_h['fecha_facturado1'],$row_h['fecha_facturado2'],$row_h['fecha_facturado3'],$row_h['fecha_facturado4']);		
			$fecha_facturado =  max($fechas); 
			
			
			//cambiar estado de las fechas
			$estado = 'FACTURADO';			
			/*if($row_h['fecha_facturado'] != '0000-00-00'):
				$estado = 'FACTURADO';
			elseif($row_h['fecha_facturacion'] != '0000-00-00' ):
				$estado = 'EN FACTURACION';
			elseif($row_h['fecha_liquidacion'] != '0000-00-00'):
				$estado = 'LIQUIDADO';
			elseif($row_h['fecha_informe'] != '0000-00-00'):
				$estado = 'INFORME ENVIADO';
			elseif($row_h['fecha_ejecutado'] != '0000-00-00'):
				$estado = 'EJECUTADO';
			elseif($row_h['fecha_inicio_ejecucion'] != '0000-00-00'):
				$estado = 'EN EJECUCION';
			else:
				$estado = 'PENDIENTE';
			endif;*/
			
			$cadena2 = '';
			if($row_h['fecha_liquidacion'] == '0000-00-00'):
				$cadena2 =  ' fecha_liquidacion = "'.$row_h['fecha_facturado1'].'", ';  
			endif;
		 
			
			//volver actualizar el hito por la fecha facturado
			$query_update = "UPDATE hitos SET ".$cadena2." fecha_facturado = '".$fecha_facturado."', estado = '".$estado."' WHERE id = ".$row['id_hito'];
			mysql_query($query_update) or die("SQL Error 1: " . mysql_error().' SQL: '.$query_update);
		
		endif;
				
	endwhile;
	
	
	if($enviar_registros):
		
		echo $cuerpo;
		
		$mail = new PHPMailer();
		$mail->Host = "localhost";
		$mail->From = 'noreply@operacionesignsas.com';
		$mail->FromName = 'Administrador Signsas';
		$mail->Subject = 'Registros no aplicados';
		$mail->AddAddress('ricardo.hernandez@signsas.com,juliana.morales@signsas.com,asistente.financiero@signsas.com,fanny.vergara@signsas.com');
		$mail->Body = $cuerpo;
		$mail->IsHTML(true);
		$mail->CharSet = 'ISO-8859-1';
		if(!$mail->Send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} 
	endif;
	
	exit;
	
	$query = "TRUNCATE hitos_upload";
	$result = mysql_query($query) or die("SQL Error 1: " . mysql_error());
	

?>