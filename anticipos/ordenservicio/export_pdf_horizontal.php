<?php

	header('Content-type: text/html; charset=iso-8859-1');

	if(empty($_GET['ide_per'])){
		echo "Por favor no altere el fuente";
		exit;
	}

	include "../extras/php/basico.php";
	include "../../conexion.php";	


	$sql = sprintf("select * from orden_servicio where id=%d",
		(int)$_GET['ide_per']
	);

	$per = mysql_query($sql);
	$num_rs_per = mysql_num_rows($per);
	if ($num_rs_per==0){
		echo "No existen OS con ese ID";
		exit;
	}  
	$rs_per = mysql_fetch_assoc($per);

	

	$letters = array('.');
	$fruit   = array('');		


	$acpm = 0;
	$valor_transporte = 0;
	$toes = 0;
	$total_acpm = 0;
	$total_transpornte = 0;
	$total_toes = 0;
	$total_anticipo = 0;
	$giro = 0;


//<img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/> .(int)$_GET['ide_per'].
$mensaje = '

	<div style="clear:both"></div>
	
	<br />

	<table width="900" border="1" >

        	 <tr>

			 	<td style="font-weight:bold; width:600px;" align=center colspan="2">ORDEN DE SERVICIO PARA CONTRATISTA <br> 
    SERVICIO DE INGENIERIA SIGN<br> 
    NIT.900.391.449-4<br> 
    TEL:8052717-3174394001<br> 
    andrea.rojas@signsas.com-asistente.compras@ts-sas.com</td>

                <td style="font-weight:bold; width:450px;" align=center colspan="2"><img src="http://operacionsign.com/logo_sign.png"  style="float:left;"/></td>

                
            </tr> 
		<tr>
			<td width="100" align=center style="font-weight:bold;">ID.</td>
			<td width="281" align=left>'.(int)$_GET['ide_per'].'</td>
			<td width="81" align=center style="font-weight:bold;">FECHA.</td>
			<td width="255" align=left>'.$rs_per['fecha_create'].'</td>
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
    <td width="55"  style="font-weight:bold;" >NOMBRE:</td>
	 <td  width="281" >'.$rs_per['nombre_contratista'].'</td>
	  <td  width="81"style="font-weight:bold;" >CC/NIT:</td>
	   <td width="255">'.$rs_per['cedula_contratista'].'</td>
   </tr>
   <tr>
    <td width="55" style="font-weight:bold;" >TELEFONO:</td>
	 <td width="281">'.$rs_per['telefono_contratista'].'</td>
	  <td width="81" style="font-weight:bold;" >REGIMEN:</td>
	   <td   width="255">'.$rs_per['regimen_contratista'].'</td>
   </tr>
   <tr>
    <td width="55" style="font-weight:bold;" >EMAIL:</td>
	 <td width="281">'.$rs_per['correo_contratista'].'</td>
	  <td width="81"style="font-weight:bold;" >DIRECCION:</td>
	   <td width="255" >'.$rs_per['direccion_contratista'].'</td>
   </tr>
  
   <tr>
    	<td width="75" style="font-weight:bold;" >No.CONTRATO:</td>
	 	<td width="261">'.$rs_per['num_contrato_contratista'].'</td>
	 	<td width="81" style="font-weight:bold;" >POLIZA:</td>
	   	<td width="255" >'.$rs_per['poliza_contratista'].'</td>
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
    <td width="75" style="font-weight:bold;" >REGIONAL:</td>
	 <td width="261" >';
                    $sqlPry = "SELECT * FROM regional WHERE id =".$rs_per['id_regional']; 

                    $qrPry = mysql_query($sqlPry);

					$rsPry = mysql_fetch_array($qrPry);
                    $mensaje .= $rsPry['region'].'</td>
	  <td style=" border: hidden" ></td>
	   <td style=" border: hidden"></td>
   </tr> 
   <tr>
    <td width="105"  style="font-weight:bold;" >COORDINADOR:</td>
	 <td  width="231" >'.$rs_per['nombre_responsable'].'</td>
	  <td  width="81"style="font-weight:bold;" >CEDULA:</td>
	   <td width="255">'.$rs_per['cedula_responsable'].'</td>
   </tr>  ';


$sqlPry = "SELECT * FROM linea_negocio WHERE id=".$rs_per['id_centroscostos']; 
$qrPry = mysql_query($sqlPry);
$rsPry = mysql_fetch_array($qrPry);


$centro_costo = $rsPry['codigo'].'-'.$rsPry['nombre'];



$sqlPry = "SELECT * FROM orden_trabajo WHERE id_proyecto = ".$rs_per['id_ordentrabajo']; 

$qrPry = mysql_query($sqlPry);

$rsPry = mysql_fetch_array($qrPry);

$orden_trabajo = $rsPry['orden_trabajo'];



$sqlPry = "SELECT * FROM beneficiarios WHERE identificacion='".$rs_per['cedula_consignar']."'"; 

$qrPry = mysql_query($sqlPry);

