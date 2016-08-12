<?
	include "../../conexion.php";
	include "../extras/php/basico.php";
	
	/* estado de los items anticipo
		0 -> agregado
		1 -> eliminado
		2 -> aprobado
	*/
	
	$obj = new TaskCurrent;	
	
	/*verificamos si las variables se envian*/
	if(empty($_GET['id_orden'])){
		echo "Debe Ingresar la id de Orden";
		exit;
	}
	
	$sql = "UPDATE `orden_servicio` SET `aprobado`= 1 WHERE `id`= ".$_GET['id_orden'];
	if(!mysql_query($sql)){
		echo json_encode(array('estado'=>false, 'message'=>"Error al aprobar la OS:\n$sql"));
		exit;
	}
		
	$sql2 = "UPDATE `items_ordenservicio` SET `estado` = 2 WHERE estado = 0 AND id_ordenservicio = ".$_GET['id_orden'];
	if(!mysql_query($sql2)){

		echo json_encode(array('estado'=>false, 'message'=>"Error al actualizar los items OS:\n$sql"));
		exit;
	}
			
	$sqlc = mysql_query("SELECT * FROM orden_servicio WHERE `id`= ".$_GET['id_orden']) or die("Problemas en la base de datos:".mysql_error());
	$rs_per = mysql_fetch_array($sqlc);	
	
	//envio al contratista		
	if(!$obj->getValidateExcepcionOS($rs_per['id_ordentrabajo']))
		$para = $rs_per['correo_contratista'].','; 

	// subject
	$titulo = 'Aprobado Orden de Servicio  #'.(int)$_GET['id_orden'];
	$letters = array('.');
	$fruit   = array('');		

	$mensaje = ' 
	  <br />	  
	  <table border="1" width="1000" align="center" cellspacing="10">
	  
		  <tr>			  
			  <td style="font-weight:bold;" align=center colspan="2">
				  ORDEN DE SERVICIO PARA CONTRATISTA 				
				  <br> 
				  SERVICIO DE INGENIERIA SIGN<br> 
				  NIT.900.391.449.4<br> 
				  TEL:8052717-3174394001<br> 
				  andrea.rojas@signsas.com;asistente.compras@ts-sas.com
			  </td>
			  
			  <td align=center colspan="2" >
				  <img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/>
			  </td>				  
		  </tr> 
		  <tr>
			  <td width="55" align=center style="font-weight:bold;">ID.</td>
			  <td width="160" align=left>'.(int)$_GET['id_orden'].'</td>
			  <td width="81" align=center style="font-weight:bold;">FECHA.</td>
			  <td width="100" align=left>'.$rs_per['fecha_create'].'</td>
		  </tr> 
		  <tr>
			  <td colspan="4" style=" border: hidden"></td>
		  </tr>
		  <tr>
			  <td colspan="4" style="font-weight:bold;">CONTRATISTA</td>
		  </tr>
		  <tr>
			  <td colspan="4" style=" border: hidden"></td>
		  </tr>
		  <tr>
			  <td width=""  style="font-weight:bold;" >NOMBRE:</td>
			  <td  width="" >'.$rs_per['nombre_contratista'].'</td>
			  <td  width="" style="font-weight:bold;" >CC/NIT:</td>
			  <td width="">'.$rs_per['cedula_contratista'].'</td>
		  </tr>
		  <tr>
			  <td width="" style="font-weight:bold;" >TELEFONO:</td>
			  <td width="">'.$rs_per['telefono_contratista'].'</td>
			  <td width="" style="font-weight:bold;" >REGIMEN:</td>
			  <td width="">'.$rs_per['regimen_contratista'].'</td>
		  </tr>
		  <tr>
			  <td width="" style="font-weight:bold;" >EMAIL:</td>
			  <td width="">'.$rs_per['correo_contratista'].'</td>
			  <td width="" style="font-weight:bold;" >DIRECCION:</td>
			  <td width="">'.$rs_per['direccion_contratista'].'</td>
		  </tr>
		  <tr>
			  <td width="" style="font-weight:bold;" >SALDO ACUMULADO:</td>
			  <td width="" >$'.$rs_per['observaciones_contratista'].'</td>
		  </tr>
		  <tr>
			  <td width="" style="font-weight:bold;" >No.Contrato:</td>
			  <td width="">'.$rs_per['num_contrato_contratista'].'</td>
			  <td width="" style="font-weight:bold;" >POLIZA:</td>
			  <td width="">'.$rs_per['poliza_contratista'].'</td>
		  </tr>
		  <tr>
			  <td colspan="4" style=" border: hidden"></td>
		  </tr>
		  <tr>
			  <td colspan="4" style="font-weight:bold;">RESPONSABLE</td>
		  </tr>
		  <tr>
			  <td colspan="4" style=" border: hidden"></td>
		  </tr>
		  <tr>
			  <td width="" style="font-weight:bold;" >REGIONAL:</td>
			  <td width="" >';
				$idregional = $rs_per['id_regional'];
				$sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 		  
				$qrPry = mysql_query($sqlPry);		  
				$rsPry = mysql_fetch_array($qrPry);
					  
				$mensaje .= $rsPry['region'].'</td>
			  <td style=" border: hidden" ></td>
			  <td style=" border: hidden"></td>
		  </tr> 
		  <tr>
			  <td width=""  style="font-weight:bold;" >COORDINADOR:</td>
			  <td  width="" >'.$rs_per['nombre_responsable'].'</td>
			  <td  width="" style="font-weight:bold;" >CEDULA:</td>
			  <td width="">'.$rs_per['cedula_responsable'].'</td>
		  </tr>  ';
  
  
		  $sqlPry = "SELECT * FROM centros_costos WHERE id=".$rs_per['id_centroscostos']; 
		  $qrPry = mysql_query($sqlPry);
		  $rsPry = mysql_fetch_array($qrPry);
		  
  
		  $centro_costo = $rsPry['sigla'].'/'.$rsPry['nombre'];
  
		  $sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto = ".$rs_per['id_ordentrabajo']; 
		  $qrPry = mysql_query($sqlPry);
		  $rsPry = mysql_fetch_array($qrPry);
		  $orden_trabajo = $rsPry['orden_trabajo'];
  
  
		  $sqlPry = "SELECT * FROM beneficiarios WHERE identificacion='".$rs_per['cedula_consignar']."'"; 	  
		  $qrPry = mysql_query($sqlPry);
		  $row_bene = mysql_fetch_array($qrPry);
  
		  
  
  $mensaje .= '
	  <tr>
		  <td width=""  style="font-weight:bold;" >CENTRO DE COSTO:</td>
		  <td  width="" >'.$centro_costo.'</td>
		  <td  width="" style="font-weight:bold;" >OT:</td>
		  <td width="">'.$orden_trabajo.'</td>
	  </tr>
	  <tr>
		  <td width=""  style="font-weight:bold;" >FECHA DE INICIO:</td>
		  <td  width="" >'.$rs_per['fecha_inicio'].'</td>
		  <td  width="" style="font-weight:bold;" >FECHA FINAL:</td>
		  <td width="">'.$rs_per['fecha_terminado'].'</td>
	  </tr>  
  
	  <tr>
		  <td colspan="5" style=" border: hidden"></td>
	  </tr>
	  
  </table>';
  
  
  $mensaje .=  '
	  
  <br>
	  
  <table border="1" width="1000" align="center" cellspacing="10">
  
		<tr>
			<td colspan="7" style=" border: hidden"></td>
		</tr>
		<tr>
			<td colspan="7" style="font-weight:bold;">LISTADO DE ITEM</td>
		</tr>
		<tr>
			<td width="70" style="font-weight:bold;">ID HITO</td>
			<td width="41" style="font-weight:bold;">HITO</td>
			<td width="77" style="font-weight:bold;">p_o/TIKET</td>
			<td width="200" style="font-weight:bold;">DESCRIPCI&Oacute;N</td>
			<td width="90" style="font-weight:bold;">FORMA PAGO</td>
			<td width="41" style="font-weight:bold;">CANT</td>
			<td width="100" style="font-weight:bold;">VR.UNITARIO</td>
			<td width="104" style="font-weight:bold;">VR.TOTAL</td>
		</tr>';

  
  //Lista de items
  $sql = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito, i.descripcion AS descripcion_os, h.nombre AS nombre_hito  
		 FROM items_ordenservicio AS i
		 LEFT JOIN hitos AS h ON  h.id = i.id_hitos 
		 WHERE i.id_ordenservicio = ".$_GET['id_orden']." AND i.estado IN(2)
		 ORDER BY i.id DESC";
				  
  $resultado = mysql_query($sql) or die(mysql_error());
  $total = mysql_num_rows($resultado);
   
  
  if($total > 0):
  
	  while($row = mysql_fetch_assoc($resultado)):
  
		  $total=$row['cantidad']*$row['valor_unitario'];
  
		  $mensaje .= '<tr>
						<td>'.$row['id_hitos'].'</td>
						<td>'.$row['nombre_hito'].'</td>
						<td>'.$row['po_ticket'].'</td>
						<td style="width:160px;word-wrap: break-word;">'.$row['descripcion'].'</td> 							<td>'.$row['forma_pago'].'</td>
						<td>'.$row['cantidad'].'</td>
						<td>$'.$row['valor_unitario'].'</td> 
						<td>$'.$total.'.00</td>
					  </tr> ';
	  endwhile; 
  endif;
  
  $result = mysql_query("SELECT SUM(total) as total FROM items_ordenservicio 
  						 WHERE estado IN(2) AND id_ordenservicio = ".$_GET['id_orden']);	
  $row = mysql_fetch_array($result, MYSQL_ASSOC);
  
  $impuesto = unserialize($rs_per['impuesto_os']);	
  
   if(is_array($impuesto)):
	  $iva = $impuesto[0]['iva'];
	  $ica = $impuesto[0]['ica'];
	  $rtefuente = $impuesto[0]['rtefuente'];
	  
	  $ivap = $iva * 100 / $impuesto[0]["valor_neto_total"];
	  
	  //valorIca = parseInt(valorNeto * (ica/1000));
	  $icap = round($impuesto[0]['valor_neto_total'] * ($impuesto[0]['ica']/1000));
	  $rtefuentep = round($impuesto[0]['valor_neto_total'] * ($impuesto[0]['rtefuente']/100));
	  
	  $total = $impuesto[0]['totalconimpuesto'];
  endif; 
				   
  $mensaje .= '
			<tr>
				<td colspan="4" style=" border: hidden"></td>
				<td>TOTAL BRUTO</td>
				<td>$'.$row["total"].'</td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td>'.$iva.'%</td>
				<td>IVA</td>
				<td align="right">$'.$ivap.'.00</td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td>'.$ica.'%</td>
				<td>ICA</td>
				<td align="right">$'.$icap.'.00</td>
			</tr>
			<tr>
				<td colspan="4"></td>
				<td>'.$rtefuente.'%</td>
				<td>RETENCION</td>
				<td align="right">$'.$rtefuentep.'.00</td>
			</tr>
			<tr>
				<td colspan="5"> </td>
				<td>NETO</td>
				<td align="right">$'.$total.'.00</td>
			</tr>
	  </table>
  ';
			  
  //Footer del pdf
  
  $mensaje .=  '
		  <br>		
		  <table border="1" width="1000" align="center" cellspacing="10">				
				  <tr>
					<td colspan="3" style="height:50px;">NOTA:</td>
				  </tr>
				  <tr>
					<td width="205">ELABORADO: <br>ANDREA DEL MAR ROJAS</td>
					<td width="205">CONTABILIZADO: <div style="height:40px; width:10px;"></div></td>
					<td width="205">APROBADO: <br>RAFAEL ERNESTO CADENA</td>
				  </tr>
		  </table>';
	//echo $mensaje;

	$sql5 = "SELECT email FROM `usuario` WHERE `id_regional` LIKE '".$rs_per['id_regional']."%'"; 
	$result5 = mysql_query($sql5);		
		
	while($row5 = mysql_fetch_array($result5, MYSQL_ASSOC)):
		$para .= $row5['email'].','; 
	endwhile;
	
	$para .= 'andrea.rojas@signsas.com,asistente.compras@ts-sas.com';			

	// Para enviar un correo HTML, debe establecerse la cabecera Content-type
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	mail($para, $titulo, $mensaje, $cabeceras);		
	
	echo json_encode(array('estado'=>true));
	
	exit;

?>