$row_bene = mysql_fetch_array($qrPry);

			

 $mensaje .= '
   <tr>
    	<td width="55"  style="font-weight:bold;" >CENTRO DE COSTO:</td>
	 	<td  width="281" >'.$centro_costo.'</td>
	  	<td  width="81"style="font-weight:bold;" >OT:</td>
	   	<td width="255">'.$orden_trabajo.'</td>
   </tr>
   <tr>
    	<td width="55"  style="font-weight:bold;" >FECHA DE INICIO:</td>
	 	<td  width="281" >'.$rs_per['fecha_inicio'].'</td>
	  	<td  width="81"style="font-weight:bold;" >FECHA FINAL:</td>
	   	<td width="255">'.$rs_per['fecha_terminado'].'</td>
   </tr>  
    
    
   </table>       
   
   <br/>

	<table width="700" border="1">
	 	<tr>
			<td colspan="8" style=" border: hidden"></td>
	  	</tr>
	  	<tr>
			<td colspan="8" style="font-weight:bold;">LISTADO DE ITEM</td>
	  	</tr>
	  	<tr>
			<td width="50" style="font-weight:bold;">ID HITO</td>
			<td style="font-weight:bold;">HITO</td>
			<td width="77" style="font-weight:bold;">p_o/TIKET</td>
			<td style="font-weight:bold;">DESCRIPCI&Oacute;N</td>
			<td width="60" style="font-weight:bold;">FORMA PAGO</td>
			<td width="41" style="font-weight:bold;">CANT</td>
			<td width="100" style="font-weight:bold;">VR.UNITARIO</td>
			<td width="104" style="font-weight:bold;">VR.TOTAL</td>
  		</tr>';

		$sql = "SELECT *, i.id AS ID, i.id_hitos AS idHitos, i.estado AS estado_anti, h.estado AS estado_hito, i.descripcion AS descripcion_os, h.nombre AS nombre_hito   
         FROM items_ordenservicio AS i
         LEFT JOIN hitos AS h ON  h.id = i.id_hitos 
         WHERE i.id_ordenservicio = ".$_GET['ide_per']." AND i.estado IN(0,2)
         ORDER BY i.id DESC";
					
		$resultado = mysql_query($sql) or die(mysql_error());
		$total = mysql_num_rows($resultado);
		   			 

		if($total > 0):

			while($row = mysql_fetch_assoc($resultado)):

            	$total=$row['cantidad']*$row['valor_unitario'];

				$mensaje .= '<tr>
							  <td>'.$row['id_hitos'].'</td>
							  
							  <td style="width:320px; word-wrap:break-word;">'.$row['nombre_hito'].'</td>
							  
							  <td>'.$row['po_ticket'].'</td>
							  <td style="width:235px; word-wrap:break-word;">'.$row['descripcion_os'].'</td> 
							  <td style="width:60px; word-wrap:break-word;">'.$row['forma_pago'].'</td>
							  <td>'.$row['cantidad'].'</td>
							  <td align="right">$'.$row['valor_unitario'].'</td> 
							  <td align="right">$'.$total.'.00</td>
						   	</tr> ';

//$mensaje .= '</table>';
         
           	endwhile; 
		endif;
		
	  $result = mysql_query("SELECT SUM(total) as total FROM items_ordenservicio WHERE id_ordenservicio = ".$_GET['ide_per']."");	
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
				<td colspan="6"></td>			
				<td>TOTAL BRUTO</td>
				<td align="right">$'.$row["total"].'</td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td>'.$ivap.'%</td>
				<td>IVA</td>
				<td align="right">$'.$iva.',00</td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td>'.$ica.'%</td>
				<td>ICA</td>
				<td align="right">$'.$icap.',00</td>
			</tr>
			<tr>
				<td colspan="5"></td>
				<td>'.$rtefuente.'%</td>
				<td>RETENCION</td>
				<td align="right">$'.$rtefuentep.',00</td>
			</tr>
			<tr>
				<td colspan="6"> </td>
				<td>NETO</td>
				<td align="right">$'.$total.',00</td>
			</tr>';
					
		$mensaje .= ' 
		</table>';
 
 
		$mensaje .=  '
					<br>
					<br>
					
		<table  border="1">
		  <tr>
			<td colspan="3" width="1065">NOTA: <br/><br/></td>
		  </tr>
		  <tr>
			<td>ELABORADO: <br/>ANDREA DEL MAR ROJAS</td>
			<td>COORDINADOR:<br/><br/></td>
			<td>APROBADO: <br/>RAFAEL ERNESTO CADENA</td>
		  </tr>
		</table>';

	
	require_once('/home/operacionsign/public_html/anticipos/anticipo/html2pdf.class.php');
	try
    {

        $html2pdf = new HTML2PDF('P', 'A4', 'es');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->WriteHTML($mensaje);
        $html2pdf->Output('Anticipo_ID_'.(int)$_GET['ide_per'].'.pdf');
		exit;
    }

    catch(HTML2PDF_exception $e) {
		echo $e;
        exit;
    }


?>



